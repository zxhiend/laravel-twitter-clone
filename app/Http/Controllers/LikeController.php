<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tweet_id' => 'required|exists:tweets,id',
        ]);
        Like::create([
            'user_id' => auth()->id(),
            'tweet_id' => $request->tweet_id,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $tweet_id)
    {
        $like = Tweet::findOrFail($tweet_id)->likes()->where('user_id', auth()->id())->first();
        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }
}
