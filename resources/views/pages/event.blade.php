@extends('layouts.app')

@section('title', $event['title'].' — '.config('club.name'))
@section('description', $event['title'])

@section('content')
    <x-page-hero kicker="{{ $event['date_label'] ?? 'Evenement' }}" title="{{ $event['title'] }}" />

    <article class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        @if (! empty($event['image']))
            <img src="{{ $event['image'] }}" alt="" class="mb-10 w-full rounded-2xl object-cover">
        @endif
        <div class="prose-club">
            {!! \Illuminate\Support\Str::markdown($event['body'] ?? '') !!}
        </div>
        @if (count($event['images'] ?? []) > 1)
            <div class="mt-10">
                <x-gallery :images="$event['images']" alt="{{ $event['title'] }}" />
            </div>
        @endif
        @if (! empty($event['related_album']))
            <p class="mt-8"><a href="{{ route('archive', $event['related_album']) }}" class="font-semibold text-navy">Bekijk de fotoreportage →</a></p>
        @endif
        <p class="mt-10 text-sm text-muted">Tickets of inschrijvingen? Mail <a class="font-medium text-navy" href="mailto:{{ config('club.contact_email') }}">{{ config('club.contact_email') }}</a>.</p>
    </article>
@endsection
