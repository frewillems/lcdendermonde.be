@props(['kicker' => null, 'title', 'intro' => null])

<section class="bg-navy text-cream">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
        @if ($kicker)
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gold">{{ $kicker }}</p>
        @endif
        <h1 class="mt-3 max-w-3xl font-serif text-4xl leading-tight sm:text-5xl">{{ $title }}</h1>
        @if ($intro)
            <p class="mt-5 max-w-2xl text-lg text-cream/80">{{ $intro }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
