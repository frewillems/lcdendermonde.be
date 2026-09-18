@extends('layouts.app')

@section('title', config('club.name').' — '.config('club.motto'))
@section('description', 'Ladies’ Circle Dendermonde is een serviceclub voor vrouwen tot 45 jaar. Onder het motto Friendship & Service steunen we lokale goede doelen.')

@section('content')
    <section class="relative overflow-hidden bg-navy text-cream">
        <div class="absolute inset-0 opacity-30">
            <img src="/media/brand/okan-2025.jpg" alt="" class="h-full w-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-navy via-navy/90 to-navy/55"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-24 sm:px-6 sm:py-32">
            <p class="text-xs font-semibold uppercase tracking-[0.32em] text-gold">LC13 · Dendermonde</p>
            <h1 class="mt-4 max-w-3xl font-serif text-5xl leading-[1.05] sm:text-7xl">Friendship <span class="italic text-gold-soft">&amp;</span> Service</h1>
            <p class="mt-6 max-w-xl text-lg text-cream/85 sm:text-xl">{{ config('club.tagline') }} We ontmoeten elkaar, we lachen veel, en we zetten onze schouders onder wat Dendermonde nodig heeft.</p>
            <div class="mt-10 flex flex-wrap gap-3">
                <a href="{{ route('lid-worden') }}" class="rounded-full bg-gold px-6 py-3 text-sm font-semibold text-navy hover:bg-gold-soft">Word lid</a>
                <a href="{{ route('projecten') }}" class="rounded-full border border-cream/40 px-6 py-3 text-sm font-semibold text-cream hover:bg-cream/10">Onze projecten</a>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-16 sm:px-6 md:grid-cols-3">
        @foreach ([
            ['Vriendschap', 'Elke maand een statutaire vergadering rond een gezellige dis. Sprekers, ideeën, citytrips en een netwerk van ladies tot 45 jaar.'],
            ['Service', 'We zamelen fondsen in en steken de handen uit de mouwen: van brooddozen tot speelhoeken, van zwerfvuil tot Walibi voor OKAN-leerlingen.'],
            ['Dendermonde', 'Lokaal verankerd sinds 1983. Peetcircle LC3 Oostende, meter van Maldegem, Wetteren en Affligem-Aalst.'],
        ] as [$title, $text])
            <article class="rounded-2xl bg-white p-7 ring-1 ring-navy/5">
                <div class="h-px w-12 bg-gold"></div>
                <h2 class="mt-4 font-serif text-2xl text-navy">{{ $title }}</h2>
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ $text }}</p>
            </article>
        @endforeach
    </section>

    <section class="bg-white">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gold">Huidig project</p>
                <h2 class="mt-3 font-serif text-4xl text-navy">Rosé en olijfolie voor het goede doel</h2>
                <p class="mt-4 leading-relaxed text-muted">Met de verkoop van Zuid-Afrikaanse rosé en olijfolie steunen we onze lokale projecten. Bestellen kan via onze contactlady — wij leveren persoonlijk na ontvangst van de betaling.</p>
                <a href="{{ route('rose-bestellen') }}" class="mt-6 inline-flex rounded-full bg-navy px-5 py-2.5 text-sm font-semibold text-cream hover:bg-navy-deep">Bestel via de club</a>
            </div>
            <img src="/media/brand/cso-2025.avif" alt="Lokale projecten van Ladies’ Circle Dendermonde" class="w-full rounded-2xl object-cover shadow-lg">
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gold">Impact</p>
                <h2 class="mt-2 font-serif text-3xl text-navy">Recente projecten</h2>
            </div>
            <a href="{{ route('projecten') }}" class="text-sm font-semibold text-navy">Alle projecten →</a>
        </div>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($projects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>
    </section>

    <section class="bg-navy text-cream">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gold">Bestuur 2026–2027</p>
            <h2 class="mt-2 font-serif text-3xl">De ladies van LC13</h2>
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($board as $member)
                    <a href="{{ route('leden') }}" class="text-center">
                        <div class="aspect-[4/5] overflow-hidden rounded-2xl bg-navy-deep">
                            <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover object-top" loading="lazy">
                        </div>
                        <p class="mt-3 font-serif text-lg">{{ $member['name'] }}</p>
                        <p class="text-xs text-gold-soft">{{ $member['role'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gold">Doe mee</p>
        <h2 class="mt-3 font-serif text-4xl text-navy">Ben jij een toffe dame onder de 45?</h2>
        <p class="mt-4 text-muted">Zin in vriendschap én de handen uit de mouwen voor haalbare sociale projecten? We leren je graag kennen.</p>
        <a href="{{ route('lid-worden') }}" class="mt-8 inline-flex rounded-full bg-gold px-6 py-3 text-sm font-semibold text-navy hover:bg-gold-soft">Stel je kandidaat</a>
    </section>
@endsection
