@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Edit Profil</h4>
                </div>

                <div class="card-body">
                    <!-- Perubahan utama pada form action -->
                    <form method="POST" action="{{ route('profile.update', $user->username) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Profil -->
                        <div class="form-group row mb-4">
                            <label class="col-md-4 col-form-label text-md-right">Foto Profil</label>
                            <div class="col-md-6 d-flex align-items-center">
                                <img src="{{ $user->avatar_url }}" 
                                     class="rounded-circle mr-3" 
                                     width="80" 
                                     height="80"
                                     alt="Foto Profil">
                                <input type="file" class="form-control-file" name="avatar">
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>
                            <div class="col-md-6">
                                <input id="name" type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Display Username (read-only) -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <input type="text" 
                                       class="form-control-plaintext" 
                                       value="{{ $user->username }}"
                                       readonly>
                                <small class="text-muted">Username tidak dapat diubah</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bio" class="font-weight-bold">Bio</label>
                            <textarea id="bio" 
                                    class="form-control @error('bio') is-invalid @enderror" 
                                    name="bio"
                                    rows="3"
                                    maxlength="160"
                                    placeholder="Tell us about yourself">{{ old('bio', $user->bio) }}</textarea>
                            <small class="text-muted">Max 160 characters</small>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('profile', $user->username) }}" class="btn btn-outline-secondary ml-2">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
    }
    .card-header {
        font-weight: 600;
        font-size: 1.2rem;
        padding: 1rem 1.5rem;
    }
    .form-control-file {
        padding: 0.5rem;
        border: 1px dashed #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }
    .btn {
        border-radius: 20px;
        font-weight: 500;
    }
</style>
@endsection