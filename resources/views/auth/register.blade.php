<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter Clone - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow w-full max-w-md">
            <div class="text-center mb-6 text-sky-500 text-2xl font-bold">Twitter Clone</div>
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-1 font-semibold">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        autocomplete="name" autofocus
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="mb-4">
                    <label for="username" class="block mb-1 font-semibold">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">@</div>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required
                            autocomplete="username"
                            class="w-full px-3 py-2 border border-gray-300 rounded pl-10 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <small class="text-gray-400">Will be used for your profile URL (@username)</small>
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-1 font-semibold">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-1 font-semibold">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="mb-4">
                    <label for="password-confirm" class="block mb-1 font-semibold">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="mb-4">
                    <label for="avatar" class="block mb-1 font-semibold">Profile Picture (Optional)</label>
                    <input id="avatar" type="file" name="avatar"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <button type="submit"
                    class="w-full py-2 cursor-pointer bg-sky-500 text-white rounded-full font-bold hover:bg-sky-600 transition">Register</button>
            </form>
            <a href="{{ route('login') }}" class="block mt-4">
                <button type="button"
                    class="w-full py-2 cursor-pointer border border-sky-500 text-sky-500 rounded-full font-bold hover:bg-sky-50 transition">Already
                    have an account? Login</button>
            </a>
        </div>
    </div>
</body>
