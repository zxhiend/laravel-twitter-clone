<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Follow a user
     */
    public function follow(User $user)
    {
        $result = auth()->user()->follow($user);
        
        return back()->with($result['status'], $result['message']);
    }

    /**
     * Unfollow a user
     */
    public function unfollow(User $user)
    {
        $result = auth()->user()->unfollow($user);
        
        return back()->with($result['status'], $result['message']);
    }

    /**
     * Get user's followers
     */
    public function followers(User $user)
    {
        $followers = $user->followers()
                        ->withCount(['followers', 'followings'])
                        ->paginate(10);
        
        return view('users.followers', [
            'user' => $user,
            'followers' => $followers,
            'count' => $user->followersCount()
        ]);
    }

    /**
     * Get users that the user is following
     */
    public function followings(User $user)
    {
        $followings = $user->followings()
                        ->withCount(['followers', 'followings'])
                        ->paginate(10);
        
        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
            'count' => $user->followingCount()
        ]);
    }
}
