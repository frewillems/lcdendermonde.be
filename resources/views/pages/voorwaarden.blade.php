@extends('layouts.app')

@section('title', 'Algemene voorwaarden — '.config('club.name'))
@section('description', 'Algemene voorwaarden en bestel- en leveringsvoorwaarden van Ladies’ Circle Dendermonde.')

@section('content')
    <x-page-hero kicker="Juridisch" title="Algemene voorwaarden" intro="Bestel- en leveringsvoorwaarden van Ladies’ Circle Dendermonde." />

    <article class="prose-club mx-auto max-w-3xl px-4 py-16 sm:px-6">
        {!! \Illuminate\Support\Str::markdown(\Illuminate\Support\Facades\File::get(resource_path('content/pages/voorwaarden.md'))) !!}
    </article>
@endsection
