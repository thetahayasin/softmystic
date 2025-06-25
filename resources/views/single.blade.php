@extends('layouts.app')
@section('meta_title'){{ $meta_title ?? '' }} - {{ $ads->site_name }}@endsection
@section('meta_description'){{ \Illuminate\Support\Str::limit($meta_description ?: '', 120, '...') }}@endsection

@section('styles')
<link rel="canonical" href="{{ $software->url }}">
    <meta name="robots" content="index, follow" />
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($meta_description ?: '', 120, '...') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $software->url }}" />
    <meta property="og:image" content="{{ asset('storage/' . $software->logo) }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit($meta_description ?: '', 120, '...') }}" />
    <meta name="twitter:image" content="{{ asset('storage/' . $software->logo) }}" />
    @if(!empty($alternateUrls))
        @foreach ($alternateUrls as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] != $default_locale_key ? $alt['hreflang'] : 'x-default' }}" href="{{ $alt['url'] }}" />
        @endforeach
    @endif

    <script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}"
        },
        {
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $software->category->categoryTranslations->first()?->name }}",
        "item": "{{ $category_url }}"
        },
        {
        "@type": "ListItem",
        "position": 3,
        "name": "{{ $software->name }} {{ $software->version }}",
        "item": "{{ $software->url }}"
        }
    ]
    }
    </script>
    <script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "{{ $software->name }}",
    "softwareVersion": "{{ $software->version }}",
    "description": @json(Str::limit(strip_tags($software->softwareTranslations->first()?->content), 300)),
    "image": "{{ asset('storage/' . $software->logo) }}",
    "fileSize": "{{ $software->file_size }}",
    "operatingSystem": "{{ $software->platform->name }}",
    "license": "{{ $software->license->licenseTranslations->first()?->name ?? 'Free' }}",
    "applicationCategory": "{{ $software->category->categoryTranslations->first()?->name }}",
    "author": {
        "@type": "Organization",
        "name": "{{ $software->author->name }}"
    },
    "offers": {
        "@type": "Offer",
        "price": 0.00,
        "priceCurrency": "USD"
    }@if ($software->total_ratings > 0),
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ number_format($software->average_rating, 1) }}",
        "ratingCount": "{{ $software->total_ratings }}",
        "bestRating": "10",
        "worstRating": "2"
    }
    @endif
    }
    </script>



@endsection

@section('content')

