<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f5f8fa; }
        header { background-color: #1DA1F2; color: white; padding: 10px 0; text-align: center; }
        .container { padding: 20px; max-width: 600px; margin: 0 auto; }
        .tweet-form { 
            margin-bottom: 20px; 
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .tweet-form textarea { 
            width: 100%; 
            padding: 10px; 
            font-size: 16px; 
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 10px;
        }
        .tweet-form button { 
            padding: 8px 16px; 
            background-color: #1DA1F2; 
            color: white; 
            border: none; 
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
        }
        .tweets { margin-top: 20px; }
        .tweet { 
            background: white;
            border: 1px solid #e6ecf0; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .tweet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .user-info {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        .username {
            font-weight: bold;
            color: #14171a;
        }
        .username:hover {
            text-decoration: underline;
        }
        .tweet-content {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.4;
        }
        .tweet-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #657786;
            font-size: 14px;
            padding-top: 10px;
            border-top: 1px solid #e6ecf0;
        }
        .follow-btn {
            padding: 5px 15px;
            background-color: #1DA1F2;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }
        .follow-btn.following {
            background-color: white;
            color: #1DA1F2;
            border: 1px solid #1DA1F2;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-btn {
            background: none;
            border: none;
            color: #657786;
            cursor: pointer;
            font-size: 14px;
        }
        .action-btn:hover {
            color: #1DA1F2;
        }
        .logout { 
            display: block; 
            margin-top: 20px; 
            padding: 8px 16px; 
            background-color: #f44336; 
            color: white; 
            text-decoration: none;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <h1>Twitter Clone</h1>
</header>

<div class="container">
    <!-- Menampilkan pesan sukses -->
    @if(session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form untuk membuat tweet -->
    <div class="tweet-form">
        <form action="{{ route('tweets.store') }}" method="POST">
            @csrf
            <textarea name="content" placeholder="What's happening?" required></textarea>
            <button type="submit">Tweet</button>
        </form>
    </div>

    <!-- Menampilkan tweet -->
    <div class="tweets">
        <h3>All Tweets</h3>
        
        @forelse($tweets as $tweet)
            <div class="tweet">
                <div class="tweet-header">
                    <a href="{{ route('profile', $tweet->user->username) }}" class="user-info">
                        <img src="{{ $tweet->user->avatar_url }}" 
                             class="avatar" 
                             alt="@{{ $tweet->user->username }}">
                        <span class="username">@{{ $tweet->user->username }}</span>
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
                
                <div class="tweet-footer">
                    <span>{{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}</span>
                    
                    @auth
                        @if($tweet->user_id === auth()->id())
                            <div class="action-buttons">
                                <a href="{{ route('tweets.edit', $tweet) }}" class="action-btn">Edit</a>
                                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="color: #f44336;">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="tweet">
                <p>No tweets yet. Be the first to tweet!</p>
            </div>
        @endforelse
    </div>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout">Logout</button>
    </form>
</div>
</body>
</html>