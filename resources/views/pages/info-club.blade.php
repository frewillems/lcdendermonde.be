@extends('layouts.app')

@section('title', 'Info club — '.config('club.name'))
@section('description', 'Ladies’ Circle is een internationale serviceclub voor vrouwen tot 45 jaar. LC13 Dendermonde werkt lokaal onder het motto Friendship and Service.')

@section('content')
    <x-page-hero
        kicker="Info club"
        title="Say what?"
        intro="Ladies’ Circle is een serviceclub voor vrouwen tot 45 jaar. Internationaal georganiseerd, lokaal verankerd in Dendermonde."
    />

    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-3">
        <div class="prose-club lg:col-span-2">
            <p>We ontstonden in 1959 in Engeland als vrouwelijk alternatief voor de Ronde Tafel. Vandaag zijn we met zo’n 13.000 leden worldwide, verspreid over 35 landen. In België tellen we 47 actieve clubs en meer dan 660 leden.</p>
            <p>Ons motto is <strong>Friendship and Service</strong>. Eens per maand houden we een statutaire vergadering rond een gezellige dis. We bespreken agendapunten, organiseren een activiteit of nodigen een spreker uit.</p>
            <p>Als serviceclub dragen we ons steentje bij aan sociale projecten. Elke club heeft een eigen lokaal engagement waarvoor we fondsen werven. Daarnaast steunen we ook nationale en internationale projecten. Elk jaar is er een internationale jaarvergadering en een nieuw nationaal bestuur met een jaarthema.</p>
            <p class="text-sm text-muted">Bron: <a href="{{ config('club.national') }}">Ladies’ Circle Belgium</a></p>
        </div>
        <aside class="panel p-7">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold">LC13 Dendermonde</p>
            <dl class="mt-4 space-y-3 text-sm">
                <div><dt class="text-muted">Peetcircle</dt><dd class="font-medium">{{ config('club.peetcircle') }}</dd></div>
                <div><dt class="text-muted">Chartermeeting</dt><dd class="font-medium">19/11/1983</dd></div>
                <div><dt class="text-muted">Recharter</dt><dd class="font-medium">11/03/2017</dd></div>
                <div><dt class="text-muted">Rekeningnummer</dt><dd class="font-medium">{{ config('club.iban') }}</dd></div>
                <div>
                    <dt class="text-muted">Meter van</dt>
                    <dd class="font-medium">
                        @foreach (config('club.godchildren') as $child)
                            {{ $child }}@if (! $loop->last)<br>@endif
                        @endforeach
                    </dd>
                </div>
            </dl>
            <a href="{{ route('voorwaarden') }}" class="mt-6 inline-block text-sm font-semibold text-navy">Algemene voorwaarden →</a>
        </aside>
    </div>
@endsection
