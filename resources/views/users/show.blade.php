<div class="flex justify-center mt-3 gap-2">
    <a href="{{ route('followers', $user) }}" class="px-4 py-2 border border-gray-400 text-gray-700 rounded font-semibold hover:bg-gray-100 transition">
        <span class="font-bold">{{ $user->followersCount() }}</span> Pengikut
    </a>
    <a href="{{ route('followings', $user) }}" class="px-4 py-2 border border-gray-400 text-gray-700 rounded font-semibold hover:bg-gray-100 transition">
        <span class="font-bold">{{ $user->followingCount() }}</span> Mengikuti
    </a>
</div>
