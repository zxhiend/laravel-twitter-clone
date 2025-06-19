@extends('layouts.app')
@section('title', $user->username)
@section('content')
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header Profil -->
        <div class="mt-5 mb-8 p-6 bg-white rounded-lg shadow">
            <div class="flex items-start">
                <!-- Foto Profil -->
                <div class="mr-6 flex-shrink-0">
                    <img src="{{ $user->avatar_url }}"
                        class="w-30 h-30 rounded-full border-4 border-white shadow object-cover" alt="{{ $user->name }}">
                </div>
                <!-- Informasi Profil -->
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="font-bold text-2xl mb-1">{{ $user->name }}</h2>
                            <p class="text-gray-500 mb-3">{{ '@' . $user->username }}</p>
                        </div>
                        @auth
                            @if (auth()->id() === $user->id)
                                <a href="{{ route('profile.edit', auth()->user()->username) }}"
                                    class="px-4 py-2 border border-sky-500 text-sky-500 rounded-full font-semibold hover:bg-sky-50 transition">Edit
                                    Profil</a>
                            @else
                                <form action="{{ route(auth()->user()->isFollowing($user) ? 'unfollow' : 'follow', $user) }}"
                                    method="POST">
                                    @csrf
                                    @if (auth()->user()->isFollowing($user))
                                        @method('DELETE')
                                    @endif
                                    <button type="submit"
                                        class="px-4 py-2 rounded-full font-semibold transition {{ auth()->user()->isFollowing($user) ? 'border border-gray-400 text-gray-700 bg-white hover:bg-gray-100' : 'bg-sky-500 text-white hover:bg-sky-600' }}">
                                        {{ auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    @if ($user->bio)
                        <p class="mb-3">{{ $user->bio }}</p>
                    @endif
                    <div class="flex mb-2 gap-6">
                        <a href="{{ route('followings', $user) }}" class="text-gray-900 hover:underline">
                            <span class="font-bold">{{ $user->followings_count }}</span> <span
                                class="text-gray-500">Following</span>
                        </a>
                        <a href="{{ route('followers', $user) }}" class="text-gray-900 hover:underline">
                            <span class="font-bold">{{ $user->followers_count }}</span> <span
                                class="text-gray-500">Followers</span>
                        </a>
                    </div>
                    <div class="text-gray-400 text-sm">
                        @if ($user->location)
                            <span class="mr-4"><i class="fas fa-map-marker-alt"></i> {{ $user->location }}</span>
                        @endif
                        <span><i class="far fa-calendar-alt"></i> Joined
                            {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ tab: 'tweets' }" class="bg-white rounded-lg shadow mb-6 overflow-hidden">
            <!-- Tabs Navigation -->
            <div class="flex border-b border-gray-200">
                <div class="flex-1 text-center py-4 hover:bg-gray-100 font-medium cursor-pointer transition relative"
                    :class="{ 'text-sky-500': tab === 'tweets' }" @click="tab = 'tweets'">
                    Tweets
                    <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded"
                        :class="{ 'hidden': tab !== 'tweets' }"></span>
                </div>
                <div class="flex-1 text-center py-4 font-medium hover:bg-gray-100 cursor-pointer transition relative"
                    :class="{ 'text-sky-500': tab === 'likes' }" @click="tab = 'likes'">
                    Likes
                    <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded"
                        :class="{ 'hidden': tab !== 'likes' }"></span>
                </div>
            </div>

            <!-- Tweets Section -->
            <div x-show="tab === 'tweets'" class="transition-all duration-200">
                @forelse($tweets as $tweet)
                    <x-tweet :tweet="$tweet" />
                @empty
                    <div class="px-6 py-8 text-center">
                        <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded mb-0">
                            @if (auth()->id() === $user->id)
                                You haven't tweeted yet.
                            @else
                                This user hasn't tweeted yet.
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Liked Tweets Section -->
            <div x-show="tab === 'likes'" class="transition-all duration-200">
                @forelse($likedTweets as $tweet)
                    <x-tweet :tweet="$tweet" />
                @empty
                    <div class="px-6 py-8 text-center">
                        <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded mb-0">
                            @if (auth()->id() === $user->id)
                                You haven't liked any tweets yet.
                            @else
                                This user hasn't liked any tweets yet.
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
