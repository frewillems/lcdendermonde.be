@props(['images', 'alt' => 'Foto'])

<div
    class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4"
    x-data="{ src: null }"
    @keydown.escape.window="src = null"
>
    @foreach ($images as $image)
        <button type="button" class="aspect-square overflow-hidden rounded-2xl bg-cream-dark ring-1 ring-gold-soft/70" @click="src = '{{ $image }}'">
            <img src="{{ $image }}" alt="{{ $alt }}" class="h-full w-full object-cover" loading="lazy">
        </button>
    @endforeach

    <div
        x-cloak
        x-show="src"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-navy/90 p-4"
        @click="src = null"
        role="dialog"
        aria-modal="true"
    >
        <img :src="src" alt="" class="max-h-full max-w-full rounded-2xl shadow-2xl" @click.stop>
    </div>
</div>
