@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div x-data="{ tab: 'all' }">
        <div class="flex border-b bg-white border-gray-200">
            <div class="flex-1 text-center py-4 hover:bg-gray-100 font-bold cursor-pointer transition relative tab"
                :class="{ 'active': tab === 'all' }" @click="tab = 'all'">
                For you
                <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded tab-underline"
                    :class="{ 'hidden': tab !== 'all' }"></span>
            </div>
            <div class="flex-1 text-center py-4 font-bold hover:bg-gray-100 cursor-pointer transition relative tab"
                :class="{ 'active': tab === 'following' }" @click="tab = 'following'">
                Following
                <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded tab-underline"
                    :class="{ 'hidden': tab !== 'following' }"></span>
            </div>
        </div>
        <div class="flex justify-center bg-gray-100">

            <div class="flex-1 max-w-xl bg-white relative mt-0 p-0 border-x border-gray-200 min-h-screen">
                <header x-data="{ isSticky: false }" x-init="$el.parentElement.onscroll = () => isSticky = $el.parentElement.scrollTop > 0" :class="{ 'sticky top-0 z-10': isSticky }"
                    class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('tweets.search') }}"
                        class="flex items-center bg-gray-100 w-full rounded-full px-2 py-0.5 border border-gray-300">
                        <input type="text" name="q" placeholder="Search tweets..."
                            class="border-none bg-transparent outline-none text-base px-3 py-2 w-full" />
                        <x-button type="submit" class="ml-1">Search</x-button>
                    </form>
                </header>
                <div class="px-0">
                    <div class="px-5 py-4 border-b border-gray-200" x-data="{ content: '', max: 280 }">
                        <form action="{{ route('tweets.store') }}" method="POST" class="flex flex-col gap-2">
                            @csrf
                            <div class="flex items-start">
                                <a href="{{ route('profile', ['username' => auth()->user()->username ?? '']) }}"
                                    class="no-underline">
                                    <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="w-9 h-9 rounded-full object-cover mr-4" alt="avatar">
                                </a>
                                <textarea name="content"
                                    class="w-full border border-gray-300 p-3 text-xl resize-none focus:ring-2 focus:ring-sky-500 focus:border-transparent placeholder-gray-400 rounded-lg transition-all"
                                    rows="5" placeholder="What's happening?" required maxlength="280"
                                    x-model="content"></textarea>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-400 ml-1"
                                    x-text="max - content.length + ' characters left'"></span>
                                <button type="submit" class="ml-1 px-7 py-2 bg-sky-500 text-white rounded-full font-bold text-sm transition hover:bg-sky-600 disabled:opacity-50 cursor-pointer"
                                    x-bind:disabled="content.length > max">Tweet</button>
                            </div>
                        </form>
                    </div>

                    {{-- All tweets --}}
                    <div id="all-tweets" class="tab-content" x-show="tab === 'all'">
                        @forelse($allTweets as $tweet)
                            <x-tweet :tweet="$tweet" />
                        @empty
                            <div class="text-center py-10 text-gray-400">
                                <p>No tweets yet. Be the first to tweet!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Following tweets --}}
                    <div id="following-tweets" class="tab-content" x-show="tab === 'following'">
                        @if (auth()->check())
                            @forelse($followingTweets as $tweet)
                                <x-tweet :tweet="$tweet" />
                            @empty
                                <div class="text-center py-10 text-gray-400">
                                    <p>No tweets from people you follow. Follow more users to see their tweets!</p>
                                </div>
                            @endforelse
                        @else
                            <div class="text-center py-10 text-gray-400">
                                <p>Please <a href="{{ route('login') }}" class="text-sky-500 hover:underline">login</a> to
                                    see tweets from people you follow.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
