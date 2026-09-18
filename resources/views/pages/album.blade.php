@extends('layouts.app')

@section('title', $album['title'].' — '.config('club.name'))
@section('description', $album['title'])

@section('content')
    <x-page-hero kicker="Album" title="{{ $album['title'] }}" intro="{{ count($album['images']) }} foto’s" />

    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <x-gallery :images="$album['images']" alt="{{ $album['title'] }}" />
        <p class="mt-10"><a href="{{ route('projecten') }}" class="text-sm font-semibold text-navy">← Terug naar projecten</a></p>
    </div>
@endsection
