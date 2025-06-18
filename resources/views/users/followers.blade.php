@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Pengikut {{ $user->name }}</h3>
                    <p class="text-muted">Total pengikut: {{ $count }}</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($followers as $follower)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ $follower->avatar ?? asset('images/default-avatar.png') }}" 
                                 class="rounded-circle mr-3" 
                                 width="50" 
                                 height="50" 
                                 alt="{{ $follower->name }}">
                            <div>
                                <h5 class="mb-0">{{ $follower->name }}</h5>
                                <small class="text-muted">@{{ $follower->username }}</small>
                            </div>
                        </div>

                        @if(auth()->id() !== $follower->id)
                            @if(auth()->user()->isFollowing($follower))
                            <form action="{{ route('unfollow', $follower) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Berhenti Mengikuti
                                </button>
                            </form>
                            @else
                            <form action="{{ route('follow', $follower) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Ikuti
                                </button>
                            </form>
                            @endif
                        @endif
                    </div>
                    @endforeach

                    {{ $followers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection