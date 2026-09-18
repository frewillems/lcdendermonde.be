@extends('layouts.app')

@section('title', 'Lid worden — '.config('club.name'))
@section('description', 'Ben je een toffe dame onder de 45 met zin in friendship en service? Stel je kandidaat bij Ladies’ Circle Dendermonde.')

@section('content')
    <x-page-hero
        kicker="Lid worden"
        title="Zin in friendship én service?"
        intro="Ben jij een toffe dame met wat tijd, jonger dan 45, die zich 100% wil geven voor vriendschap en lokale projecten?"
    />

    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-5">
        <div class="prose-club lg:col-span-2">
            <p>Zie je gezellige vergaderingen gecombineerd met de handen uit de mouwen voor haalbare sociale en culturele activiteiten wel zitten?</p>
            <p>Ja? Dankjewel voor je interesse. Laat je gegevens en een korte motivatie achter. Wij nemen spoedig contact op.</p>
            <p>Meer over onze doelstellingen lees je bij <a href="{{ config('club.national') }}">Ladies’ Circle Belgium</a>.</p>
            <p class="text-sm text-muted">Ladies’ Circle Dendermonde houdt zich strikt aan de privacywetgeving en geeft persoonlijke gegevens nooit door.</p>
        </div>
        <div class="lg:col-span-3">
            <livewire:join-form />
        </div>
    </div>
@endsection
