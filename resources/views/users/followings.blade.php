@extends('layouts.app')
@section('title', 'Followings')
@section('content')
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full md:w-4/5">
                <div class="bg-white rounded-lg shadow">
                    <div class="border-b px-6 py-4">
                        <h3 class="text-xl font-bold">{{ $user->name }} Mengikuti</h3>
                        <p class="text-gray-500">Total mengikuti: {{ $count }}</p>
                    </div>
                    <div class="p-6">
                        @if (session('status'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                                role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach ($followings as $following)
                            <div class="flex justify-between items-center mb-3">
                                <div class="flex items-center">
                                    <img src="{{ $following->avatar ? asset('storage/' . $following->avatar) : asset('images/default-avatar.png') }}"
                                        class="rounded-full mr-3 w-12 h-12 object-cover" alt="{{ $following->name }}">
                                    <div>
                                        <h5 class="text-base font-semibold mb-0">{{ $following->name }}</h5>
                                        <small class="text-gray-500">&commat;{{ $following->username }}</small>
                                    </div>
                                </div>
                                @if (auth()->id() !== $following->id)
                                    @if (auth()->user()->isFollowing($following))
                                        <form action="{{ route('unfollow', $following) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-sm rounded cursor-pointer border border-red-400 text-red-500 hover:bg-red-50 transition">Berhenti
                                                Mengikuti</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', $following) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 text-sm rounded cursor-pointer bg-sky-500 text-white hover:bg-sky-600 transition">Ikuti</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        <div class="mt-6">
                            {{ $followings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
