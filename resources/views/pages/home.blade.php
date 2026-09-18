@extends('layouts.app')

@section('title', config('club.name').' — '.config('club.motto'))
@section('description', 'Ladies’ Circle Dendermonde is een serviceclub voor vrouwen tot 45 jaar. Onder het motto Friendship & Service steunen we lokale goede doelen.')

@section('content')
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -left-24 top-10 h-64 w-64 rounded-full bg-lilac/70 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-32 h-80 w-80 rounded-full bg-gold-soft/80 blur-3xl"></div>
        <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:py-24">
            <div>
                <p class="text-sm font-medium tracking-wide text-gold">LC13 · Dendermonde</p>
                <h1 class="mt-3 font-serif text-5xl leading-[1.1] text-navy sm:text-7xl">
                    Friendship <span class="italic text-gold">&amp;</span> Service
                </h1>
                <p class="mt-6 max-w-lg text-lg leading-relaxed text-muted">{{ config('club.tagline') }} We ontmoeten elkaar, we lachen veel, en we zetten onze schouders onder wat Dendermonde nodig heeft.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('lid-worden') }}" class="btn-accent">Word lid</a>
                    <a href="{{ route('projecten') }}" class="btn-ghost">Onze projecten</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-3 rounded-[2.5rem] bg-gradient-to-br from-lilac via-gold-soft to-gold/40 blur-sm"></div>
                <img src="/media/brand/okan-2025.jpg" alt="" class="relative aspect-[4/5] w-full rounded-[2.2rem] object-cover shadow-xl sm:aspect-[5/6]">
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-6 px-4 pb-8 sm:px-6 md:grid-cols-3">
        @foreach ([
            ['Vriendschap', 'Elke maand een statutaire vergadering rond een gezellige dis. Sprekers, ideeën, citytrips en een netwerk van ladies tot 45 jaar.'],
            ['Service', 'We zamelen fondsen in en steken de handen uit de mouwen: van brooddozen tot speelhoeken, van zwerfvuil tot Walibi voor OKAN-leerlingen.'],
            ['Dendermonde', 'Lokaal verankerd sinds 1983. Peetcircle LC3 Oostende, meter van Maldegem, Wetteren en Affligem-Aalst.'],
        ] as [$title, $text])
            <article class="panel p-7">
                <p class="font-serif text-2xl italic text-gold">{{ $title }}</p>
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ $text }}</p>
            </article>
        @endforeach
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="panel grid items-center gap-8 overflow-hidden p-2 lg:grid-cols-2">
            <img src="/media/brand/cso-2025.avif" alt="Lokale projecten van Ladies’ Circle Dendermonde" class="h-full min-h-[240px] w-full rounded-[1.5rem] object-cover">
            <div class="px-6 pb-8 lg:py-8 lg:pr-10">
                <p class="text-sm font-medium text-gold">Huidig project</p>
                <h2 class="mt-2 font-serif text-4xl text-navy">Rosé en olijfolie voor het goede doel</h2>
                <p class="mt-4 leading-relaxed text-muted">Met de verkoop van Zuid-Afrikaanse rosé en olijfolie steunen we onze lokale projecten. Bestellen kan via onze contactlady — wij leveren persoonlijk na ontvangst van de betaling.</p>
                <a href="{{ route('rose-bestellen') }}" class="btn mt-6">Bestel via de club</a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-gold">Impact</p>
                <h2 class="mt-1 font-serif text-4xl text-navy">Recente projecten</h2>
            </div>
            <a href="{{ route('projecten') }}" class="text-sm font-semibold text-gold hover:text-navy">Alle projecten →</a>
        </div>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($projects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>
    </section>

    <section class="relative overflow-hidden py-16">
        <div class="pointer-events-none absolute inset-0 bg-navy"></div>
        <div class="pointer-events-none absolute -right-20 top-0 h-72 w-72 rounded-full bg-gold/30 blur-3xl"></div>
        <div class="relative mx-auto max-w-6xl px-4 sm:px-6">
            <p class="text-sm font-medium text-gold-soft">Bestuur 2026–2027</p>
            <h2 class="mt-1 font-serif text-4xl text-cream">De ladies van LC13</h2>
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($board as $member)
                    <a href="{{ route('leden') }}" class="text-center">
                        <div class="aspect-[4/5] overflow-hidden rounded-[1.5rem] ring-2 ring-gold-soft/40">
                            <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover object-top" loading="lazy">
                        </div>
                        <p class="mt-3 font-serif text-lg text-cream">{{ $member['name'] }}</p>
                        <p class="text-xs text-gold-soft">{{ $member['role'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6">
        <p class="text-sm font-medium text-gold">Doe mee</p>
        <h2 class="mt-2 font-serif text-4xl text-navy sm:text-5xl">Ben jij een toffe dame onder de 45?</h2>
        <p class="mt-4 text-muted">Zin in vriendschap én de handen uit de mouwen voor haalbare sociale projecten? We leren je graag kennen.</p>
        <a href="{{ route('lid-worden') }}" class="btn-accent mt-8">Stel je kandidaat</a>
    </section>
@endsection
