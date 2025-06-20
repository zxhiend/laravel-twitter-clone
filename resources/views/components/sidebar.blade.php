<div class="sticky top-0 h-full">
    <div class="bg-white rounded-lg shadow-sm mb-4 relative text-center p-4">

        <h1 class="text-2xl font-extrabold m-0 tracking-tight">Twitter Clone</h1>
    </div>
    <!-- Sidebar Header -->
    @auth
        <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm mb-4 relative">
            <button @click="open = !open"
                class="flex items-center space-x-3 w-full hover:bg-gray-100 p-4 hover:cursor-pointer transition text-left">
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full">
                <div>
                    <h3 class="font-bold text-lg">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ '@' . Auth::user()->username }}</p>
                </div>
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute top-full right-12 z-10 mt-2 w-48 bg-white rounded-lg shadow-lg transition">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full px-5 py-6 text-red-500 font-bold hover:bg-gray-300 cursor-pointer transition">Log
                        out</button>
                </form>
            </div>
        </div>
    @endauth

    <!-- Sidebar Links -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('timeline') }}" class="flex items-center space-x-3 hover:bg-gray-100 p-3 rounded-lg">
                    <svg class="w-8 h-8" viewBox="0 -960 960 960" fill="currentColor">
                        <path
                            d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                    </svg>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tweets.trends') }}"
                    class="flex items-center space-x-3 hover:bg-gray-100 p-3 rounded-lg">
                    <svg class="w-8 h-8" viewBox="0 -960 960 960" fill="currentColor">
                        <path
                            d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                    </svg>
                    <span>Explore</span>
                </a>
            </li>
            <li>
                <a href="/bookmarks" class="flex items-center space-x-3 hover:bg-gray-100 p-3 rounded-lg">
                    <svg class="w-8 h-8" viewBox="0 -960 960 960" fill="currentColor">
                        <path
                            d="M200-120v-640q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v640L480-240 200-120Zm80-122 200-86 200 86v-518H280v518Zm0-518h400-400Z" />
                    </svg>
                    <span>Bookmarks</span>
                </a>
            </li>
            <li>
                <a href="{{ auth()->check() ? route('profile', ['username' => auth()->user()->username]) : route('login') }}"
                    class="flex items-center space-x-3 hover:bg-gray-100 p-3 rounded-lg">
                    <svg class="w-8 h-8" viewBox="0 -960 960 960" fill="currentColor">
                        <path
                            d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                    </svg>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
    </div>
</div>
