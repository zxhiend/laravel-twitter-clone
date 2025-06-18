@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="border-bottom">
        <div class="container">
            <div class="d-flex align-items-center py-2">
                <a href="{{ url()->previous() }}" class="mr-3 text-dark">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a>
                <h5 class="font-weight-bold mb-0">Edit Tweet</h5>
            </div>
        </div>
    </div>

    <!-- Form Edit Tweet -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tweets.update', $tweet) }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <textarea name="content" 
                          class="form-control border-0" 
                          rows="5"
                          style="font-size: 1.25rem; resize: none;"
                          placeholder="What's happening?"
                          required>{{ old('content', $tweet->content) }}</textarea>
                @error('content')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Tombol Tweet -->
                <button type="submit" class="btn btn-primary rounded-pill font-weight-bold px-4">
                    Update Tweet
                </button>

                <!-- Tombol Delete -->
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">
                    Delete Tweet
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Tweet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this tweet?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .border-bottom {
        border-bottom: 1px solid #e6ecf0 !important;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #1DA1F2;
    }
    .btn-primary {
        background-color: #1DA1F2;
        border-color: #1DA1F2;
    }
    .btn-primary:hover {
        background-color: #1991da;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    textarea::placeholder {
        color: #5b7083;
    }
</style>
@endsection