<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('meta_title', 'Your Site Name - Best Apps & Downloads')</title>
    <meta name="description" content="@yield('meta_description', 'Discover the best apps, featured downloads, latest updates, and new releases on Your Site Name.')" />
    <link rel="icon" href="{{ asset('storage/site_images/site_favicon.png') }}" type="image/png" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/site_images/site_favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('storage/site_images/site_favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/app/app.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('css/app/app.css') }}"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
    {!! $settings->header_code !!}
</head>
<body data-theme="{{ $settings->site_theme }}" class="bg-base-100  justify-center items-center min-h-screen">
<main class="container mx-auto max-w-[1080px] bg-base-100">


@include('includes.navbar')

<div class="px-2 lg:px-0">@yield('content')</div>


@include('includes.footer')



</main>
@yield('scripts')
<script src="{{ asset('js/app/app.js') }}" defer></script>

{!! $settings->footer_code !!}
<script>
    document.getElementById('search-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const query = document.getElementById('search-input').value.trim();
        if (!query) return;

        const parts = [];

        // From Blade: values from current context
        const locale = @json($locale_slug ?? null);
        const platform = @json($platform_slug ?? null);
        const defaultLocale = @json($default_locale_slug);
        const defaultPlatform = @json($default_platform_slug);

        // Only push if NOT default
        if (locale && locale !== defaultLocale) parts.push(locale);
        if (platform && platform !== defaultPlatform) parts.push(platform);

        parts.push(encodeURIComponent(query)); // always add query

        const finalUrl = `/search/${parts.join('/')}`;
        window.location.href = finalUrl;
    });
</script>
</body>
</html>
