@props(['kicker' => null, 'title', 'intro' => null])

<section class="relative overflow-hidden">
    <div class="pointer-events-none absolute -right-16 top-0 h-56 w-56 rounded-full bg-lilac/70 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-10 bottom-0 h-40 w-40 rounded-full bg-gold-soft/80 blur-3xl"></div>
    <div class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
        @if ($kicker)
            <p class="text-sm font-medium text-gold">{{ $kicker }}</p>
        @endif
        <h1 class="mt-2 max-w-3xl font-serif text-4xl leading-tight text-navy sm:text-6xl">{{ $title }}</h1>
        @if ($intro)
            <p class="mt-5 max-w-2xl text-lg text-muted">{{ $intro }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
