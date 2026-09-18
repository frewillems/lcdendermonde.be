@extends('layouts.app')

@section('title', 'Rosé en olijfolie bestellen — '.config('club.name'))
@section('description', 'Bestel rosé of olijfolie bij Ladies’ Circle Dendermonde. De opbrengst gaat naar lokale projecten.')

@section('content')
    <x-page-hero
        kicker="Huidig project"
        title="Rosé en olijfolie bestellen"
        intro="Met de verkoop van wijn en olijfolie steunen we onze sociale projecten in Dendermonde."
    />

    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <div class="prose-club">
            <p>We verkopen Zuid-Afrikaanse rosé en olijfolie. De levering gebeurt persoonlijk door een van onze ladies, na ontvangst van de betaling op rekening <strong>{{ config('club.iban') }}</strong>.</p>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-3">
            @foreach ([
                ['Rosé Churubita', '€40 / doos', 'Actieprijs — laatste stuks'],
                ['Rosé Pipoli', '€65 / doos', 'Zes flessen'],
                ['Olijfolie', '€25 / fles', 'Koudgeperst'],
            ] as [$name, $price, $note])
                <article class="panel p-6">
                    <h2 class="font-serif text-xl text-navy">{{ $name }}</h2>
                    <p class="mt-2 text-2xl font-semibold text-gold">{{ $price }}</p>
                    <p class="mt-1 text-sm text-muted">{{ $note }}</p>
                </article>
            @endforeach
        </div>

        <div class="prose-club mt-10">
            <p>Online afrekenen doen we niet op deze site. Mail je bestelling (aantal dozen/flessen, leveradres en of je een factuur wilt) naar <a href="mailto:{{ config('club.contact_email') }}">{{ config('club.contact_email') }}</a> of gebruik het <a href="{{ route('contact') }}">contactformulier</a>.</p>
            <p>Gekochte goederen worden niet teruggenomen. Je gaat akkoord met onze <a href="{{ route('voorwaarden') }}">bestel- en leveringsvoorwaarden</a>.</p>
        </div>
    </div>
@endsection
