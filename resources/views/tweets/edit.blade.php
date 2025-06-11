<!-- resources/views/tweets/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tweet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 10px 0; text-align: center; }
        .container { padding: 20px; }
        .tweet-form { margin-bottom: 20px; }
        .tweet-form textarea { width: 100%; padding: 10px; font-size: 16px; }
        .tweet-form button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .logout { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; }
        .delete-btn { background-color: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body>

<header>
    <h1>Edit Tweet</h1>
</header>

<div class="container">
    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; background-color: #f8d7da; padding: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form untuk mengedit tweet -->
    <div class="tweet-form">
        <form method="POST" action="{{ route('tweets.update', $tweet) }}">
            @csrf
            @method('PUT') <!-- Menggunakan metode PUT untuk update -->
            <textarea name="content" rows="4" placeholder="Edit your tweet" required>{{ old('content', $tweet->content) }}</textarea><br>
            <button type="submit">Update Tweet</button>
        </form>
    </div>

    <!-- Tombol Hapus Tweet -->
    <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-btn">Delete Tweet</button>
    </form>

    <!-- Logout Button -->
    <a href="{{ route('logout') }}" class="logout">Logout</a>
</div>

</body>
</html>
