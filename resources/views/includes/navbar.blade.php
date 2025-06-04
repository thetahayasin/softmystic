<!-- Navbar -->
<nav class="navbar bg-secondary/20 p-2 relative items-stretch" role="navigation" aria-label="Main Navigation">

    <!-- Left: Pages Dropdown -->
    <div id="pages-dropdown" class="dropdown z-30 items-center relative">
        <button id="pages-toggle" tabindex="0" class="btn btn-ghost text-xl rounded-full" aria-haspopup="true" aria-label="Change Platform" aria-expanded="false" aria-controls="platforms-menu">
            OS
        </button>
        <ul id="pages-menu" class="menu dropdown-content p-2 shadow bg-secondary text-white text-md font-bold rounded-box w-52 mt-2 hidden rounded-lg absolute z-40" role="menu" aria-label="Platform List">
            @foreach ($platforms as $platform)
                <li role="none">
                    <a href="{{ route('home', ['param1' => $locale_slug,'param2' => $platform['slug'] != $default_platform_slug ? $platform['slug'] : null]) }}" class="flex items-center space-x-2 w-full p-2 bg-transparent rounded-lg focus:outline-none" role="menuitem" title="{{ $platform['name'] }}">
                        {{ $platform['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    
    <!-- Center: Logo -->
    <div class="flex-1 text-center h-full flex items-center justify-center">
        <a href="{{ url('/') }}" class="block h-full" aria-label="Home">
            <div class="h-full px-4 py-2 rounded-lg flex items-center">
                @if ($ads->site_logo)
                    <img loading="lazy" src="{{ asset('storage/' . $ads->site_logo) }}" alt="Website Logo" class="max-h-8 w-full" />
                @else
                    <span class="text-xl font-bold">{{ $ads->site_name }}</span>
                @endif
            </div>
        </a>
    </div>

    <!-- Right: Locale and Search -->
    <div class="flex items-center space-x-4">

        <!-- Locale Dropdown -->
        <div id="locale-dropdown" class="dropdown z-30 relative">
            <button id="locale-toggle" tabindex="0" class="btn btn-ghost rounded-full" aria-haspopup="true" aria-expanded="false" aria-controls="locale-menu" aria-label="Change Language">
                <i class="fas fa-globe text-xl"></i>
            </button>
            <ul id="locale-menu" class="menu dropdown-content p-2 shadow bg-secondary text-white text-md font-bold rounded-box w-52 mt-2 hidden absolute left-0 -ml-20 z-40" role="menu" aria-label="Language Selection">
                @foreach ($locales as $locale)
                    <li role="none">
                        <a href="{{  route('home', ['param1' => $locale['slug'] != $default_locale_slug ? $locale['slug'] : null, 'param2' => $platform_slug]) }}" class="rounded-lg block" role="menuitem" title="{{ $locale['name'] }}">{{ $locale['name'] }}</a>
                    </li>
                @endforeach 
            </ul>
        </div>

        <!-- Search Icon -->
        <div class="group relative">
            <button id="search-btn" class="btn btn-ghost rounded-full" aria-label="Open Search">
                <i id="search-icon" class="fas fa-search text-xl"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Search Bar (Overlay, Initially Hidden) -->
<section id="search-bar" class="navbar bg-secondary p-2 fixed top-0 left-0 right-0 z-40 hidden container mx-auto max-w-[1080px]" role="search">
    <div class="w-full flex items-center bg-secondary rounded-md py-1">
        <label for="search-input" class="sr-only">Search</label>
        <input id="search-input" type="text" class="input text-xl bg-secondary outline-none border-none focus:outline-none w-full placeholder:text-white/50 text-white" placeholder="Search..." aria-label="Search">
        <button id="close-btn" class="btn btn-ghost ml-2 rounded-full" aria-label="Close Search">
            <i id="close-icon" class="fas fa-times w-6 h-6"></i>
        </button>
    </div>
</section>

<!-- Category Text Ribbon -->
<section class="relative w-full overflow-hidden group" aria-label="Category Navigation">

    <!-- Carousel Buttons -->
    <button class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-primary/10 z-10 hidden rounded-bl-2xl carousel-prev btn-square w-7 btn-ghost" aria-label="Previous Categories">
        <span class="font-semibold text-xl">❮</span>
    </button>
    <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-primary/10 z-10 hidden rounded-br-2xl carousel-next btn-square w-7 btn-ghost" aria-label="Next Categories">
        <span class="font-semibold text-xl">❯</span>
    </button>

    <!-- Category Scroll List -->
    <div class="w-full overflow-x-auto whitespace-nowrap p-2 bg-primary/20 rounded-b-lg scrollbar-hide category-scroll" role="list">
        @foreach ($categories as $cat)
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition" role="listitem" title="{{ $cat['name'] }}">
                {{ $cat['name'] }}
            </a>
        @endforeach
    </div>
</section>
