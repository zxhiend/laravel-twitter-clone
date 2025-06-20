@extends('layouts.app')
@section('title', 'Bookmarks')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-800">Your Bookmarks</h1>
            <p class="text-sm text-gray-500">All your saved tweets in one place</p>
        </div>
        
        @if($bookmarks->isEmpty())
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookmarks yet</h3>
                <p class="mt-1 text-sm text-gray-500">When you save tweets, they'll show up here.</p>
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach($bookmarks as $bookmark)
                    @if($bookmark->tweets)
                        <x-tweet :tweet="$bookmark->tweets" />
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
