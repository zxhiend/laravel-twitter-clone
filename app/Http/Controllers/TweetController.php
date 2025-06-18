<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $followingIds = auth()->user()->followings()->pluck('users.id'); // Perbaikan disini
            $followingTweets = Tweet::whereIn('user_id', $followingIds)
                ->with(['user' => function($query) {
                    $query->withCount(['followers', 'followings']);
                }])
                ->latest()
                ->paginate(10);
        }
        
        return view('timeline', [
            'allTweets' => $allTweets,
            'followingTweets' => $followingTweets
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $tweet = $request->user()->tweets()->create($validated);

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

        // Hapus tweet
        $tweet->delete();

        return redirect()->route('timeline')->with('success', 'Tweet deleted successfully!');
    }
}
