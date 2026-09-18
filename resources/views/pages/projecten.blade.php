@extends('layouts.app')

@section('title', 'Projecten — '.config('club.name'))
@section('description', 'Van Walibi voor OKAN-leerlingen tot speelhoeken, zwerfvuilacties en fondsenwerving: het projectarchief van LC13 Dendermonde.')

@section('content')
    <x-page-hero kicker="Service" title="Onze projecten" intro="Lokaal, concreet en met de handen uit de mouwen. Hieronder het archief van 2016 tot vandaag." />

    <div class="mx-auto max-w-6xl space-y-16 px-4 py-16 sm:px-6">
        @foreach ($years as $year => $projects)
            <section>
                <h2 class="font-serif text-3xl text-navy">{{ $year }}</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
            </section>
        @endforeach

        @if ($albums->isNotEmpty())
            <section class="panel p-8">
                <h2 class="font-serif text-2xl text-navy">Fotoalbums</h2>
                <p class="mt-2 text-muted">Sfeerbeelden van eerdere projecten en feesten.</p>
                <ul class="mt-4 space-y-2 font-medium text-navy">
                    @foreach ($albums as $album)
                        <li><a href="{{ route('archive', $album['slug']) }}" class="hover:text-gold">{{ $album['title'] }}</a></li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($events->isNotEmpty())
            <section class="panel p-8">
                <h2 class="font-serif text-2xl text-navy">Evenementen</h2>
                <p class="mt-2 text-muted">Archief van feesten, spinningen en andere momenten.</p>
                <ul class="mt-4 space-y-2 font-medium text-navy">
                    @foreach ($events as $event)
                        <li><a href="{{ route('archive', $event['slug']) }}" class="hover:text-gold">{{ $event['title'] }}</a></li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
@endsection
