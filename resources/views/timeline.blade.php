<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter Clone</title>
    <style>
        :root {
            --twitter-blue: #1DA1F2;
            --twitter-dark: #14171A;
            --twitter-light-gray: #AAB8C2;
            --twitter-extra-light-gray: #E1E8ED;
            --twitter-bg: #F5F8FA;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            color: var(--twitter-dark);
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            border-left: 1px solid var(--twitter-extra-light-gray);
            border-right: 1px solid var(--twitter-extra-light-gray);
            min-height: 100vh;
        }
        
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 32px 15px 20px;
            background: #fff;
            border-bottom: 1px solid #e1e8ed;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .header-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -1px;
        }
        
        .tweet-form {
            padding: 15px 20px;
            border-bottom: 1px solid var(--twitter-extra-light-gray);
        }
        
        .tweet-form textarea {
            width: 100%;
            border: none;
            resize: none;
            font-size: 20px;
            padding: 10px 0;
            min-height: 100px;
            outline: none;
        }
        
        .tweet-form textarea::placeholder {
            color: var(--twitter-light-gray);
        }
        
        .tweet-form button {
            background-color: var(--twitter-blue);
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            float: right;
        }
        
        .timeline-tabs {
            display: flex;
            border-bottom: 1px solid var(--twitter-extra-light-gray);
        }
        
        .tab {
            flex: 1;
            text-align: center;
            padding: 15px 0;
            font-weight: bold;
            color: var(--twitter-light-gray);
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }
        
        .tab:hover {
            background-color: rgba(29, 161, 242, 0.1);
        }
        
        .tab.active {
            color: var(--twitter-dark);
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background-color: var(--twitter-blue);
            border-radius: 2px;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .tweet {
            padding: 15px 20px;
            border-bottom: 1px solid var(--twitter-extra-light-gray);
            transition: background-color 0.2s;
        }
        
        .tweet:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
        
        .tweet-header {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
        }
        
        .user-info {
            flex-grow: 1;
        }
        
        .username {
            font-weight: bold;
            margin-right: 5px;
        }
        
        .user-handle {
            color: var(--twitter-light-gray);
            margin-right: 5px;
        }
        
        .tweet-time {
            color: var(--twitter-light-gray);
        }
        
        .tweet-content {
            font-size: 15px;
            line-height: 1.5;
            margin: 10px 0;
            white-space: pre-line;
        }
        
        .tweet-actions {
            display: flex;
            justify-content: space-between;
            max-width: 400px;
            margin-top: 10px;
            color: var(--twitter-light-gray);
        }
        
        .action-btn {
            background: none;
            border: none;
            color: inherit;
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            background-color: rgba(29, 161, 242, 0.1);
            color: var(--twitter-blue);
        }
        
        .action-btn i {
            margin-right: 5px;
            font-size: 18px;
        }
        
        .follow-btn {
            background-color: var(--twitter-dark);
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 5px 15px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .follow-btn.following {
            background-color: white;
            color: var(--twitter-dark);
            border: 1px solid var(--twitter-extra-light-gray);
        }
        
        .follow-btn:hover {
            background-color: rgb(26, 25, 25);
        }
        
        .follow-btn.following:hover {
            background-color: rgba(29, 161, 242, 0.1);
            color: red;
            border-color: red;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        
        .pagination a {
            color: var(--twitter-blue);
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid var(--twitter-extra-light-gray);
            margin: 0 4px;
            border-radius: 9999px;
            transition: all 0.2s;
        }
        
        .pagination a.active {
            background-color: var(--twitter-blue);
            color: white;
            border-color: var(--twitter-blue);
        }
        
        .pagination a:hover:not(.active) {
            background-color: var(--twitter-extra-light-gray);
        }
        
        .logout-btn {
            display: block;
            width: calc(100% - 40px);
            margin: 20px auto;
            padding: 12px;
            background-color: var(--twitter-blue);
            color: white;
            border: none;
            border-radius: 9999px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }
        
        .empty-tweet {
            text-align: center;
            padding: 40px 20px;
            color: var(--twitter-light-gray);
        }
        
        .empty-tweet a {
            color: var(--twitter-blue);
            text-decoration: none;
        }
        
        .empty-tweet a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div style="display: flex; justify-content: center; background: #f5f8fa; min-height: 100vh;">
    <div class="container" style="flex: 1 1 600px; max-width: 600px; background: #fff;">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <header style="display: flex; align-items: center; justify-content: space-between; padding: 15px 32px 15px 20px; background: #fff; border-bottom: 1px solid #e1e8ed; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; align-items: center;">
                <a href="{{ route('profile', ['username' => auth()->user()->username ?? '' ]) }}" style="text-decoration: none;">
                    <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}" class="avatar" alt="avatar" style="width: 36px; height: 36px; border-radius: 50%; margin-right: 16px; object-fit: cover;">
                </a>
                <h1 class="header-title" style="font-size: 22px; font-weight: 800; margin: 0; letter-spacing: -1px;">Twitter Clone</h1>
            </div>
            <form method="GET" action="{{ route('tweets.search') }}" style="display: flex; align-items: center; background: #f5f8fa; border-radius: 9999px; padding: 2px 8px; border: 1px solid #e1e8ed;">
                <input type="text" name="q" placeholder="Search tweets..." style="border: none; background: transparent; outline: none; font-size: 16px; padding: 8px 12px; width: 180px; font-family: inherit;">
                <button type="submit" style="background: #1da1f2; color: #fff; border: none; border-radius: 9999px; padding: 6px 18px; font-weight: bold; font-size: 15px; cursor: pointer; margin-left: 4px;">Search</button>
            </form>
        </header>

        <!-- Form untuk membuat tweet -->
        <div class="tweet-form">
            <form action="{{ route('tweets.store') }}" method="POST">
                @csrf
                <textarea name="content" placeholder="What's happening?" required></textarea>
                <button type="submit">Tweet</button>
            </form>
        </div>

        <!-- Timeline Tabs -->
        <div class="timeline-tabs">
            <div class="tab active" onclick="switchTab('all')">For you</div>
            <div class="tab" onclick="switchTab('following')">Following</div>
        </div>

        <!-- All Tweets Tab -->
        <div id="all-tweets" class="tab-content active">
            @forelse($allTweets as $tweet)
                <div class="tweet">
                    <div class="tweet-header">
                            <a href="{{ route('profile', ['username' => $tweet->user->username]) }}" style="display: flex; align-items: center; flex-grow: 1; text-decoration: none; color: inherit;">
                                <img src="{{ $tweet->user->avatar_url }}" class="avatar" alt="{{ $tweet->user->username }}">
                                <div class="user-info">
                                    <span class="username">{{ $tweet->user->name }}</span>
                                    <span class="user-handle">
                                        <span class="at-symbol">@</span>{{ $tweet->user->username }}
                                    </span>
                                    <span class="tweet-time">· {{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}</span>
                                </div>
                            </a>
                            
                            @auth
                                @if(auth()->id() !== $tweet->user->id)
                                    <form action="{{ route(auth()->user()->isFollowing($tweet->user) ? 'unfollow' : 'follow', $tweet->user) }}" method="POST">
                                        @csrf
                                        @if(auth()->user()->isFollowing($tweet->user))
                                            @method('DELETE')
                                        @endif
                                        <button type="submit" class="follow-btn {{ auth()->user()->isFollowing($tweet->user) ? 'following' : '' }}">
                                            {{ auth()->user()->isFollowing($tweet->user) ? 'Following' : 'Follow' }}
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    
                    <div class="tweet-content">
                        {{ $tweet->content }}
                    </div>
                    
                    @auth
                        <div class="tweet-actions">
                            <button class="action-btn">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-retweet"></i>
                            </button>
                            <button class="action-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn">
                                <i class="far fa-share-square"></i>
                            </button>
                            
                            @if($tweet->user_id === auth()->id())
                                <a href="{{ route('tweets.edit', $tweet) }}" class="action-btn">
                                    <i class="far fa-edit"></i>
                                </a>
                                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="color: #f44336;">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endauth
                </div>
            @empty
                <div class="empty-tweet">
                    <p>No tweets yet. Be the first to tweet!</p>
                </div>
            @endforelse
            
            <div class="pagination">
                {{ $allTweets->links() }}
            </div>
        </div>

        <!-- Following Tweets Tab -->
        <div id="following-tweets" class="tab-content">
            @if(auth()->check())
                @forelse($followingTweets as $tweet)
                    <div class="tweet">
                        <div class="tweet-header">
                            <a href="{{ route('profile', ['username' => $tweet->user->username]) }}" style="display: flex; align-items: center; flex-grow: 1; text-decoration: none; color: inherit;">
                                <img src="{{ $tweet->user->avatar_url }}" class="avatar" alt="{{ $tweet->user->username }}">
                                <div class="user-info">
                                    <span class="username">{{ $tweet->user->name }}</span>
                                    <span class="user-handle">
                                        <span class="at-symbol">@</span>{{ $tweet->user->username }}
                                    </span>
                                    <span class="tweet-time">· {{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}</span>
                                </div>
                            </a>
                            
                            @auth
                                @if(auth()->id() !== $tweet->user->id)
                                    <form action="{{ route(auth()->user()->isFollowing($tweet->user) ? 'unfollow' : 'follow', $tweet->user) }}" method="POST">
                                        @csrf
                                        @if(auth()->user()->isFollowing($tweet->user))
                                            @method('DELETE')
                                        @endif
                                        <button type="submit" class="follow-btn {{ auth()->user()->isFollowing($tweet->user) ? 'following' : '' }}">
                                            {{ auth()->user()->isFollowing($tweet->user) ? 'Following' : 'Follow' }}
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        
                        <div class="tweet-content">
                            {{ $tweet->content }}
                        </div>
                        
                        <div class="tweet-actions">
                            <button class="action-btn">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-retweet"></i>
                            </button>
                            <button class="action-btn">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn">
                                <i class="far fa-share-square"></i>
                            </button>
                            
                            @if($tweet->user_id === auth()->id())
                                <a href="{{ route('tweets.edit', $tweet) }}" class="action-btn">
                                    <i class="far fa-edit"></i>
                                </a>
                                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="color: #f44336;">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-tweet">
                        <p>No tweets from people you follow. Follow more users to see their tweets!</p>
                    </div>
                @endforelse
                
                <div class="pagination">
                    {{ $followingTweets->links() }}
                </div>
            @else
                <div class="empty-tweet">
                    <p>Please <a href="{{ route('login') }}">login</a> to see tweets from people you follow.</p>
                </div>
            @endif
        </div>

        <!-- Logout Button -->
        @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
        @endauth
    </div>
    <aside style="width: 250px; background: transparent; border-radius: 16px; box-shadow: none; padding: 0; height: fit-content; align-self: flex-start; position: fixed; right: 3vw; top: 80px; z-index: 100;">
        <div style="background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); padding: 8px 16px 16px 16px;">
            <h4 style="font-weight: bold; font-size: 18px; margin-bottom: 10px; margin-top: 2px;">Trending</h4>
            <ol style="padding-left: 1.2em; margin: 0;">
                @foreach($trends as $i => $trend)
                    <li style="margin-bottom: 10px; font-size: 15px;">
                        @if($trend['type'] === 'hashtag')
                            <a href="{{ route('tweets.search', ['q' => '#' . $trend['value']]) }}" style="font-weight: 600; color: #1da1f2; text-decoration: none;">#{{ $trend['value'] }}</a>
                        @else
                            <a href="{{ route('tweets.search', ['q' => $trend['value']]) }}" style="font-weight: 600; color: #1da1f2; text-decoration: none;">{{ $trend['value'] }}</a>
                        @endif
                        <span style="color: #657786; font-size: 13px;">{{ $trend['count'] }} posts</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </aside>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-tweets').classList.add('active');
        
        // Update tab styles
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        event.target.classList.add('active');
        
        // Update URL without reload
        history.pushState(null, null, `?tab=${tabName}`);
    }

    // Set active tab based on URL parameter
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab');
        
        if (activeTab && ['all', 'following'].includes(activeTab)) {
            switchTab(activeTab);
        }
    });
</script>
</body>
</html>