<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
public function index()
    {
    $tweets = Tweet::with(['user' => function($query) {
            $query->withCount(['followers', 'followings']);
        }])
        ->latest()
        ->paginate(10);
    
    return view('timeline', compact('tweets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:280',
        ]);

        // Simpan tweet
        Tweet::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Redirect ke timeline dengan pesan sukses
        return redirect()->route('timeline')->with('success', 'Tweet created successfully!');
    }

        public function edit(Tweet $tweet)
    {
        // Pastikan hanya pemilik tweet yang dapat mengedit tweet
        if ($tweet->user_id !== Auth::id()) {
            return redirect()->route('timeline')->with('error', 'You are not authorized to edit this tweet.');
        }

        return view('tweets.edit', compact('tweet'));
    }

    public function update(Request $request, Tweet $tweet)
    {
        // Pastikan hanya pemilik tweet yang dapat mengedit tweet
        if ($tweet->user_id !== Auth::id()) {
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
        if ($tweet->user_id !== Auth::id()) {
            return redirect()->route('timeline')->with('error', 'You are not authorized to delete this tweet.');
        }

        // Hapus tweet
        $tweet->delete();

        return redirect()->route('timeline')->with('success', 'Tweet deleted successfully!');
    }
}
