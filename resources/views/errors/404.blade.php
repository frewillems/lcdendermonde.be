@extends('layouts.app')

@section('title', 'Pagina niet gevonden — '.config('club.name'))

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-28 text-center sm:px-6">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gold">404</p>
        <h1 class="mt-3 font-serif text-4xl text-navy">Deze pagina bestaat niet</h1>
        <p class="mt-4 text-muted">Misschien is de link verouderd. Ga terug naar de homepage of neem contact op.</p>
        <a href="{{ route('home') }}" class="btn mt-8">Naar home</a>
    </section>
@endsection
