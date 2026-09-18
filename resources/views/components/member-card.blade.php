@props(['member'])

<article class="panel group overflow-hidden">
    <div class="aspect-[4/5] overflow-hidden bg-cream-dark">
        <img
            src="{{ $member['photo'] }}"
            alt="{{ $member['name'] }}"
            class="h-full w-full object-cover object-top transition duration-500 group-hover:scale-[1.03]"
            loading="lazy"
        >
    </div>
    <div class="p-5">
        <h3 class="font-serif text-2xl text-navy">{{ $member['name'] }}</h3>
        @if (! empty($member['role']))
            <p class="mt-1 text-sm font-medium text-gold">{{ $member['role'] }}</p>
        @endif
        @if (! empty($member['bio']))
            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $member['bio'] }}</p>
        @endif
    </div>
</article>
