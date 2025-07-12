@extends('layouts.app')

@section('meta_title'){{ $trns->home_meta_title ?? '' }}@endsection
@section('meta_description'){{ \Illuminate\Support\Str::limit(optional($trns)->home_meta_description, 140, '...') }}@endsection
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
    {{-- WebSite Structured Data --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{$ads->site_name}}", 
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/search') }}/{locale}/{platform}/{query}",
    "query-input": [
      "required name=locale",
      "required name=platform",
      "required name=query"
    ]
  }
}
</script>

{{-- WebPage Structured Data --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "url": "{{ route('home', ['param1' => $locale_slug, 'param2' => $platform_slug]) }}",
  "name": "{{ addslashes($trns->home_meta_title ?? '') }} – {{ addslashes($ads->site_name ?? '') }}",
  "description": "{{ addslashes($trns->home_meta_description ?? '') }}",
  "inLanguage": "{{ app()->getLocale() }}",
  "publisher": {
    "@type": "Organization",
    "name": "{{ addslashes($ads->site_name ?? '') }}"
    @if($ads->site_logo)
    ,"logo": {
      "@type": "ImageObject",
      "url": "{{ asset('storage/'.$ads->site_logo) }}"
    }
    @endif
  }
  @if (!empty($ads->site_logo) && isset($width) && isset($height))
  ,
  "image": {
    "@type": "ImageObject",
    "url": "{{ asset('storage/'.$ads->site_logo) }}",
    "width": {{ $width }},
    "height": {{ $height }},
    "caption": "{{ addslashes($ads->site_name ?? '') }} Website Logo"
  }
  @endif
}
</script>

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $trns->home_meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{{ $trns->home_meta_description ?? '' }}" />
    <meta property="og:type" content="website" />
   <meta property="og:url" content="{{ url()->current() }}" />
    @if($ads->site_logo)
    <meta property="og:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $trns->home_meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{{ $trns->home_meta_description ?? '' }}" />
    @if($ads->site_logo)
    <meta name="twitter:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif
@foreach ($locales as $locale)
    <link rel="alternate" hreflang="{{ $locale['slug'] != $default_locale_slug ? $locale['key'] : 'x-default' }}" href="{{ route('home', ['param1' => $locale['slug'] != $default_locale_slug ? $locale['slug'] : null, 'param2' => $platform_slug ]) }}">
@endforeach

@endsection

@section('content')

    @if($ads['home_page_ad'] != null)
    <section class="card w-full px-4 flex justify-center items-center mt-5 bg-base-200/40 items-center text-center">
        
            <div class="w-full max-w-[728px] min-w-[300px] text-center text-center">
                {!! $ads['home_page_ad'] !!}
            </div>
        
    </section>
    @endif
    <section class="w-full max-w-8xl overflow-hidden relative group mb-5 mt-5 min-h-[400px] sm:min-h-0">
        <div class="card flex flex-col lg:flex-row items-center justify-between bg-base-100 border border-base-300 backdrop-blur-lg p-6 md:p-12 relative overflow-hidden gap-6">
            
            <!-- Left: Text Content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl md:text-4xl font-extrabold mb-4 leading-tight tracking-tight bg-gradient-to-r from-primary via-secondary to-secondary bg-clip-text text-transparent">
                    {{ $trns->hero_title ?? 'Default' }}
                </h1>
                <p class="text-lg md:text-2xl mb-8 font-medium text-base-content">
                    {{ $trns->hero_text ?? 'Default' }}
                </p>
            </div>
    
            <!-- Right: Software Cards -->
            <div class="w-full lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($sponsored as $app)
                    <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}" class="flex flex-col h-full">
                        <div class="card bg-base-100 shadow-sm border border-base-300 hover:bg-base-200/40 transition duration-300 relative flex flex-col h-full">
                            
                            <!-- Star Icon -->
                            <div class="absolute top-2 right-2 bg-base text-white p-1 rounded-full shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L15.09 8.26 22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
    
                            <!-- Image -->
                            <figure class="px-4 pt-4 min-h-[96px] flex justify-center">
                                <img
                                    src="{{ asset('storage/' . $app['logo']) }}"
                                    loading="lazy"
                                    alt="{{ $app['name'] }} Logo"
                                    width="96"
                                    height="96"
                                    class="rounded-xl w-24 h-24 object-cover mx-auto"
                                />
                            </figure>
    
                            <!-- Body -->
                            <div class="card-body pt-2 text-center flex flex-col flex-grow justify-between">
                                <div class="mt-2">
                                    <h2 class="card-title justify-center line-clamp-2">{{ $app['name'] }}</h2>
                                    <p class="text-sm text-base-content opacity-70 pb-2 line-clamp-3">{{ $app['tagline'] }}</p>
                                </div>
                                <div class="card-actions mt-4">
                                    <button class="btn btn-primary btn-sm w-full">
                                        {{ $trns->download ?? 'Download' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    
        
        <!-- Featured Downloads Section -->
        <section id="featured" class="w-full max-w-8xl overflow-hidden relative group mb-5">
            <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->featured_apps ?? 'Default' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($featured as $app)
                <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                    <div class="card bg-base-100 border border-base-300 hover:bg-base-200/40 transition duration-300 ease-in-out items-center text-center h-full">
                        
                        <!-- Image -->
                        <figure class="px-3 pt-5">
                            <img loading="lazy" src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="rounded-xl w-24 h-24 object-cover" />
                        </figure>
    
                        <!-- Content -->
                        <div class="card-body py-4 items-center text-center">
                            <h3 class="card-title line-clamp-1 text-base-content justify-center" title="{{ $app['name'] }}">
                                {{ $app['name'] }}
                            </h3>
    
                            <p class="text-sm line-clamp-2 text-base-content opacity-70" title="{{ $app['tagline'] }}">
                                {{ $app['tagline'] }}
                            </p>
    
                        </div>
                    </div>
                </a>
            @endforeach
    
                @if($ads['home_page_ad_2'] != null)
                    <div class="card bg-base-200/40 items-center text-center max-w-[252px] max-h-[226px] min-w-[252px] min-h-[226px] w-full">
                        {!! $ads['home_page_ad_2'] !!}
                    </div>
                @endif
            </div>
        </section>
    
        <!-- Latest Updates -->
        <section id="latest-updates" class="w-full max-w-8xl overflow-hidden relative group mb-5">
            <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->latest_updates ?? 'Default' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($updates as $app)
                    <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                        <div class="card flex-row items-center p-4 bg-base-100 border border-base-300 hover:bg-base-200/40 transition duration-300 ease-in-out h-full">
                            <img
                                loading="lazy"
                                src="{{ asset('storage/' . $app['logo']) }}"
                                alt="{{ $app['name'] }} Logo"
                                class="w-12 h-12 rounded-lg mr-4 flex-shrink-0"
                            >
                            <div class="flex flex-col">
                                <h3 class="font-bold line-clamp-1 text-base-content" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                                <p class="text-sm opacity-70 line-clamp-2 text-base-content" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- New Releases -->
        <section id="latest-updates" class="w-full max-w-8xl overflow-hidden relative group mb-5">
            <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->new_releases ?? 'Default' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($newreleases as $app)
                    <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                        <div class="card flex-row items-center p-4 bg-base-100 border border-base-300 hover:bg-base-200/40 transition duration-300 ease-in-out h-full">
                            <img
                                loading="lazy"
                                src="{{ asset('storage/' . $app['logo']) }}"
                                alt="{{ $app['name'] }} Logo"
                                class="w-12 h-12 rounded-lg mr-4 flex-shrink-0"
                            >
                            <div class="flex flex-col">
                                <h3 class="font-bold line-clamp-1 text-base-content" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                                <p class="text-sm opacity-70 line-clamp-2 text-base-content" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    
    
    <!-- Trending / Popular Apps -->
    <section class="w-full max-w-8xl overflow-hidden relative group mb-5">
        <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->trending_apps ?? 'Default' }}</h2>
    
        <div id="carousel-app"
             class="carousel flex items-stretch space-x-4 snap-x overflow-x-scroll scrollbar-hide scroll-smooth">
            @foreach ($popular as $app)
                <a href="{{ $app['url'] }}"
                   title="{{ $app['name'] }} - {{ $app['tagline'] }}"
                   aria-label="Download {{ $app['name'] }}"
                   class="carousel-item w-32 sm:w-40 flex-shrink-0">
                    <div class=" card flex flex-col bg-base-100 border border-base-300 hover:bg-base-200/40 transition duration-300 ease-in-out rounded-lg p-4 h-full w-full">
                        
                        <!-- Logo -->
                        <img loading="lazy"
                             src="{{ asset('storage/' . $app['logo']) }}"
                             alt="{{ $app['name'] }} Logo"
                             class="w-24 h-24 mx-auto rounded-lg object-cover" />
    
                        <!-- Content -->
                        <div class="flex flex-col mt-2 flex-grow justify-top">
                            <h3 class="font-semibold text-sm text-center line-clamp-2 text-base-content" title="{{ $app['name'] }}">
                                {{ $app['name'] }}
                            </h3>
                            <p class="text-xs text-center text-base-content opacity-70 line-clamp-3" title="{{ $app['tagline'] }}">
                                {{ $app['tagline'] }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    
        <!-- Scroll Buttons -->
        <button aria-label="Previous Slide" id="left-btn"
            class="absolute left-0 top-1/2 border border-white/20 bg-secondary hover:bg-secondary text-secondary-content rounded-full shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle btn-sm transition-all duration-300"
            onclick="scrollCarousel_app(-1)">
            ❮
        </button>
    
        <button aria-label="Next Slide" id="right-btn"
            class="absolute right-0 top-1/2 border border-white/20 bg-secondary hover:bg-secondary text-secondary-content rounded-full shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle btn-sm transition-all duration-300"
            onclick="scrollCarousel_app(1)">
            ❯
        </button>
    </section>    



@endsection