<div class="px-2 lg:px-0">

    <!-- ad 1 -->
    @if($ads['single_page_ad'] != null)
        <div class="card bg-secondary/10 hover:bg-primary/5 transition duration-300 ease-in-out rounded-2xl mb-10 mt-10">
            {!! $ads['single_page_ad'] !!}
        </div>
    @endif

    <!-- Breadcrumbs -->
    <nav class="text-sm breadcrumbs text-gray-500 px-2 mb-10">
        <ul>
        <li>
            <a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">
                <svg class="home-icon w-4 h-4 fill-current text-base-content" viewBox="0 0 20 20">
                    <path d="M10 2.5L2.5 8.75V17.5H7.5V12.5H12.5V17.5H17.5V8.75L10 2.5Z" />
                </svg>
            </a>
        </li>
        <li><a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">{{ $software->platform->name }}</a></li>
        <li><a href="{{ $category_url }}" class="text-base-content">{{ $software->category->categoryTranslations->first()?->name }}</a></li>

        <li class="text-base-content/70">{{ $software->name }} {{ $software->version }}</li>
        </ul>
    </nav>

    <!-- App Header -->
    <section class="flex flex-col md:flex-row md:items-center md:justify-between space-y-6 md:space-y-0 border-b pb-6 text-center md:text-left">
        <div class="flex flex-col items-center md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
        <img 
            src="{{ $software->logo ? asset('storage/' . $software->logo) : 'https://placehold.co/80x80?text=Logo' }}" 
            alt="{{ $software->name }} logo" 
            title="{{ $software->name }}" 
            width="80" 
            height="80" 
            loading="lazy" 
            class="rounded-lg"
        />     
        <div class="space-y-1">
            <h1 class="text-xl font-semibold text-base-content">{{ $software->name }}</h1>

            <p class="italic text-sm text-base-content">{{ $software->softwareTranslations->first()?->tagline }}</p>

            <livewire:software-rating :software="$software" />
        </div>
        </div>
        <div class="flex flex-col items-center md:items-end space-y-2">
            <a href="{{ $downloadUrl }}" 
            class="btn btn-primary w-64" 
            rel="nofollow noopener noreferrer" 
            title="Download {{ $software->name }}">
            {{ $trns->download ?? 'Download' }}
            </a>

            <a href="{{ $software->buy_url }}" 
            class="btn btn-secondary w-64" 
            target="_blank"
            rel="nofollow noopener noreferrer" 
            title="Buy {{ $software->name }}">
            {{ $trns->buy_now ?? 'Buy Now' }}
            </a>
        </div>
    </section>


    <!-- Info Cards Slider -->
    <section class="w-full max-w-8xl overflow-hidden relative group mb-4 mt-6">
        <div id="carousel-app" class="carousel flex space-x-4 snap-x overflow-x-scroll scrollbar-hide scroll-smooth">
            <article class="card bg-base-200 rounded-2xl min-w-[160px] p-3 flex-shrink-0">
                <h3 class="text-sm font-semibold">Author</h3>
                <p class="text-sm line-clamp-1">{{ $software->author->first()?->name }}</p>
            </article>
            <article class="card bg-base-200 rounded-2xl min-w-[160px] p-3 flex-shrink-0">
                <h3 class="text-sm font-semibold">Version</h3>
                <p class="text-sm line-clamp-1">{{ $software->version }}</p>
            </article>
            <article class="card bg-base-200 rounded-2xl min-w-[160px] p-3 flex-shrink-0">
                <h3 class="text-sm font-semibold">License</h3>
                <button class="text-sm line-clamp-1 badge-outline text-xs badge" onclick="license_modal.showModal()">{{ $software->license->licenseTranslations->first()?->name }}</button>
            </article>
            <article class="card bg-base-200 rounded-2xl min-w-[160px] p-3 flex-shrink-0">
                <h3 class="text-sm font-semibold">Category</h3>
                <p class="text-sm line-clamp-1">{{ $software->category->categoryTranslations->first()?->name }}</p>
            </article>
            <article class="card bg-base-200 rounded-2xl min-w-[160px] p-3 flex-shrink-0">
                <h3 class="text-sm font-semibold">Size</h3>
                <p class="text-sm line-clamp-1">{{ $software->readableFilesize }}</p>
            </article>
            <article class="card bg-base-200 rounded-2xl min-w-[160px] p-3 flex-shrink-0">
                <h3 class="text-sm font-semibold">Requirements</h3>
                <div class="flex flex-wrap gap-1 text-sm">
                    @forelse($software->requirements as $requirement)
                        <span class="badge badge-outline text-xs text-base-content">{{ $requirement->name }}</span>
                    @empty
                        <span class="text-xs italic text-gray-500 text-base-content">No requirements listed</span>
                    @endforelse
                </div>
            </article>
        </div>
        <!-- Left Scroll Button -->
        <button aria-label="Previous Slide" id="left-btn"
            class="absolute left-0 top-1/4 bg-secondary rounded-full border-none shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle btn-sm text-secondary-content
            hover:bg-secondary transition-all duration-300"
            onclick="scrollCarousel_app(-1)">
            ❮
        </button>

        <!-- Right Scroll Button -->
        <button aria-label="Next Slide" id="right-btn"
            class="absolute right-0 border-none top-1/4 bg-secondary rounded-full shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle btn-sm text-secondary-content
            hover:bg-secondary transition-all duration-300"
            onclick="scrollCarousel_app(1)">
            ❯
        </button>
    </section>



    <!-- Description -->
    <section class="space-y-4 text-base-content leading-relaxed text-justify pb-4">
        {!! $software->softwareTranslations->first()?->content !!}
    </section>

    <!-- ad 2 -->
    @if($ads['single_page_ad_2'] != null)
        <div class="card bg-secondary/10 hover:bg-primary/5 transition duration-300 ease-in-out rounded-2xl mb-4">
            {!! $ads['single_page_ad_2'] !!}
        </div>
    @endif

    @if(!empty($software->screenshots) && is_array($software->screenshots) && count($software->screenshots))
        <!-- Screenshots -->
        <section class="overflow-x-auto space-x-4 flex mb-10" aria-label="Software Screenshots">
            @foreach($software->screenshots as $index => $screenshot)
                <img
                    src="{{ asset('storage/' . $screenshot) }}"
                    class="rounded-2xl flex-shrink-0 w-auto h-[200px]"
                    alt="{{ $software->name }} Screenshot {{ $index + 1 }}"
                    loading="lazy"
                    width="300"
                />
            @endforeach
        </section>
    @endif

    <!-- Related Apps -->
    <section id="related" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->related ?? 'Related Apps' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($related as $app)
                <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                    <div class="flex items-center p-4 bg-base-200 rounded-2xl hover:bg-base-300 transition duration-300 ease-in-out">
                        <img loading="lazy" src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-12 h-12 rounded-lg mr-4">
                        <div>
                            <h3 class="font-bold line-clamp-1 text-base-content" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                            <p class="text-sm opacity-70 line-clamp-2 text-base-content" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>


</div>

<dialog id="license_modal" class="modal">
  <div class="modal-box bg-base-200">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h2 class="text-lg font-bold text-base-content">{{ $software->license->licenseTranslations->first()?->name }}</h2>
    <p class="py-4 text-base-content">{{ $software->license->licenseTranslations->first()?->description }}</p>
  </div>
</dialog>


@endsection
