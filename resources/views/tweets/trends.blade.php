@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Trending Hashtags</h2>
    <ul>
        @forelse($trends as $trend)
            <li>#{{ $trend->tag }} ({{ $trend->count }})</li>
        @empty
            <li>No trends yet.</li>
        @endforelse
    </ul>
</div>
@endsection
