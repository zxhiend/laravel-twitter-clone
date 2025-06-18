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
            position: sticky;
            top: 0;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            padding: 15px 20px;
            border-bottom: 1px solid var(--twitter-extra-light-gray);
            z-index: 10;
        }
        
        .header-title {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
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
<div class="container">
    <header>
        <div style="display: flex; align-items: center; gap: 15px;">
            <!-- Avatar user yang bisa diklik -->
            @auth
            <a href="{{ route('profile', ['username' => auth()->user()->username]) }}" style="text-decoration: none;">
                <img src="{{ auth()->user()->avatar_url }}" class="avatar" alt="{{ auth()->user()->username }}" style="width: 36px; height: 36px;">
            </a>
            @endauth
            
            <h1 class="header-title">Twitter Clone</h1>
        </div>
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