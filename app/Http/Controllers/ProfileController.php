<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::withCount(['followers', 'followings'])
            ->where('username', $username)
            ->firstOrFail();

        $tweets = $user->tweets()
            ->with(['user' => function ($query) {
                $query->withCount(['followers', 'followings']);
            }])
            ->latest()
            ->paginate(10);
        $retweets = $user->retweets->transform(function ($tweet) {
            $tweet->retweeted_by = Auth::user()->name;
            return $tweet;
        });
        $tweets = $tweets->merge($retweets);
        $likedTweets = $user->likes;

        return view('profiles.show', [
            'user' => $user,
            'tweets' => $tweets,
            'likedTweets' => $likedTweets,
            'isFollowing' => Auth::check() && Auth::user()->isFollowing($user),
            'isCurrentUser' => Auth::check() && Auth::id() === $user->id,
        ]);
    }

    public function edit()
    {
        return view('profiles.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request, $username)
    {
        $user = Auth::user();

        // Verifikasi username route match dengan user yang login
        if ($user->username !== $username) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:160',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
            // Username dihapus dari data yang diupdate
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile', $user->username)
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
