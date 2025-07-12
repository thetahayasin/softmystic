@extends('layouts.app')
@section('meta_title'){{ $meta_title ?? '' }}@endsection
@section('meta_description'){{ \Illuminate\Support\Str::limit($meta_description ?: '', 140, '...') }}@endsection

@section('styles')
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv = "refresh" content = "2; url = {{ $software->download_url }}" />

    @if(!empty($alternateUrls))
        @foreach ($alternateUrls as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] != $default_locale_key ? $alt['hreflang'] : 'x-default' }}" href="{{ $alt['url'] }}" />
        @endforeach
    @endif


@endsection

@section('content')

    <!-- ad 1 -->
    @if(!empty($ads['download_page_ad']))
        <section class="w-full px-4 mt-5 mb-5 flex justify-center items-center bg-base-200/40 card">
            <div class="w-full max-w-[728px] min-w-[300px] text-center text-center">
                {!! $ads['download_page_ad'] !!}
            </div>
        </section>
    @endif

    <!-- Breadcrumbs -->
    <nav class="text-sm breadcrumbs text-gray-500 px-2 mb-5">
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
    <section class="flex flex-col md:flex-row md:items-center md:justify-between space-y-6 md:space-y-0 border-b pb-6 text-center md:text-left px-2">
        <div class="flex flex-col items-center md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <img 
                src="{{ $software->logo ? asset('storage/' . $software->logo) : 'https://placehold.co/80x80?text=Logo' }}" 
                alt="{{ $software->name }} logo" 
                title="{{ $software->name }}" 
                width="60" 
                height="60" 
                loading="lazy" 
                class="rounded-lg"
            />  
            <h1 class="text-lg font-bold">{{ $downloading_text ?? 'Downloading...' }}</h1>


        </div>
        <div class="flex flex-col items-center md:items-end space-y-2">
            <span class="loading loading-bars loading-lg"></span>
        </div>
    </section>

    <!-- ad 2 -->
    @if(!empty($ads['download_page_ad_2']))
        <section class="w-full px-4 mt-5 flex justify-center items-center bg-base-200/40 card">
            <div class="w-full max-w-[728px] min-w-[300px] text-center text-center">
                {!! $ads['download_page_ad_2'] !!}
            </div>
        </section>
    @endif



    @if (!empty($related) && count($related) > 0)
        <!-- Related Apps -->
        <section id="related" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-5 mt-5">
            <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->popular ?? 'Popular Apps' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                @foreach ($related as $app)
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
    @endif





@endsection
