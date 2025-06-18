@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-header mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ $user->avatar_url }}" 
                 class="rounded-circle mr-3" 
                 width="100" 
                 height="100"
                 alt="{{ $user->name }}">
            <div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->username }}</p>
                <div class="d-flex">
                    <a href="{{ route('followers', $user) }}" class="mr-3">
                        <strong>{{ $user->followers_count }}</strong> followers
                    </a>
                    <a href="{{ route('followings', $user) }}">
                        <strong>{{ $user->followings_count }}</strong> following
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="tweets">
        <h4>Tweets</h4>
        @forelse($tweets as $tweet)
            <div class="card mb-3">
                <div class="card-body">
                    <p>{{ $tweet->content }}</p>
                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}
                    </small>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                @if(auth()->id() === $user->id)
                    You haven't tweeted yet.
                @else
                    This user hasn't tweeted yet.
                @endif
            </div>
        @endforelse
        
        {{ $tweets->links() }}
    </div>
</div>
@endsection