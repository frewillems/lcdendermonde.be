@extends('layouts.app')

@section('title', 'Contact — '.config('club.name'))
@section('description', 'Mail de contactlady van Ladies’ Circle Dendermonde of laat een bericht achter.')

@section('content')
    <x-page-hero kicker="Contact" title="Mail onze contactlady" intro="Voor lidmaatschap, bestellingen, sponsoring of een vraag: we antwoorden zo snel we kunnen." />

    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="panel p-7">
                <p class="font-serif text-2xl text-navy">{{ config('club.name') }}</p>
                <p class="mt-4 text-sm leading-7 text-muted">
                    {{ config('club.address.line1') }}<br>
                    {{ config('club.address.city') }}<br>
                    {{ config('club.vat') }}
                </p>
                <p class="mt-4 text-sm leading-7">
                    <a class="font-medium text-navy hover:text-gold" href="mailto:{{ config('club.contact_email') }}">{{ config('club.contact_email') }}</a><br>
                    <a class="font-medium text-navy hover:text-gold" href="{{ config('club.phone_href') }}">{{ config('club.phone') }}</a>
                </p>
                <p class="mt-4 text-sm text-muted">IBAN {{ config('club.iban') }}</p>
            </div>
        </div>
        <div class="lg:col-span-3">
            <livewire:contact-form />
        </div>
    </div>
@endsection
