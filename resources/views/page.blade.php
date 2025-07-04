@extends('layouts.app')

@section('meta_title'){{ $page->translations->first()?->title ?? '' }} - {{ $ads->site_name }}@endsection
@section('meta_description'){{ \Illuminate\Support\Str::limit(strip_tags($page->translations->first()?->content ?? ''), 140, '...') }}@endsection

@section('styles')
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow" />

    <meta property="og:title" content="{{ $page->translations->first()?->title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($page->translations->first()?->content ?? ''), 140, '...') }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @if($ads->site_logo)
    <meta property="og:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $page->translations->first()?->title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($page->translations->first()?->content ?? ''), 140, '...') }}" />
    @if($ads->site_logo)
    <meta name="twitter:image" content="{{ asset('storage/'.$ads->site_logo) }}" />
    @endif
    @if(!empty($alternateUrls))
        @foreach ($alternateUrls as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] != $default_locale_key ? $alt['hreflang'] : 'x-default' }}" href="{{ $alt['url'] }}" />
        @endforeach
    @endif
    <script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "mainEntity": {
        "@type": "Article",
        "headline": @json($page->translations->first()?->title ?? ''),
        "description": @json(\Illuminate\Support\Str::limit(strip_tags($page->translations->first()?->content ?? ''), 140)),
        "author": {
        "@type": "Organization",
        "name": @json($ads->site_name)
        },
        "publisher": {
        "@type": "Organization",
        "name": @json($ads->site_name)
        @if($ads->site_logo)
        ,"logo": {
        "@type": "ImageObject",
        "url": "{{ asset('storage/'.$ads->site_logo) }}"
        }
        @endif
        },
        "url": "{{ url()->current() }}",
        "datePublished": "{{ $page->created_at->toIso8601String() }}",
        "dateModified": "{{ $page->updated_at->toIso8601String() }}"
    }
    }
    </script>
    <script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "{{ route('home', ['param1' => $locale_slug]) }}"
        },
        {
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $page->translations->first()?->title }}",
        "item": "{{ url()->current() }}"
        }
    ]
    }
    </script>


@endsection

@section('content')
<div class="px-2 lg:px-0">

    <!-- Ad Top -->
    @if($ads['single_page_ad'])
        <div class="card bg-base-200 max-h-[90px] transition duration-300 ease-in-out rounded-2xl mb-10 mt-10">
            {!! $ads['single_page_ad'] !!}
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav class="text-sm breadcrumbs text-gray-500 px-2 mb-10">
        <ul>
            <li>
                <a href="{{ route('home', ['param1' => $locale_slug]) }}" class="text-base-content">
                    <svg class="home-icon w-4 h-4 fill-current text-base-content" viewBox="0 0 20 20">
                        <path d="M10 2.5L2.5 8.75V17.5H7.5V12.5H12.5V17.5H17.5V8.75L10 2.5Z" />
                    </svg>
                </a>
            </li>
            <li class="text-base-content/70">{{ $page->translations->first()?->title }}</li>
        </ul>
    </nav>

    <!-- Page Title -->
    <section class="text-center md:text-left mb-6">
        <h1 class="text-2xl font-semibold text-base-content">{{ $page->translations->first()?->title }}</h1>
    </section>

    <!-- Page Content -->
    <section class="prose max-w-full text-base-content mb-10 content-wysiwyg">
        {!! $page->translations->first()?->content !!}
    </section>

    <!-- Ad Bottom -->
    @if($ads['single_page_ad_2'])
        <div class="card bg-base-200 transition duration-300 ease-in-out rounded-2xl mt-10 mb-4 max-h-[90px]">
            {!! $ads['single_page_ad_2'] !!}
        </div>
    @endif

</div>
@endsection
