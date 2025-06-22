@extends('layouts.app')

@section('meta_title'){{ $meta_title ?? '' }} - {{ $ads->site_name }}@endsection
@section('meta_description'){{ \Illuminate\Support\Str::limit($meta_description, 120, '...') }}@endsection
@section('styles')
<link rel="canonical" href="{{ $cannonical }}">
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
    "@type": "ItemList",
    "name": "{{ $meta_title }}",
    "itemListElement": [
        @foreach ($softwares as $index => $software)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "url": "{{ $software['url'] }}",
            "name": "{{ $software['name'] }}",
            "image": "{{ asset('storage/' . $software['logo']) }}",
            "description": "{{ $software['tagline'] }}"
        }@if (!$loop->last),@endif
        @endforeach
    ]
    }
    </script>

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $trns->home_meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{{ $trns->home_meta_description ?? '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $cannonical }}" />
    @if($ads->site_logo)
    <meta property="og:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit($meta_description ?: '', 120, '...') }}" />
    @if($ads->site_logo)
    <meta name="twitter:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif
    @if(!empty($alternateUrls))
        @foreach ($alternateUrls as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] != $default_locale_key ? $alt['hreflang'] : 'x-default' }}" href="{{ $alt['url'] }}" />
        @endforeach
    @endif

@endsection

@section('content')

<nav class="text-sm breadcrumbs text-gray-500 px-2 mb-4">
    <ul>
        <li><a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">Home</a></li>
        <li><a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">Category</a></li>
    </ul>
</nav>

@if($ads['results_page_ad'] != null)
<section class="w-full px-4 mb-10 flex justify-center items-center mt-10">
    
        <div class="max-w-full text-center">
            {!! $ads['results_page_ad'] !!}
        </div>
    
</section>
@endif

<section class="space-y-4 w-full max-w-8xl px-2 overflow-hidden relative group mb-10">


    <!-- Software Card -->
     @foreach($softwares as $software)
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 card bg-base-200 ">
        <div class="flex items-start gap-4">
            <img src="{{ asset('storage/' . $software['logo']) }}" alt="{{ $software['name'] }} Logo" class="w-12 h-12 object-contain">
            <div>
                <a href="{{ $software['url'] }}">
                    <h2 href="#" class="text-xl font-bold text-base-content hover:underline">{{ $software['name'] }}</h2>
                </a>
                <div class="text-sm">{{ $software['updated'] }} - {{ $software['fileSize'] }} - {{ $software['license'] }}</div>
                <p class="text-sm mt-2">{{ $software['tagline'] }}</p>
            </div>
        </div>
        <a href="{{ $software['url'] }}" class="btn btn-primary btn-sm sm:btn-md px-4 sm:w-32">Download</a>
    </div>
    @endforeach
    <div>
    {{ $softwares->links('vendor.pagination.daisyui') }}
    </div>
    @if($ads['results_page_ad_2'] != null)
    <section class="w-full px-4 mb-10 flex justify-center items-center mt-10">

        <div class="max-w-full text-center">
            {!! $ads['results_page_ad_2'] !!}
        </div>
    </section>
    @endif


</section>


@endsection
