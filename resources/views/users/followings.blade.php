@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $user->name }} Mengikuti</h3>
                    <p class="text-muted">Total mengikuti: {{ $count }}</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($followings as $following)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ $following->avatar ? asset('storage/' . $following->avatar) : asset('images/default-avatar.png') }}" 
                                 class="rounded-circle mr-3" 
                                 width="50" 
                                 height="50" 
                                 alt="{{ $following->name }}">
                            <div>
                                <h5 class="mb-0">{{ $following->name }}</h5>
                                <small class="text-muted">&commat;{{ $following->username }}</small>
                            </div>
                        </div>

                        @if(auth()->id() !== $following->id)
                            @if(auth()->user()->isFollowing($following))
                            <form action="{{ route('unfollow', $following) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Berhenti Mengikuti
                                </button>
                            </form>
                            @else
                            <form action="{{ route('follow', $following) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Ikuti
                                </button>
                            </form>
                            @endif
                        @endif
                    </div>
                    @endforeach

                    {{ $followings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection