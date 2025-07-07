@extends('layouts.app')
@section('meta_title'){{ $meta_title ?? '' }}@endsection
@section('meta_description'){!! \Illuminate\Support\Str::limit($meta_description ?: '', 140, '...') !!}@endsection

@section('styles')
<link rel="canonical" href="{{ $software->url }}">
    <meta name="robots" content="index, follow" />
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta property="og:description" content="{!! \Illuminate\Support\Str::limit($meta_description ?: '', 140, '...') !!}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $software->url }}" />
    <meta property="og:image" content="{{ asset('storage/' . $software->logo) }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $meta_title ?? '' }} - {{ $ads->site_name }}" />
    <meta name="twitter:description" content="{!! \Illuminate\Support\Str::limit($meta_description ?: '', 140, '...') !!}" />
    <meta name="twitter:image" content="{{ asset('storage/' . $software->logo) }}" />
    @if(!empty($alternateUrls))
        @foreach ($alternateUrls as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] != $default_locale_key ? $alt['hreflang'] : 'x-default' }}" href="{{ $alt['url'] }}" />
        @endforeach
    @endif
    @livewireStyles

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
    },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $software->total_ratings > 0 ? number_format($software->average_rating, 1) : '10.0' }}",
    "ratingCount": "{{ $software->total_ratings > 0 ? $software->total_ratings : 1 }}",
    "bestRating": "10",
    "worstRating": "2"
  }
    
    }
    </script>



@endsection

@section('content')


    <!-- ad 1 -->
    @if($ads['single_page_ad'] != null)
    <section class="w-full px-4 flex justify-center items-center mt-5 bg-base-200/40 card items-center text-center mb-5">
        
            <div class="max-w-full text-center max-h-[90px]">
                {!! $ads['single_page_ad'] !!}
            </div>
        
    </section>
    @endif

    <!-- Breadcrumbs -->
    <nav class="flex justify-between items-center text-sm breadcrumbs text-gray-500 px-2 mt-0 mb-7">
        <ul>
            <li>
                <a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content" aria-label="Home">
                    <svg class="home-icon w-4 h-4 fill-current text-base-content" viewBox="0 0 20 20">
                        <path d="M10 2.5L2.5 8.75V17.5H7.5V12.5H12.5V17.5H17.5V8.75L10 2.5Z" />
                    </svg>
                </a>
            </li>
            <li><a href="{{ route('home', [ 'param1' => $locale_slug, 'param2' => $platform_slug ]) }}" class="text-base-content">{{ $software->platform->name }}</a></li>
            <li><a href="{{ $category_url }}" class="text-base-content">{{ $software->category->categoryTranslations->first()?->name }}</a></li>

            <li class="text-base-content/70">{{ $software->name }} {{ $software->version }}</li>
        </ul>
        <div class="p-0">
                <button onclick="share_modal.showModal()" aria-label="Share Button">
                    <svg class="w-6 h-6 fill-current text-base-content" viewBox="-5 -5 24 24" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-share"><path d='M8 3.414v5.642a1 1 0 1 1-2 0V3.414L4.879 4.536A1 1 0 0 1 3.464 3.12L6.293.293a.997.997 0 0 1 1.414 0l2.829 2.828A1 1 0 1 1 9.12 4.536L8 3.414zM3 6a1 1 0 1 1 0 2H2v4h10V8h-1a1 1 0 0 1 0-2h1a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1z' /></svg>
                </button>

                <dialog id="share_modal" class="modal">
                    <div class="modal-box text-center bg-base-200">
                    <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>

                    <div class="flex justify-center items-center gap-4 flex-wrap">

                        <!-- Email -->
                        <a href="mailto:?subject={{ $meta_title ?? '' }} - {{ $ads->site_name }}&body={{ urlencode($software->url) }}" class="btn btn-circle bg-base-300 hover:bg-base-300 text-white" aria-label="Share on Mail">
                            <svg class="w-6 h-6 fill-current text-base-content" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">

                            <rect x="0" fill="none" width="20" height="20"/>

                            <g>

                            <path d="M3.87 4h13.25C18.37 4 19 4.59 19 5.79v8.42c0 1.19-.63 1.79-1.88 1.79H3.87c-1.25 0-1.88-.6-1.88-1.79V5.79c0-1.2.63-1.79 1.88-1.79zm6.62 8.6l6.74-5.53c.24-.2.43-.66.13-1.07-.29-.41-.82-.42-1.17-.17l-5.7 3.86L4.8 5.83c-.35-.25-.88-.24-1.17.17-.3.41-.11.87.13 1.07z"/>

                            </g>

                            </svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($software->url) }}" target="_blank" rel="noopener noreferrer" class="btn btn-circle bg-base-300 hover:bg-base-300 text-white" aria-label="Share on Facebook">
                            <svg class="w-6 h-6 fill-current text-base-content" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z"/>
                            </svg>
                        </a>

                        <!-- X (Twitter) -->
                        <a aria-label="Share on X" href="https://twitter.com/intent/tweet?url={{ urlencode($software->url) }}&text={{ $meta_title ?? '' }} - {{ $ads->site_name }}" target="_blank" rel="noopener noreferrer" class="btn btn-circle bg-base-300 hover:bg-base-300 text-white">
                            <svg fill="#000000" class="w-6 h-6 fill-current text-base-content" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="M22,5.8a8.49,8.49,0,0,1-2.36.64,4.13,4.13,0,0,0,1.81-2.27,8.21,8.21,0,0,1-2.61,1,4.1,4.1,0,0,0-7,3.74A11.64,11.64,0,0,1,3.39,4.62a4.16,4.16,0,0,0-.55,2.07A4.09,4.09,0,0,0,4.66,10.1,4.05,4.05,0,0,1,2.8,9.59v.05a4.1,4.1,0,0,0,3.3,4A3.93,3.93,0,0,1,5,13.81a4.9,4.9,0,0,1-.77-.07,4.11,4.11,0,0,0,3.83,2.84A8.22,8.22,0,0,1,3,18.34a7.93,7.93,0,0,1-1-.06,11.57,11.57,0,0,0,6.29,1.85A11.59,11.59,0,0,0,20,8.45c0-.17,0-.35,0-.53A8.43,8.43,0,0,0,22,5.8Z"/></svg>
                        </a>

                        <!-- LinkedIn -->
                        <a aria-label="Share on LinkedIn" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($software->url) }}&title={{ $meta_title ?? '' }} - {{ $ads->site_name }}&summary={{ \Illuminate\Support\Str::limit($meta_description ?: '', 120, '...') }}&source={{ $ads->site_name }}" target="_blank" rel="noopener noreferrer" class="btn btn-circle bg-base-300 hover:bg-base-300 text-white">
                            <svg fill="#000000" class="w-6 h-6 fill-current text-base-content" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 32 32" xml:space="preserve">
                                <path d="M23,0H9C4,0,0,4,0,9v14c0,5,4,9,9,9h14c5,0,9-4,9-9V9C32,4,28,0,23,0z M12,25c0,0.6-0.4,1-1,1H7c-0.6,0-1-0.4-1-1V13
                                    c0-0.6,0.4-1,1-1h4c0.6,0,1,0.4,1,1V25z M9,11c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S10.7,11,9,11z M26,25c0,0.6-0.4,1-1,1h-3
                                    c-0.6,0-1-0.4-1-1v-3.5v-1v-2c0-0.8-0.7-1.5-1.5-1.5S18,17.7,18,18.5v2v1V25c0,0.6-0.4,1-1,1h-3c-0.6,0-1-0.4-1-1V13
                                    c0-0.6,0.4-1,1-1h4c0.3,0,0.5,0.1,0.7,0.3c0.6-0.2,1.2-0.3,1.8-0.3c3,0,5.5,2.5,5.5,5.5V25z"/>
                            </svg>
                        </a>

                        <!-- WhatsApp -->
                        <a aria-label="Share on Whatsapp" href="https://wa.me/?text={{ urlencode($software->url) }}" target="_blank" rel="noopener noreferrer" class="btn btn-circle bg-base-300 hover:bg-base-300 text-white">
                            <svg fill="#000000" class="w-6 h-6 fill-current text-base-content" viewBox="-2 -2 24 24" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-whatsapp"><path d='M9.516.012C4.206.262.017 4.652.033 9.929a9.798 9.798 0 0 0 1.085 4.465L.06 19.495a.387.387 0 0 0 .47.453l5.034-1.184a9.981 9.981 0 0 0 4.284 1.032c5.427.083 9.951-4.195 10.12-9.58C20.15 4.441 15.351-.265 9.516.011zm6.007 15.367a7.784 7.784 0 0 1-5.52 2.27 7.77 7.77 0 0 1-3.474-.808l-.701-.347-3.087.726.65-3.131-.346-.672A7.62 7.62 0 0 1 2.197 9.9c0-2.07.812-4.017 2.286-5.48a7.85 7.85 0 0 1 5.52-2.271c2.086 0 4.046.806 5.52 2.27a7.672 7.672 0 0 1 2.287 5.48c0 2.052-.825 4.03-2.287 5.481z'/><path d='M14.842 12.045l-1.931-.55a.723.723 0 0 0-.713.186l-.472.478a.707.707 0 0 1-.765.16c-.913-.367-2.835-2.063-3.326-2.912a.694.694 0 0 1 .056-.774l.412-.53a.71.71 0 0 0 .089-.726L7.38 5.553a.723.723 0 0 0-1.125-.256c-.539.453-1.179 1.14-1.256 1.903-.137 1.343.443 3.036 2.637 5.07 2.535 2.349 4.566 2.66 5.887 2.341.75-.18 1.35-.903 1.727-1.494a.713.713 0 0 0-.408-1.072z'/></svg>
                        </a>

                    </div>

                    </div>
                </dialog>
            </div>
    </nav>

    <!-- App Header -->
    <section class="flex flex-col md:flex-row md:items-center md:justify-between space-y-6 md:space-y-0 border-b border-base-300 pb-6 text-center md:text-left">
    <div class="flex flex-col items-center md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">

        <!-- ✅ Wrap image in a fixed-size container -->
        <figure class="w-[80px] h-[80px] shrink-0 flex items-center justify-center">
            <img 
                src="{{ $software->logo ? asset('storage/' . $software->logo) : 'https://placehold.co/80x80?text=Logo' }}" 
                alt="{{ $software->name }} logo" 
                title="{{ $software->name }}" 
                width="80" 
                height="80" 
                loading="lazy" 
                class="rounded-lg w-[80px] h-[80px] object-cover"
            />
        </figure>

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

        @if ($software->buy_url != null)
            <a href="{{ $software->buy_url }}" 
               class="btn btn-secondary w-64" 
               target="_blank"
               rel="nofollow noopener noreferrer" 
               title="Buy {{ $software->name }}">
                {{ $trns->buy_now ?? 'Buy Now' }}
            </a>
        @endif
    </div>
</section>


    <!-- Info Cards Slider -->
    <section class="w-full max-w-8xl overflow-hidden relative group mb-4 mt-6">
        <div id="carousel-app" class="carousel flex space-x-4 snap-x overflow-x-scroll scrollbar-hide scroll-smooth">
            <article class="card bg-base-100 border border-base-300 min-w-[160px] p-3 flex-shrink-0">
                <h2 class="text-sm font-semibold">{{ $trns->author ?? 'Author' }}</h2>
                <a href="{{ $software->author?->url }}" class="text-primary underline hover:text-base-content" target="_blank">
                    <p class="text-sm line-clamp-1">{{ $software->author?->name }}</p>
                </a>
                
            </article>
            <article class="card bg-base-100 border border-base-300 min-w-[160px] p-3 flex-shrink-0">
                <h2 class="text-sm font-semibold">{{ $trns->version ?? 'Version' }}</h2>
                <p class="text-sm flex items-center gap-1 line-clamp-1">
                    {{ $software->version }}
                    @if($software->softwareTranslations->first()?->change_log != null)
                    <button class="text-sm line-clamp-1 badge-outline text-xs badge" onclick="version_modal.showModal()" aria-label="See Change Log">
                        <svg class="w-4 h-4 fill-current text-base-content" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    @endif
                </p>

            </article>
            <article class="card bg-base-100 border border-base-300 min-w-[160px] p-3 flex-shrink-0">
                <h2 class="text-sm font-semibold">{{ $trns->license ?? 'License' }}</h2>
                <button class="text-sm line-clamp-1 badge-outline text-xs badge" onclick="license_modal.showModal()">{{ $software->license->licenseTranslations->first()?->name }}</button>
            </article>
            <article class="card bg-base-100 border border-base-300 min-w-[160px] p-3 flex-shrink-0">
                <h2 class="text-sm font-semibold">{{ $trns->category ?? 'Category' }}</h2>
                <p class="text-sm line-clamp-1">{{ $software->category->categoryTranslations->first()?->name }}</p>
            </article>
            <article class="card bg-base-100 border border-base-300 min-w-[160px] p-3 flex-shrink-0">
                <h2 class="text-sm font-semibold">{{ $trns->size ?? 'Size' }}</h2>
                <p class="text-sm line-clamp-1">{{ $software->readableFilesize }}</p>
            </article>
            @if ($software->requirements->isNotEmpty())
                <article class="card bg-base-100 border border-base-300 min-w-[160px] p-3 flex-shrink-0">
                    <h2 class="text-sm font-semibold">{{ $trns->requirements ?? 'Requirements' }}</h2>
                    <div class="flex flex-wrap gap-1 text-sm">
                        @foreach($software->requirements as $requirement)
                            <span class="badge badge-outline text-xs text-base-content">{{ $requirement->name }}</span>
                        @endforeach
                    </div>
                </article>
            @endif

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
    <section class="space-y-4 text-base-content leading-relaxed text-justify pb-4 content-wysiwyg prose">
        {!! $software->softwareTranslations->first()?->content !!}
    </section>

    <!-- ad 2 -->
    @if($ads['single_page_ad_2'] != null)
    <section class="w-full px-4 flex justify-center items-center mb-5 bg-base-200/40 card transition duration-300 ease-in-out items-center text-center">
        
            <div class="max-w-full text-center max-h-[90px]">
                {!! $ads['single_page_ad_2'] !!}
            </div>
        
    </section>
    @endif

    @if(!empty($software->screenshots) && is_array($software->screenshots) && count($software->screenshots))
        <!-- Screenshots -->
        <section class="overflow-x-auto space-x-4 flex mb-5" aria-label="Software Screenshots">
            @foreach($software->screenshots as $index => $screenshot)
            <a href="{{ asset('storage/' . $screenshot) }}" target="_blank" class="rounded-2xl flex-shrink-0 w-auto h-[200px] z-10">
                <img
                    src="{{ asset('storage/' . $screenshot) }}"
                    class="card flex-shrink-0 w-auto h-[200px]"
                    alt="{{ $software->name }} Screenshot {{ $index + 1 }}"
                    loading="lazy"
                    width="300"
                />
            </a>
            @endforeach
        </section>
    @endif

    <!-- Related Apps -->
    @if (!empty($related) && count($related) > 0)
        <section id="related" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-5">
            <h2 class="text-xl font-bold mb-5 text-base-content">{{ $trns->related ?? 'Related Apps' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($related as $app)
                    <a href="{{ $app['url'] }}" title="{{ $app['name'] }} - {{ $app['tagline'] }}" aria-label="Download {{ $app['name'] }}">
                        <div class="card flex-row items-center p-4 bg-base-100 border border-base-300 hover:bg-base-200/40 transition duration-300 ease-in-out">
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



<dialog id="license_modal" class="modal">
  <div class="modal-box bg-base-200">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h2 class="text-lg font-bold text-base-content">{{ $software->license->licenseTranslations->first()?->name }}</h2>
    <p class="py-4 text-base-content">{{ $software->license->licenseTranslations->first()?->description }}</p>
  </div>
</dialog>
@if($software->softwareTranslations->first()?->change_log != null)
<dialog id="version_modal" class="modal">
  <div class="modal-box bg-base-200">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <section class="py-4 text-base-content content-wysiwyg">{!! $software->softwareTranslations->first()?->change_log !!}</section>
  </div>
</dialog>
@endif

@endsection

@section('scripts')
@livewireScripts
@endsection

