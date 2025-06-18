<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::withCount(['followers', 'followings'])
                  ->where('username', $username)
                  ->firstOrFail();
        
        $tweets = $user->tweets()
                      ->with(['user' => function($query) {
                          $query->withCount(['followers', 'followings']);
                      }])
                      ->latest()
                      ->paginate(10);
        
        return view('profiles.show', [
            'user' => $user,
            'tweets' => $tweets,
            'isFollowing' => auth()->check() && auth()->user()->isFollowing($user),
            'isCurrentUser' => auth()->check() && auth()->id() === $user->id
        ]);
    }
}