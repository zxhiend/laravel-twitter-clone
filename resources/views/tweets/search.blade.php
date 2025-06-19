@extends('layouts.app')
@section('title', 'Search Tweets')
@section('content')
    <div class="flex justify-center bg-gray-100 min-h-screen relative">
        <div class="absolute left-0 top-8 w-full flex justify-center pointer-events-none z-20">
            <a href="{{ route('timeline') }}"
                class="pointer-events-auto bg-white border border-gray-300 rounded-full px-6 py-2 font-semibold text-sky-500 no-underline shadow transition-colors absolute -left-32 top-0 hover:bg-gray-100">&larr;
                Timeline</a>
        </div>
        <div class="flex-1 max-w-xl bg-white relative mt-0 p-0">
            <h2 class="font-extrabold text-2xl text-center">Search Tweets</h2>
            <form method="GET" action="{{ route('tweets.search') }}"
                class="flex items-center bg-gray-100 rounded-full px-2 py-0.5 border border-gray-300 mb-4 gap-0">
                <input type="text" name="q" value="{{ old('q', $query ?? '') }}" placeholder="Search tweets..."
                    required class="border-none bg-transparent outline-none text-base px-3 py-2 w-full font-sans" />
                <button type="submit"
                    class="bg-sky-500 text-white border-none rounded-full px-7 py-2 font-bold text-sm cursor-pointer ml-auto">Search</button>
            </form>
            <div class="flex border-b border-gray-300 mb-4">
                <a href="{{ route('tweets.search', ['q' => $query, 'tab' => 'top']) }}"
                    class="flex-1 text-center py-4 font-bold transition-colors relative no-underline bg-none border-none cursor-pointer {{ $tab === 'top' ? 'text-gray-900' : 'text-gray-400' }}">
                    Top
                    @if ($tab === 'top')
                        <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded"></span>
                    @endif
                </a>
                <a href="{{ route('tweets.search', ['q' => $query, 'tab' => 'latest']) }}"
                    class="flex-1 text-center py-4 font-bold transition-colors relative no-underline bg-none border-none cursor-pointer {{ $tab === 'latest' ? 'text-gray-900' : 'text-gray-400' }}">
                    Latest
                    @if ($tab === 'latest')
                        <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded"></span>
                    @endif
                </a>
                <a href="{{ route('tweets.search', ['q' => $query, 'tab' => 'people']) }}"
                    class="flex-1 text-center py-4 font-bold transition-colors relative no-underline bg-none border-none cursor-pointer {{ $tab === 'people' ? 'text-gray-900' : 'text-gray-400' }}">
                    People
                    @if ($tab === 'people')
                        <span class="block absolute bottom-0 left-1/2 -translate-x-1/2 w-15 h-1 bg-sky-500 rounded"></span>
                    @endif
                </a>
            </div>
            @if ($tab === 'people')
                <h4 class="font-bold text-lg">People:</h4>
                @forelse($users as $user)
                    <div class="flex items-start gap-3 py-4 px-5 border-b border-gray-300">
                        <img src="{{ $user->avatar_url ?? asset('images/default-avatar.png') }}"
                            alt="{{ $user->username }}" class="w-12 h-12 rounded-full object-cover" />
                        <div class="flex-1">
                            <span class="font-bold text-gray-900 mr-1.5"><a
                                    href="{{ route('profile', ['username' => $user->username]) }}"
                                    class="text-gray-900 no-underline">{{ $user->name }}</a></span>
                            <span class="text-gray-400 text-sm mr-1.5">@{{ $user - > username }}</span>
                        </div>
                    </div>
                @empty
                    <p>No users found.</p>
                @endforelse
            @elseif($tab === 'top' || $tab === 'latest')
                <h4 class="font-bold text-lg">Results:</h4>
                @forelse($results as $tweet)
                    <x-tweet :tweet="$tweet" :action="false" />
                @empty
                    <p>No tweets found.</p>
                @endforelse
            @endif
        </div>

    </div>
@endsection
@push('styles')
@endpush
