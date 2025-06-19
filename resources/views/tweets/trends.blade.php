@extends('layouts.app')
@section('title', 'Explore Trends')
@section('content')
    <div class="max-w-2xl mx-auto px-4 py-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Trending Hashtags</h2>
        <header x-data="{ isSticky: false }" x-init="$el.parentElement.onscroll = () => isSticky = $el.parentElement.scrollTop > 0" :class="{ 'sticky top-0 z-10': isSticky }"
            class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-200">
            <form method="GET" action="{{ route('tweets.search') }}"
                class="flex items-center bg-gray-100 w-full rounded-full px-2 py-0.5 border border-gray-300">
                <input type="text" name="q" placeholder="Search tweets..."
                    class="border-none bg-transparent outline-none text-base px-3 py-2 w-full" />
                <x-button type="submit" class="ml-1">Search</x-button>
            </form>
        </header>
        <ul class="list-disc pl-6">
            @forelse($trends as $trend)
                <li class="mb-2 text-base font-medium text-gray-700">#{{ $trend->tag }} <span
                        class="text-gray-400">({{ $trend->count }})</span></li>
            @empty
                <li class="text-gray-400">No trends yet.</li>
            @endforelse
        </ul>
    </div>
@endsection
