<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 10px 0; text-align: center; }
        .container { padding: 20px; max-width: 600px; margin: 0 auto; }
        .tweet-form { margin-bottom: 20px; }
        .tweet-form textarea { 
            width: 100%; 
            padding: 10px; 
            font-size: 16px; 
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            min-height: 80px;
        }
        .tweet-form button { 
            padding: 10px 20px; 
            background-color: #1DA1F2; 
            color: white; 
            border: none; 
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
        }
        .tweets { margin-top: 20px; }
        .tweet { 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 10px;
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
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        .user-name {
            font-weight: bold;
            margin-right: 5px;
        }
        .username {
            color: #657786;
            text-decoration: none;
        }
        .username:hover {
            text-decoration: underline;
        }
        .tweet-content {
            margin: 10px 0;
            font-size: 16px;
        }
        .tweet-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #657786;
            font-size: 14px;
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
        .edit-btn { 
            background-color: #1DA1F2; 
            color: white; 
            padding: 5px 10px; 
            text-decoration: none; 
            border-radius: 5px;
            font-size: 14px;
        }
        .logout { 
            display: inline-block; 
            margin-top: 20px; 
            padding: 10px 20px; 
            background-color: #f44336; 
            color: white; 
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h1>Twitter Clone</h1>
</header>

<div class="container">
    <!-- Menampilkan pesan sukses setelah login atau tweet berhasil -->
    @if(session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form untuk membuat tweet -->
    <div class="tweet-form">
        <form action="{{ route('tweets.store') }}" method="POST">
            @csrf
            <textarea name="content" placeholder="What's happening?" required></textarea><br>
            <button type="submit">Tweet</button>
        </form>
    </div>

    <!-- Menampilkan tweet -->
    <div class="tweets">
        <h3>All Tweets</h3>
        @if($tweets->isEmpty())
            <p>No tweets yet.</p>
        @else
            @foreach($tweets as $tweet)
                <div class="tweet">
                    <div class="tweet-header">
                        <div class="user-info">
                            <a href="{{ route('profile', $tweet->user->username) }}">
                                <img src="{{ $tweet->user->avatar_url }}" 
                                     class="avatar" 
                                     alt="{{ $tweet->user->name }}">
                            </a>
                            <div>
                                <a href="{{ route('profile', $tweet->user->username) }}" class="user-name">{{ $tweet->user->name }}</a>
                                <a href="{{ route('profile', $tweet->user->username) }}" class="username">@{{ $tweet->user->username }}</a>
                            </div>
                        </div>
                        
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
                    </div>
                    
                    <div class="tweet-content">
                        {{ $tweet->content }}
                    </div>
                    
                    <div class="tweet-footer">
                        <span>{{ $tweet->created_at->diffForHumans() }}</span>
                        
                        @if($tweet->user_id === auth()->id())
                            <div class="action-buttons">
                                <a href="{{ route('tweets.edit', $tweet) }}" class="edit-btn">Edit</a>
                                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;color:#f44336;cursor:pointer;">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout">Logout</button>
    </form>
</div>
</body>
</html>