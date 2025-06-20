@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full md:w-4/5">
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="border-b px-6 py-4 bg-white">
                        <h4 class="mb-0 font-bold text-lg">Edit Profil</h4>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('profile.update', $user->username) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Foto Profil -->
                            <div class="mb-6 flex items-center gap-6">
                                <label class="w-32 font-semibold">Foto Profil</label>
                                <div class="flex items-center gap-4">
                                    <img src="{{ $user->avatar_url }}" class="w-20 h-20 rounded-full object-cover border"
                                        alt="Foto Profil">
                                    <input type="file" name="avatar"
                                        class="block w-full text-gray-700 border border-dashed border-gray-300 rounded px-2 py-1 bg-gray-50">
                                </div>
                            </div>
                            <!-- Nama -->
                            <div class="mb-4">
                                <label for="name" class="block font-semibold mb-1">Nama</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                                    required maxlength="15"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Display Username (read-only) -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-1">Username</label>
                                <input type="text" value="{{ $user->username }}" readonly
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded text-gray-500">
                                <small class="text-gray-400">Username tidak dapat diubah</small>
                            </div>
                            <!-- Bio -->
                            <div class="mb-4">
                                <label for="bio" class="block font-semibold mb-1">Bio</label>
                                <textarea id="bio" name="bio" rows="3" maxlength="160" placeholder="Tell us about yourself"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500 @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                                <small class="text-gray-400">Max 160 characters</small>
                                @error('bio')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end gap-2 mt-6">
                                <button type="submit"
                                    class="px-6 py-2 bg-sky-500 text-white rounded-full font-bold hover:bg-sky-600 transition">Simpan
                                    Perubahan</button>
                                <a href="{{ route('profile', $user->username) }}"
                                    class="px-6 py-2 border border-gray-400 text-gray-700 rounded-full font-bold hover:bg-gray-100 transition">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
