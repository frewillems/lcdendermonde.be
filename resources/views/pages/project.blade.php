@extends('layouts.app')

@section('title', $project['title'].' — '.config('club.name'))
@section('description', $project['excerpt'] ?: $project['title'])

@section('content')
    <x-page-hero kicker="{{ $project['date_label'] }}" title="{{ $project['title'] }}" />

    <article class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        @if (! empty($project['image']))
            <img src="{{ $project['image'] }}" alt="" class="mb-10 w-full rounded-[1.75rem] object-cover shadow-lg">
        @endif
        <div class="prose-club">
            {!! \Illuminate\Support\Str::markdown($project['body'] ?? '') !!}
        </div>
        @if (count($project['images'] ?? []) > 1)
            <div class="mt-12">
                <x-gallery :images="$project['images']" alt="{{ $project['title'] }}" />
            </div>
        @endif
        <p class="mt-12"><a href="{{ route('projecten') }}" class="text-sm font-semibold text-navy">← Alle projecten</a></p>
    </article>

    @if ($related->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6">
            <h2 class="font-serif text-2xl text-navy">Meer projecten</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-3">
                @foreach ($related as $item)
                    <x-project-card :project="$item" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
