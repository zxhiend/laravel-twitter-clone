<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Hashtag;
use App\Models\TrendingPhrase;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Scout\Builder;

class TweetController extends Controller
{
    public function index()
    {
        // Query untuk semua tweet
        $allTweets = Tweet::with(['user' => function($query) {
                $query->withCount(['followers', 'followings']);
            }])
            ->latest()
            ->paginate(10);
        // Query untuk tweet yang difollow (jika user logged in)
        $followingTweets = collect();
        if (auth()->check()) {
            $followingIds = auth()->user()->followings()->pluck('users.id');
            $followingTweets = Tweet::whereIn('user_id', $followingIds)
                ->with(['user' => function($query) {
                    $query->withCount(['followers', 'followings']);
                }])
                ->latest()
                ->paginate(10);
        }
        // Get trends for sidebar (hashtags and phrases)
        $trends = collect();
        $hashtagTrends = Hashtag::orderByDesc('count')->limit(10)->get()->map(function($h) {
            return [
                'type' => 'hashtag',
                'value' => $h->tag,
                'count' => $h->count
            ];
        })->values();
        $phraseTrends = TrendingPhrase::where('count', '>=', 5)->orderByDesc('count')->limit(10)->get()->map(function($p) {
            return [
                'type' => 'phrase',
                'value' => $p->phrase, // only the main word is stored
                'count' => $p->count
            ];
        })->values();
        $trends = collect($hashtagTrends)->merge($phraseTrends)->sortByDesc('count')->take(10)->values();
        return view('timeline', [
            'allTweets' => $allTweets,
            'followingTweets' => $followingTweets,
            'trends' => $trends
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $tab = $request->input('tab', 'top');
        $results = collect();
        $users = collect();
        if ($query) {
            if ($tab === 'people') {
                $users = User::where('name', 'like', "%$query%")
                    ->orWhere('username', 'like', "%$query%")
                    ->get();
            } else {
                $results = Tweet::search($query, function($meili, $query, $options) {
                    $options['matchingStrategy'] = 'all';
                    return $meili->search($query, $options);
                })->get();
                $results->load('user');
                if ($tab === 'latest') {
                    $results = $results->sortByDesc('created_at');
                }
            }
        }
        // Get trends for sidebar (same as timeline)
        $hashtagTrends = Hashtag::orderByDesc('count')->limit(10)->get()->map(function($h) {
            return [
                'type' => 'hashtag',
                'value' => $h->tag,
                'count' => $h->count
            ];
        })->values();
        $phraseTrends = TrendingPhrase::where('count', '>=', 5)->orderByDesc('count')->limit(10)->get()->map(function($p) {
            return [
                'type' => 'phrase',
                'value' => $p->phrase, // only the main word is stored
                'count' => $p->count
            ];
        })->values();
        $trends = collect($hashtagTrends)->merge($phraseTrends)->sortByDesc('count')->take(10)->values();
        return view('tweets.search', compact('results', 'query', 'trends', 'tab', 'users'));
    }

    public function trends()
    {
        $trends = Hashtag::orderByDesc('count')->limit(10)->get();
        return view('tweets.trends', compact('trends'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $tweet = $request->user()->tweets()->create($validated);

        // Extract hashtags and update counts
        $hashtags = $tweet->extractHashtags();
        $content = trim($tweet->content);
        if (count($hashtags) > 0) {
            foreach ($hashtags as $tag) {
                Hashtag::updateOrCreate(
                    ['tag' => strtolower($tag)],
                    ['count' => \DB::raw('count + 1')]
                );
            }
        } else {
            // Only track non-hashtag phrase if it's not empty
            $mainPhrase = $tweet->extractTrendingPhrase();
            if (!empty($mainPhrase)) {
                $trending = TrendingPhrase::firstOrNew(['phrase' => $mainPhrase]);
                $trending->count = ($trending->count ?? 0) + 1;
                $trending->save();
            }
        }

        return redirect()->route('timeline')->with('success', 'Tweet posted!');
    }


    public function edit(Tweet $tweet)
    {
        // Pastikan hanya pemilik tweet yang dapat mengedit tweet
        if ($tweet->user_id !== auth()->id()) {
            return redirect()->route('timeline')->with('error', 'You are not authorized to edit this tweet.');
        }

        return view('tweets.edit', compact('tweet'));
    }

    public function update(Request $request, Tweet $tweet)
    {
        // Pastikan hanya pemilik tweet yang dapat mengedit tweet
        if ($tweet->user_id !== auth()->id()) {
            return redirect()->route('timeline')->with('error', 'You are not authorized to update this tweet.');
        }

        $request->validate([
            'content' => 'required|max:280',
        ]);

        // Update tweet
        $tweet->update([
            'content' => $request->content,
        ]);

        return redirect()->route('timeline')->with('success', 'Tweet updated successfully!');
    }

     public function destroy(Tweet $tweet)
    {
        // Pastikan hanya pemilik tweet yang bisa menghapus tweet
        if ($tweet->user_id !== auth()->id()) {
            return redirect()->route('timeline')->with('error', 'You are not authorized to delete this tweet.');
        }

        // Decrement hashtag counts and remove if zero
        $hashtags = $tweet->extractHashtags();
        $content = trim($tweet->content);
        if (count($hashtags) > 0) {
            foreach ($hashtags as $tag) {
                $hashtag = Hashtag::where('tag', strtolower($tag))->first();
                if ($hashtag) {
                    $hashtag->count = max(0, $hashtag->count - 1);
                    if ($hashtag->count === 0) {
                        $hashtag->delete();
                    } else {
                        $hashtag->save();
                    }
                }
            }
        } else {
            // Decrement phrase count but do not delete, just keep count
            $mainPhrase = $tweet->extractTrendingPhrase();
            if (!empty($mainPhrase)) {
                $trending = TrendingPhrase::where('phrase', $mainPhrase)->first();
                if ($trending) {
                    $trending->count = max(0, $trending->count - 1);
                    $trending->save();
                }
            }
        }

        // Hapus tweet
        $tweet->delete();

        return redirect()->route('timeline')->with('success', 'Tweet deleted successfully!');
    }
}
