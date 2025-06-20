<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Like;
use App\Models\Retweet;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    // Like/Unlike a tweet
    public function like($tweet_id)
    {
        $tweet = Tweet::findOrFail($tweet_id);
        $user = Auth::user();

        if ($tweet->isLikedBy($user)) {
            $tweet->likes()->where('user_id', $user->id)->delete();
        } else {
            $like = new Like;
            $like->user_id = $user->id;
            $tweet->likes()->save($like);
        }

        return redirect()->back();
    }

    // Retweet/Unretweet a tweet
    public function retweet($tweet_id)
    {
        $tweet = Tweet::findOrFail($tweet_id);
        $user = Auth::user();

        if ($tweet->isRetweetedBy($user)) {
            $tweet->retweets()->where('user_id', $user->id)->delete();
        } else {
            // Check if user has already retweeted this
            if ($tweet->retweets()->where('user_id', $user->id)->exists()) {
                return redirect()->back();
            }

            $retweet = new Retweet;
            $retweet->user_id = $user->id;
            $tweet->retweets()->save($retweet);
        }

        return redirect()->back();
    }

    // Bookmark/Unbookmark a tweet
    public function bookmark($tweet_id)
    {
        $tweet = Tweet::findOrFail($tweet_id);
        $user = Auth::user();

        if ($tweet->isBookmarkedBy($user)) {
            $tweet->bookmarks()->where('user_id', $user->id)->delete();
        } else {
            $bookmark = new Bookmark;
            $bookmark->user_id = $user->id;
            $tweet->bookmarks()->save($bookmark);
        }

        return redirect()->back();
    }

    // Get user's bookmarked tweets
    public function bookmarkView()
    {
        $user = Auth::user();
        $bookmarks = Bookmark::with(['tweets.user', 'tweets.likes', 'tweets.retweets', 'tweets.replies'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('bookmarks.index', [
            'bookmarks' => $bookmarks,
            'user' => $user,
        ]);
    }
}
