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

        <section class="rounded-2xl bg-white p-8 ring-1 ring-navy/5">
            <h2 class="font-serif text-2xl text-navy">Fotoalbums</h2>
            <p class="mt-2 text-muted">Sfeerbeelden van eerdere projecten en feesten.</p>
            <ul class="mt-4 space-y-2 font-medium text-navy">
                <li><a href="{{ route('archive', 'album-dagenraad') }}" class="hover:text-gold">Project Dageraad — voor en na</a></li>
                <li><a href="{{ route('archive', 'impressies-annual-witches-ball-2018') }}" class="hover:text-gold">Impressies Annual Witches Ball 2018</a></li>
                <li><a href="{{ route('archive', 'fotoreportage-recharter') }}" class="hover:text-gold">Fotoreportage Recharter 2017</a></li>
            </ul>
        </section>
    </div>
@endsection
