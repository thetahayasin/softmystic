@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <div class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <div class="hero flex flex-col px-2 items-center justify-center bg-secondary/10 border border-white/20 backdrop-blur-lg rounded-2xl p-8 md:p-16 relative overflow-hidden">
            <div class="max-w-2xl text-center sm:mb-2">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight tracking-tight bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">
                    Discover, Download, Enjoy
                </h1>
                <p class="text-lg md:text-2xl mb-8 font-medium">
                    The best apps for Windows, Mac, Android, and more. Safe, fast, and always up to date.
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
    </div>


    <!-- Featured Downloads Section -->
    <div id="featured" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 for="Featured Downloads" class="text-xl font-bold mb-5">Featured Downloads</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Featured Download Card -->
             @foreach ($featured as $app)
                <a href="">
                    <div class="card bg-secondary/10 hover:bg-primary/5 transition duration-300 ease-in-out rounded-2xl">
                        <figure class="px-3 pt-5">
                            <img src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="rounded-xl w-24 h-24 object-cover" />
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



        </div>
    </div>

    <div id="latest-updates" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 for="Latest Updates" class="text-xl font-bold mb-5">Latest Updates</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Trending Item -->
            @foreach ($updates as $app)

                <a href="">
                    <div class="flex items-center p-4 bg-base-100 rounded-2xl hover:bg-primary/5 transition duration-300 ease-in-out">
                        <img src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-12 h-12 rounded-lg mr-4">
                        <div>
                            <h3 class="font-bold line-clamp-1" title="{{ $app['name'] }}">{{ $app['name'] }}</h3>
                            <p class="text-sm opacity-70 line-clamp-1" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>

    <div id="new-releases" class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <h2 for="New Releases" class="text-xl font-bold mb-5">New Releases</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Trending Item -->
            @foreach ($newreleases as $app)

                <a href="">
                    <div class="flex items-center p-4 bg-base-100 rounded-2xl hover:bg-primary/5 transition duration-300 ease-in-out">
                        <img src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-12 h-12 rounded-lg mr-4">
                        <div>
                            <h3 class="font-bold line-clamp-1" title="{{ $app['name'] }}">{{ $app['name'] }}</h2>
                            <p class="text-sm opacity-70 line-clamp-1" title="{{ $app['tagline'] }}">{{ $app['tagline'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="w-full max-w-8xl px-2 overflow-hidden relative group mb-10">
        <!-- Carousel Container -->
        <h2 for="Popular Downloads" class="text-xl font-bold mb-5">Popular Downloads</h2>
        <div id="carousel-app" class="carousel flex space-x-4 snap-x overflow-x-scroll scrollbar-hide scroll-smooth">

            <!-- Item -->
            @foreach ($popular as $app)
            <a href="">
                <div class="carousel-item w-24 h-auto flex-shrink-0 flex flex-col items-center text-center justify-start p-4 rounded-lg hover:bg-primary/5 transition duration-300 ease-in-out">
                    <img src="{{ asset('storage/' . $app['logo']) }}" alt="{{ $app['name'] }} Logo" class="w-24 h-24 rounded-lg">
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
           class="absolute left-0 top-1/2 bg-secondary rounded-full border-none shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle
          hover:bg-secondary transition-all duration-300"
           onclick="scrollCarousel_app(-1)">
            ❮
        </button>
        <!-- Right Scroll Button -->
        <button aria-label="Next Slide" id="right-btn"
           class="absolute right-0 border-none top-1/2 bg-secondary rounded-full shadow p-2 opacity-0 group-hover:opacity-100 hidden btn btn-circle
          hover:bg-secondary transition-all duration-300"
           onclick="scrollCarousel_app(1)">
            ❯
        </button>
    </div>
@endsection