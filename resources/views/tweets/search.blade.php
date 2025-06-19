@extends('layouts.app')
@section('content')
<div style="display: flex; justify-content: center; background: #f5f8fa; min-height: 100vh; position: relative;">
    <div style="position: absolute; left: 0; top: 32px; width: 100%; display: flex; justify-content: center; pointer-events: none; z-index: 20;">
        <a href="{{ route('timeline') }}" style="pointer-events: auto; background: #fff; border: 1px solid #e1e8ed; border-radius: 9999px; padding: 10px 26px; font-weight: 600; color: #1da1f2; text-decoration: none; box-shadow: 0 1px 4px rgba(0,0,0,0.04); transition: background 0.2s; position: absolute; left: -120px; top: 0;">&larr; Timeline</a>
    </div>
    <div class="container" style="flex: 1 1 600px; max-width: 600px; background: #fff; position: relative; margin-top: 0;">
        <h2 style="font-weight: 800; font-size: 22px; text-align: center;">Search Tweets</h2>
        <form method="GET" action="{{ route('tweets.search') }}" style="display: flex; align-items: center; background: #f5f8fa; border-radius: 9999px; padding: 2px 8px; border: 1px solid #e1e8ed; margin-bottom: 18px; gap: 0;">
            <input type="text" name="q" value="{{ old('q', $query ?? '') }}" placeholder="Search tweets..." required style="border: none; background: transparent; outline: none; font-size: 16px; padding: 8px 12px; width: 100%; font-family: inherit;">
            <button type="submit" style="background: #1da1f2; color: #fff; border: none; border-radius: 9999px; padding: 8px 28px; font-weight: bold; font-size: 15px; cursor: pointer; margin-left: auto;">Search</button>
        </form>
        <div class="timeline-tabs search-tabs" style="display: flex; border-bottom: 1px solid #e1e8ed; margin-bottom: 18px;">
            <a href="{{ route('tweets.search', ['q' => $query, 'tab' => 'top']) }}" class="tab{{ $tab === 'top' ? ' active' : '' }}" style="flex: 1; text-align: center; padding: 15px 0; font-weight: bold; color: {{ $tab === 'top' ? '#14171a' : '#AAB8C2' }}; position: relative; text-decoration: none; background: none; border: none; cursor: pointer; transition: background 0.2s;">
                Top
                @if($tab === 'top')
                    <span style="display: block; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background-color: #1da1f2; border-radius: 2px;"></span>
                @endif
            </a>
            <a href="{{ route('tweets.search', ['q' => $query, 'tab' => 'latest']) }}" class="tab{{ $tab === 'latest' ? ' active' : '' }}" style="flex: 1; text-align: center; padding: 15px 0; font-weight: bold; color: {{ $tab === 'latest' ? '#14171a' : '#AAB8C2' }}; position: relative; text-decoration: none; background: none; border: none; cursor: pointer; transition: background 0.2s;">
                Latest
                @if($tab === 'latest')
                    <span style="display: block; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background-color: #1da1f2; border-radius: 2px;"></span>
                @endif
            </a>
            <a href="{{ route('tweets.search', ['q' => $query, 'tab' => 'people']) }}" class="tab{{ $tab === 'people' ? ' active' : '' }}" style="flex: 1; text-align: center; padding: 15px 0; font-weight: bold; color: {{ $tab === 'people' ? '#14171a' : '#AAB8C2' }}; position: relative; text-decoration: none; background: none; border: none; cursor: pointer; transition: background 0.2s;">
                People
                @if($tab === 'people')
                    <span style="display: block; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background-color: #1da1f2; border-radius: 2px;"></span>
                @endif
            </a>
        </div>
        @if($tab === 'people')
            <h4 style="font-weight: 700; font-size: 18px;">People:</h4>
            @forelse($users as $user)
                <div class="tweet" style="padding: 15px 20px; border-bottom: 1px solid #e1e8ed; display: flex; align-items: flex-start; gap: 12px;">
                    <img src="{{ $user->avatar_url ?? asset('images/default-avatar.png') }}" alt="{{ $user->username }}" class="avatar" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                    <div class="user-info" style="flex: 1;">
                        <span class="username" style="font-weight: bold; color: #14171a; margin-right: 6px;"><a href="{{ route('profile', ['username' => $user->username]) }}" style="color: #14171a; text-decoration: none;">{{ $user->name }}</a></span>
                        <span class="user-handle" style="color: #657786; font-size: 15px; margin-right: 6px;">@{{ $user->username }}</span>
                    </div>
                </div>
            @empty
                <p>No users found.</p>
            @endforelse
        @elseif($tab === 'top' || $tab === 'latest')
            <h4 style="font-weight: 700; font-size: 18px;">Results:</h4>
            @forelse($results as $tweet)
                <div class="tweet" style="padding: 15px 20px; border-bottom: 1px solid #e1e8ed; display: flex; align-items: flex-start; gap: 12px;">
                    <img src="{{ $tweet->user->avatar_url ?? asset('images/default-avatar.png') }}" alt="{{ $tweet->user->username ?? '' }}" class="avatar" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                    <div class="user-info" style="flex: 1;">
                        <span class="username" style="font-weight: bold; color: #14171a; margin-right: 6px;"><a href="{{ route('profile', ['username' => $tweet->user->username]) }}" style="color: #14171a; text-decoration: none;">{{ $tweet->user->name }}</a></span>
                        <span class="user-handle" style="color: #657786; font-size: 15px; margin-right: 6px;">@{{ $tweet->user->username }}</span>
                        <span class="tweet-time" style="color: #657786; font-size: 13px;">· {{ $tweet->created_at }}</span>
                        <div class="tweet-content" style="font-size: 15px; line-height: 1.5; margin: 10px 0; white-space: pre-line;">{{ $tweet->content }}</div>
                    </div>
                </div>
            @empty
                <p>No tweets found.</p>
            @endforelse
        @endif
    </div>
    <aside style="width: 250px; background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); padding: 16px; height: fit-content; align-self: flex-start; position: fixed; right: 3vw; top: 80px; z-index: 100;">
        <h4 style="font-weight: bold; font-size: 18px; margin-bottom: 14px;">Trending</h4>
        <ol style="padding-left: 1.2em;">
            @foreach($trends as $i => $trend)
                <li style="margin-bottom: 10px; font-size: 15px;">
                    @if($trend['type'] === 'hashtag')
                        <a href="{{ route('tweets.search', ['q' => '#' . $trend['value']]) }}" style="font-weight: 600; color: #1da1f2; text-decoration: none;">#{{ $trend['value'] }}</a>
                    @else
                        <a href="{{ route('tweets.search', ['q' => $trend['value']]) }}" style="font-weight: 600; color: #1da1f2; text-decoration: none;">{{ $trend['value'] }}</a>
                    @endif
                    <span style="color: #657786; font-size: 12px;">{{ $trend['count'] }} posts</span>
                </li>
            @endforeach
        </ol>
    </aside>
</div>
@endsection
@push('styles')
<style>
    body, input, button, .nav-link, h2, h4, .tweet, .card-title {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
    }
    .search-tabs .tab:hover {
        background-color: rgba(29, 161, 242, 0.1) !important;
        color: #1da1f2 !important;
    }
</style>
@endpush
