<div class="d-flex justify-content-center mt-3">
    <a href="{{ route('followers', $user) }}" class="btn btn-outline-secondary mr-2">
        <span class="font-weight-bold">{{ $user->followersCount() }}</span> Pengikut
    </a>
    <a href="{{ route('followings', $user) }}" class="btn btn-outline-secondary">
        <span class="font-weight-bold">{{ $user->followingCount() }}</span> Mengikuti
    </a>
</div>