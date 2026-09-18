@props(['project'])

<a href="{{ route('project', $project['slug']) }}" class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-navy/5">
    <div class="aspect-[16/10] overflow-hidden bg-navy/10">
        @if (! empty($project['image']))
            <img src="{{ $project['image'] }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]" loading="lazy">
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold">{{ $project['date_label'] }}</p>
        <h3 class="mt-2 font-serif text-xl text-navy group-hover:text-navy-deep">{{ $project['title'] }}</h3>
        @if (! empty($project['excerpt']))
            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-muted">{{ $project['excerpt'] }}</p>
        @endif
        <span class="mt-auto pt-4 text-sm font-semibold text-navy">Lees meer →</span>
    </div>
</a>
