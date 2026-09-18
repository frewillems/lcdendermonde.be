@extends('layouts.app')

@section('title', 'Algemene voorwaarden — '.config('club.name'))
@section('description', 'Algemene voorwaarden en bestel- en leveringsvoorwaarden van Ladies’ Circle Dendermonde.')

@section('content')
    <x-page-hero kicker="Juridisch" title="Algemene voorwaarden" intro="Bestel- en leveringsvoorwaarden van Ladies’ Circle Dendermonde." />

    <article class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="prose-club">
            {!! \Illuminate\Support\Str::markdown(\Illuminate\Support\Facades\File::get(resource_path('content/pages/voorwaarden.md'))) !!}
        </div>
    </article>
@endsection
