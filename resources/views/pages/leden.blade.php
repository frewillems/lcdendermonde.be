@extends('layouts.app')

@section('title', 'Leden — '.config('club.name'))
@section('description', 'Ontmoet de ladies van Ladies’ Circle Dendermonde: bestuur, actieve leden en senioritas.')

@section('content')
    <x-page-hero kicker="Leden" title="De ladies van LC13" intro="Een hechte groep vrouwen die vriendschap en service even ernstig neemt als een goed glas rosé." />

    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <div class="font-serif text-xl leading-relaxed text-navy sm:text-2xl">
            @foreach (preg_split('/\n+/', trim($originStory)) as $line)
                <p class="{{ $loop->first ? '' : 'mt-3' }}">{{ $line }}</p>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6">
        <h2 class="font-serif text-3xl text-navy">Bestuur 2026–2027</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($board as $member)
                <x-member-card :member="$member" />
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6">
        <h2 class="font-serif text-3xl text-navy">Actieve leden</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($active as $member)
                <x-member-card :member="$member" />
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6">
        <h2 class="font-serif text-3xl text-navy">Senioritas &amp; ereleden</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($senioritas as $member)
                <x-member-card :member="$member" />
            @endforeach
        </div>
    </section>

    @if ($inMemoriam->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 pb-20 sm:px-6">
            <h2 class="font-serif text-3xl text-navy">Voor altijd in ons hart</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($inMemoriam as $member)
                    <x-member-card :member="$member" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
