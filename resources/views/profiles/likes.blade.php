@extends('layouts.app')
@section('title', 'Liked Tweets')
@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">Liked Tweets</h1>
                <p class="text-sm text-gray-500">Tweets liked by {{ $user->name }}</p>
            </div>

            @if ($likes->isEmpty())
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No liked tweets yet</h3>
                    <p class="mt-1 text-sm text-gray-500">When {{ $user->id === auth()->id() ? 'you like' : 'they like' }}
                        tweets, they'll show up here.</p>
                </div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach ($likes as $like)
                        @if ($like->tweet)
                            <x-tweet :tweet="$like->tweet" />
                        @endif
                    @endforeach
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $likes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
