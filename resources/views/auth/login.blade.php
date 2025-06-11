<!-- resources/views/auth/login.blade.php -->
<form method="POST" action="{{ url('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

<!-- Menampilkan error login -->
@if ($errors->any())
    <div style="color: red; background-color: #f8d7da; padding: 10px;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<!-- Menampilkan pesan sukses jika ada -->
@if(session('success'))
    <div style="color: green; background-color: #d4edda; padding: 10px;">
        {{ session('success') }}
    </div>
@endif
