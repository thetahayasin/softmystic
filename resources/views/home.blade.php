@extends('layouts.app')

@section('meta_title'){{ $trns->home_meta_title ?? '' }} - {{ $ads->site_name }}@endsection
@section('meta_description'){{ \Illuminate\Support\Str::limit(optional($trns)->home_meta_description, 120, '...') }}@endsection
@section('styles')
<link rel="canonical" href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}">
    <meta name="robots" content="index, follow" />
    @php
        $logoPath = public_path('storage/' . $ads->site_logo);

        if ($ads->site_logo && file_exists($logoPath) && is_file($logoPath)) {
            [$width, $height] = getimagesize($logoPath);
        } else {
            $width = $height = 0; // fallback values
        }
    @endphp
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebPage",
      "url": "{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}",
      "name": "{{ $trns->home_meta_title ?? '' }} – {{ $ads->site_name }}",
      "description": "{{ $trns->home_meta_description ?? '' }}",
      "inLanguage": "{{ app()->getLocale() }}",
      "publisher": {
        "@type": "Organization",
        "name": "{{ $ads->site_name }}",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('storage/'.$ads->site_logo) }}"
        }
      },
      "image": {
        "@type": "ImageObject",
        "url": "{{ asset('storage/'.$ads->site_logo) }}",
        "width": {{ $width }},
        "height": {{ $height }},
        "caption": "{{ $ads->site_name }} Website Logo"
      }
    }
    </script>
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $trns->home_meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{{ $trns->home_meta_description ?? '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('storage/'.$ads->site_logo) }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $trns->home_meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{{ $trns->home_meta_description ?? '' }}" />
    <meta name="twitter:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
@foreach ($locales as $locale)
    <link rel="alternate" hreflang="{{ $locale['slug'] != $default_locale_slug ? $locale['key'] : 'x-default' }}" href="{{ route('home', ['param1' => $locale['slug'] != $default_locale_slug ? $locale['slug'] : null, 'param2' => $platform_slug ]) }}">
@endforeach

@endsection

@section('content')
<section class="w-full px-4 mb-10 flex justify-center items-center mt-10">
    @if($ads['home_page_ad'] != null)
        <div class="max-w-full text-center">
            {!! $ads['home_page_ad'] !!}
        </div>
    @endif
</section>
    <!-- Hero Section -->
    <section class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <div class="hero flex flex-col px-2 items-center justify-center bg-secondary/10 border border-white/20 backdrop-blur-lg rounded-2xl p-8 md:p-16 relative overflow-hidden">
            <div class="max-w-2xl text-center sm:mb-2">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight tracking-tight bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">
                    {{ $trns->hero_title ?? 'Default' }}
                </h1>
                <p class="text-lg md:text-2xl mb-8 font-medium">
                    {{ $trns->hero_text ?? 'Default' }}
                </p>
            </div>

            <!-- Down Scroll Button -->
            <button 
                class="absolute bottom-6 animate-bounce" 
                onclick="document.getElementById('featured').scrollIntoView({ behavior: 'smooth' })"
                aria-label="Scroll to Featured Section"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 hover:text-accent transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </section>


    
    <!-- Featured Downloads Section -->
    <section id="featured" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 class="text-xl font-bold mb-5">{{ $trns->featured_apps ?? 'Default' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($featured as $app)
                <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                    <div class="card bg-secondary/10 hover:bg-primary/5 transition duration-300 ease-in-out rounded-2xl">
                        <figure class="px-3 pt-5">
                            <img loading="lazy" src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="rounded-xl w-24 h-24 object-cover" />
                        </figure>
                        <div class="card-body py-4">
                            <h3 class="card-title line-clamp-1" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                            <p class="text-sm line-clamp-2" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                            <div class="card-actions justify-between items-center mt-4">
                                <div class="flex items-center text-xs font-semibold">
                                    <span>{{ $app['author'] }}</span>
                                </div>
                                <span class="text-xs text-gray-500 font-semibold">{{ $app['version'] }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            @if($ads['home_page_ad_2'] != null)
                <div class="card bg-secondary/10 hover:bg-primary/5 transition duration-300 ease-in-out rounded-2xl h-60">
                    {!! $ads['home_page_ad_2'] !!}
                </div>
            @endif
        </div>
    </section>

    <!-- Latest Updates -->
    <section id="latest-updates" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 class="text-xl font-bold mb-5">{{ $trns->latest_updates ?? 'Default' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            @foreach ($updates as $app)
                <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                    <div class="flex items-center p-4 bg-base-100 rounded-2xl hover:bg-primary/5 transition duration-300 ease-in-out">
                        <img loading="lazy" src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-12 h-12 rounded-lg mr-4">
                        <div>
                            <h3 class="font-bold line-clamp-1" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                            <p class="text-sm opacity-70 line-clamp-1" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- New Releases -->
    <section id="new-releases" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 class="text-xl font-bold mb-5">{{ $trns->new_releases ?? 'Default' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($newreleases as $app)
                <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                    <div class="flex items-center p-4 bg-base-100 rounded-2xl hover:bg-primary/5 transition duration-300 ease-in-out">
                        <img loading="lazy" src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-12 h-12 rounded-lg mr-4">
                        <div>
                            <h3 class="font-bold line-clamp-1" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                            <p class="text-sm opacity-70 line-clamp-1" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Trending / Popular Apps -->
    <section class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 class="text-xl font-bold mb-5">{{ $trns->trending_apps ?? 'Default' }}</h2>
        <div id="carousel-app" class="carousel flex space-x-4 snap-x overflow-x-scroll scrollbar-hide scroll-smooth">
            @foreach ($popular as $app)
                <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                    <div class="carousel-item w-24 h-auto flex-shrink-0 flex flex-col items-center text-center justify-start p-4 rounded-lg hover:bg-primary/5 transition duration-300 ease-in-out">
                        <img loading="lazy" src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-24 h-24 rounded-lg">
                        <div class="flex flex-col items-center justify-start mt-2">
                            <h3 class="font-semibold text-sm text-center line-clamp-2" title="{{ $app['name'] }}">
                                {{ $app['name'] }}
                            </h3>
                            <p class="text-xs text-gray-500 text-center line-clamp-3 hover:text-gray-700 transition duration-300 ease-in-out" title="{{ $app['tagline'] }}">
                                {{ $app['tagline'] }}
                            </p>
                        </div>
                    </div>
                </a>     
            @endforeach
        </div>

        <!-- Left Scroll Button -->
        <button aria-label="Previous Slide" id="left-btn"
            class="absolute left-0 top-1/2 bg-accent rounded-full border-none shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle btn-sm
            hover:bg-accent transition-all duration-300"
            onclick="scrollCarousel_app(-1)">
            ❮
        </button>

        <!-- Right Scroll Button -->
        <button aria-label="Next Slide" id="right-btn"
            class="absolute right-0 border-none top-1/2 bg-accent rounded-full shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle btn-sm
            hover:bg-accent transition-all duration-300"
            onclick="scrollCarousel_app(1)">
            ❯
        </button>
    </section>

@endsection
