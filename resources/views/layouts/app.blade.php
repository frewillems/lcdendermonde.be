<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('club.name'))</title>
    <meta name="description" content="@yield('description', config('club.tagline'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:locale" content="nl_BE">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('club.name') }}">
    <meta property="og:title" content="@yield('title', config('club.name'))">
    <meta property="og:description" content="@yield('description', config('club.tagline'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ url('/media/brand/lc-logo-paard.jpg') }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'NGO',
            'name' => config('club.name'),
            'url' => config('app.url'),
            'email' => config('club.email'),
            'telephone' => config('club.phone'),
            'vatID' => config('club.vat'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('club.address.line1'),
                'addressLocality' => 'Dendermonde',
                'postalCode' => '9200',
                'addressCountry' => 'BE',
            ],
            'sameAs' => [config('club.facebook'), config('club.national')],
            'slogan' => config('club.motto'),
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col" x-data="{ open: false }">
    <a href="#inhoud" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-gold focus:px-3 focus:py-2">Naar de inhoud</a>

    <header class="sticky top-0 z-40 border-b border-navy/10 bg-cream/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3 min-w-0">
                <img src="{{ config('club.logo') }}" alt="{{ config('club.name') }}" class="h-10 w-auto sm:h-12">
            </a>
            <nav class="hidden items-center gap-7 lg:flex" aria-label="Hoofdnavigatie">
                @foreach (config('club.nav') as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="text-sm font-medium tracking-wide {{ request()->routeIs($item['route']) ? 'text-navy' : 'text-muted hover:text-navy' }}"
                    >{{ $item['label'] }}</a>
                @endforeach
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('lid-worden') }}" class="hidden sm:inline-flex rounded-full bg-navy px-4 py-2 text-sm font-semibold text-cream hover:bg-navy-deep">Lid worden</a>
                <button type="button" class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-full border border-navy/20" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobiel-menu" aria-label="Menu">
                    <span class="sr-only">Menu</span>
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/></svg>
                    <svg x-cloak x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-width="1.8" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </div>
        <div id="mobiel-menu" x-cloak x-show="open" x-transition class="border-t border-navy/10 bg-cream lg:hidden">
            <nav class="mx-auto flex max-w-6xl flex-col px-4 py-4 sm:px-6" aria-label="Mobiel menu">
                @foreach (config('club.nav') as $item)
                    <a href="{{ route($item['route']) }}" class="py-2 text-base {{ request()->routeIs($item['route']) ? 'text-navy font-semibold' : 'text-muted' }}" @click="open = false">{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </div>
    </header>

    <main id="inhoud" class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-16 bg-navy text-cream">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-3">
            <div>
                <p class="font-serif text-2xl">{{ config('club.short_name') }}</p>
                <p class="mt-2 italic text-gold-soft">{{ config('club.motto') }}</p>
                <p class="mt-4 max-w-sm text-sm text-cream/80">{{ config('club.tagline') }}</p>
            </div>
            <div class="text-sm leading-7 text-cream/85">
                <p class="font-semibold tracking-wide text-gold-soft">Contact</p>
                <p class="mt-2">{{ config('club.address.line1') }}<br>{{ config('club.address.city') }}</p>
                <p><a class="hover:text-gold" href="mailto:{{ config('club.contact_email') }}">{{ config('club.contact_email') }}</a></p>
                <p><a class="hover:text-gold" href="{{ config('club.phone_href') }}">{{ config('club.phone') }}</a></p>
                <p class="mt-2">{{ config('club.vat') }}<br>IBAN {{ config('club.iban') }}</p>
            </div>
            <div class="text-sm leading-7">
                <p class="font-semibold tracking-wide text-gold-soft">Volg ons</p>
                <p class="mt-2"><a class="hover:text-gold" href="{{ config('club.facebook') }}" rel="noopener">Facebook</a></p>
                <p><a class="hover:text-gold" href="{{ config('club.national') }}" rel="noopener">Ladies’ Circle Belgium</a></p>
                <p><a class="hover:text-gold" href="{{ route('rose-bestellen') }}">Rosé &amp; olijfolie</a></p>
                <p><a class="hover:text-gold" href="{{ route('voorwaarden') }}">Algemene voorwaarden</a></p>
                <img src="{{ config('club.logo_belgium') }}" alt="Ladies’ Circle Belgium" class="mt-6 h-14 w-auto opacity-90">
            </div>
        </div>
        <div class="border-t border-cream/10 py-4 text-center text-xs text-cream/60">
            © {{ date('Y') }} {{ config('club.name') }}
        </div>
    </footer>
    @livewireScripts
</body>
</html>
