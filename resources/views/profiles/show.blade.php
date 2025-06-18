@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Profil yang Diperbaiki -->
    <div class="profile-header mb-5 p-4 bg-white rounded shadow-sm">
        <div class="d-flex align-items-start">
            <!-- Foto Profil -->
            <div class="mr-4" style="flex-shrink: 0;">
                <img src="{{ $user->avatar_url }}" 
                     class="rounded-circle border border-4 border-white shadow" 
                     width="120" 
                     height="120"
                     alt="{{ $user->name }}"
                     style="object-fit: cover;">
            </div>
            
            <!-- Informasi Profil -->
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="font-weight-bold mb-1">{{ $user->name }}</h2>
                        <p class="text-muted mb-3">{{ $user->username }}</p>
                    </div>
                    
                    <!-- Tombol Follow/Edit Profil -->
                    @auth
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('profile.edit', auth()->user()->username) }}" class="btn btn-outline-primary">
                                Edit Profil
                        </a>
                        @else
                            <form action="{{ route(auth()->user()->isFollowing($user) ? 'unfollow' : 'follow', $user) }}" method="POST">
                                @csrf
                                @if(auth()->user()->isFollowing($user))
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="btn {{ auth()->user()->isFollowing($user) ? 'btn-outline-secondary' : 'btn-primary' }}">
                                    {{ auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
                
                <!-- Bio (opsional) -->
                @if($user->bio)
                    <p class="mb-3">{{ $user->bio }}</p>
                @endif
                
                <!-- Followers & Following -->
                <div class="d-flex mb-2">
                    <a href="{{ route('followings', $user) }}" class="text-dark mr-4">
                        <strong class="h5">{{ $user->followings_count }}</strong> 
                        <span class="text-muted">Following</span>
                    </a>
                    <a href="{{ route('followers', $user) }}" class="text-dark">
                        <strong class="h5">{{ $user->followers_count }}</strong> 
                        <span class="text-muted">Followers</span>
                    </a>
                </div>
                
                <!-- Info Tambahan (opsional) -->
                <div class="text-muted small">
                    @if($user->location)
                        <span class="mr-3"><i class="fas fa-map-marker-alt"></i> {{ $user->location }}</span>
                    @endif
                    <span><i class="far fa-calendar-alt"></i> Joined {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Tweet -->
    <div class="tweets">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Tweets</h5>
            </div>
            
            @forelse($tweets as $tweet)
                <div class="card-body border-bottom">
                    <div class="d-flex">
                        <img src="{{ $tweet->user->avatar_url }}" 
                             class="rounded-circle mr-3" 
                             width="48" 
                             height="48"
                             alt="{{ $tweet->user->name }}">
                        <div>
                            <div class="d-flex align-items-center mb-1">
                                <a href="{{ route('timeline', $tweet->user) }}" class="font-weight-bold text-dark mr-2">
                                    {{ $tweet->user->name }}
                                </a>
                                <span class="text-muted mx-1">·</span>
                                <span class="text-muted">{{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="mb-2">{{ $tweet->content }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card-body text-center py-4">
                    <div class="alert alert-info mb-0">
                        @if(auth()->id() === $user->id)
                            You haven't tweeted yet.
                        @else
                            This user hasn't tweeted yet.
                        @endif
                    </div>
                </div>
            @endforelse
            
            {{ $tweets->links() }}
        </div>
    </div>
</div>

<style>
    .profile-header {
        position: relative;
        margin-top: 20px;
    }
    .rounded-circle {
        object-fit: cover;
    }
    .card-header {
        padding: 12px 20px;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .tweets .card-body {
        padding: 15px 20px;
    }
</style>
@endsection