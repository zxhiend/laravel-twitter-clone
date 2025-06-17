<!-- resources/views/auth/register.blade.php -->
<form method="POST" action="{{ url('register') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
    <button type="submit">Register</button>
</form>

    <!-- Tambahkan tombol login di sini -->
    <a href="{{ route('login') }}" style="text-decoration: none;">
        <button type="button" style="margin-top: 10px;">
            Login
        </button>
    </a>
</form>

<!-- Menampilkan error register -->
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
