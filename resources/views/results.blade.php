@extends('layouts.app')

@section('meta_title')
    {{ $meta_title ?? '' }}
@endsection

@section('meta_description')
    {!! \Illuminate\Support\Str::limit($meta_description, 140, '...') !!}
@endsection

@section('styles')
    <link rel="canonical" href="{{ $cannonical }}">
    <meta name="robots" content="index, follow" />

    @php
        $logoPath = public_path('storage/' . $ads->site_logo);
        if ($ads->site_logo && file_exists($logoPath) && is_file($logoPath)) {
            [$width, $height] = getimagesize($logoPath);
        } else {
            $width = $height = 0;
        }
    @endphp

    @if($softwares->isNotEmpty())
    {{-- JSON-LD: ItemList for Search Results --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "name": "{!! addslashes($meta_title) !!}",
      "itemListElement": [
        @foreach ($softwares as $index => $software)
        {
          "@type": "ListItem",
          "position": {{ $index + 1 }},
          "url": "{{ $software['url'] }}",
          "name": "{{ addslashes($software['name']) }}",
          "image": "{{ asset('storage/' . $software['logo']) }}",
          "description": "{!! addslashes($software['tagline']) !!}"
        }@if (!$loop->last),@endif
        @endforeach
      ]
    }
    </script>
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
        "name": "{{ $platform_name }}",
        "item": "{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}"
        },
        {
        "@type": "ListItem",
        "position": 3,
        "name": "{{ $meta_title }}",
        "item": "{{ $cannonical }}"
        }
    ]
    }
    </script>

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($meta_description ?? '', 140) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $cannonical }}" />
    @if($ads->site_logo)
        <meta property="og:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit($meta_description ?? '', 140) }}" />
    @if($ads->site_logo)
        <meta name="twitter:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif

    {{-- Alternate Locales --}}
    @if(!empty($alternateUrls))
        @foreach ($alternateUrls as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] !== $default_locale_key ? $alt['hreflang'] : 'x-default' }}" href="{{ $alt['url'] }}" />
        @endforeach
    @endif
@endsection

@section('content')
    {{-- Breadcrumbs --}}
    <nav class="text-sm breadcrumbs mb-5" aria-label="Breadcrumb">
        <ul>
            <li>
                <a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">
                    <svg class="home-icon w-4 h-4 fill-current text-base-content" viewBox="0 0 20 20">
                        <path d="M10 2.5L2.5 8.75V17.5H7.5V12.5H12.5V17.5H17.5V8.75L10 2.5Z" />
                    </svg>
                </a>
            </li>
            <li><a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">{{ $platform_name }}</a></li>
            <li><span class="text-base-content font-medium">{{ Route::currentRouteName() == 'result.index' ? $trns?->search_results.' "'.$q.'"' : $cat_name }}</span></li>
        </ul>
    </nav>


    <section id="new-releases" class="w-full max-w-8xl overflow-hidden relative group">
        {{-- Top Ad --}}
        @if(!empty($ads['results_page_ad']))
            <section class="w-full px-4 flex justify-center items-center bg-base-200/40 card mb-5">
                <div class="w-full max-w-[728px] min-w-[300px] text-center text-center">
                    {!! $ads['results_page_ad'] !!}
                </div>
            </section>
        @endif
        <h1 class="text-xl font-bold text-base-content mb-5">{{ Route::currentRouteName() == 'result.index' ? $trns?->search_results.' "'.$q.'"' : $cat_name }}</h2>
        @if(Route::currentRouteName() == 'category.index')
        <hr>
        <p class="text-md border-bottom mt-4 mb-5">{{ $cat_description }}</p>
        <hr class="mb-4">
        @endif   
    </section>

    {{-- Search Results --}}
    <section class="space-y-4 w-full max-w-8xl overflow-hidden relative group mb-5">
        @forelse($softwares as $software)
        
        <a href="{{ $software['url'] }}" class="block group">
            <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 card bg-base-100 hover:bg-base-200/40 border border-base-300 transition duration-300 ease-in-out">
                <!-- Content Section -->
                <div class="flex flex-col items-center sm:flex-row sm:items-start gap-4 text-center sm:text-left w-full">
                    <img src="{{ asset('storage/' . $software['logo']) }}" alt="{{ $software['name'] }} Logo" class="w-12 h-12 object-contain" loading="lazy">
                    <div>
                        <h2 class="text-xl font-bold text-base-content">{{ $software['name'] }}</h2>
                        <div class="text-sm">{{ $software['updated'] }} – {{ $software['fileSize'] }} – {{ $software['license'] }}</div>
                        <p class="text-sm mt-2">{{ $software['tagline'] }}</p>
                    </div>
                </div>
        
                <!-- Download Button -->
                <div class="z-10 w-full sm:w-auto">
                    <span class="btn btn-primary btn-sm sm:btn-md w-full sm:w-32">
                        {{ $trns->download ?? 'Download' }}
                    </span>
                </div>
            </div>
        </a>

        

        @empty
            <div class="text-center py-10 text-gray-400 text-lg">
                {{ $trns->nothing_found ?? 'Nothing Found' }}
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="pt-6">
            {{ $softwares->links('vendor.pagination.daisyui') }}
        </div>

        {{-- Bottom Ad --}}
        @if(!empty($ads['results_page_ad_2']))
            <section class="w-full px-4 mt-5 flex justify-center items-center bg-base-200/40 card">
                <div class="w-full max-w-[728px] min-w-[300px] text-center text-center">
                    {!! $ads['results_page_ad_2'] !!}
                </div>
            </section>
        @endif
    </section>
@endsection
