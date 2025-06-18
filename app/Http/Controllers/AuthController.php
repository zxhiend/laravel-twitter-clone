<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('timeline')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:15|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle avatar upload
        $avatarPath = $this->handleAvatarUpload($request);

        $user = User::create([
            'name' => $request->name,
            'username' => strtolower($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        Auth::login($user);

        return redirect()->route('timeline')->with('success', 'Pendaftaran berhasil!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * Handle avatar upload process
     */
    protected function handleAvatarUpload(Request $request): ?string
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

        $file = $request->file('avatar');
        
        // Generate unique filename
        $filename = 'avatar_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        
        // Store file in public disk under avatars directory
        $path = $file->storeAs('avatars', $filename, 'public');
        
        return $path;
    }
}