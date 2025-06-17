<!-- resources/views/timeline.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 10px 0; text-align: center; }
        .container { padding: 20px; }
        .tweet-form { margin-bottom: 20px; }
        .tweet-form textarea { width: 100%; padding: 10px; font-size: 16px; }
        .tweet-form button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .tweets { margin-top: 20px; }
        .tweet { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
        .tweet p { margin: 0; }
        .tweet .user { font-weight: bold; }
        .logout { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Your Timeline</h1>
</header>

<div class="container">
    <!-- Menampilkan pesan sukses setelah login atau tweet berhasil -->
    @if(session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form untuk membuat tweet -->
    <div class="tweet-form">
        <form action="{{ url('/tweets') }}" method="POST">
            @csrf
            <textarea name="content" placeholder="What's happening?" required></textarea><br>
            <button type="submit">Tweet</button>
        </form>
    </div>

    <!-- Menampilkan tweet -->
    <div class="tweets">
        <h3>Your Tweets</h3>
        @if($tweets->isEmpty())
            <p>No tweets yet.</p>
        @else
            @foreach($tweets as $tweet)
                <div class="tweet">
                    <p class="user">{{ $tweet->user->name }}</p>
                    <p>{{ $tweet->content }}</p>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf  <!-- CSRF protection -->
        <button type="submit" class="logout">Logout</button>
    </form>
</div>

</body>
</html>
