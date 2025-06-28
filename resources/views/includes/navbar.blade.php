<!-- Fixed Glass Navbar -->
<div class="fixed top-0 left-0 right-0 z-30 flex justify-center backdrop-blur-md bg-white/10 border-b border-base-200">
    <nav class="navbar p-2 relative items-stretch w-full max-w-[1080px] text-base-content" role="navigation" aria-label="Main Navigation">

        <!-- Left: Pages Dropdown -->
        <div id="pages-dropdown" class="dropdown z-30 items-center relative">
            <button id="pages-toggle" tabindex="0" class="btn btn-ghost text-xl rounded-full" aria-haspopup="true" aria-label="Change Platform" aria-expanded="false" aria-controls="platforms-menu">
                OS
            </button>
            <ul id="pages-menu" class="menu dropdown-content p-2 flex flex-col bg-base-100 border border-base-200 text-sm font-bold rounded-lg w-52 mt-2 hidden absolute z-40 text-base-content" role="menu" aria-label="Platform List">
                @foreach ($platforms as $platform)

                    <li role="none">
                        <a href="{{ route('home', ['param1' => $locale_slug, 'param2' => $platform['slug'] != $default_platform_slug ? $platform['slug'] : null]) }}"
                           class="flex items-center space-x-2 w-full p-2 rounded-lg hover:bg-base-200" role="menuitem" title="{{ $platform['name'] }}">
                            {{ $platform['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Center: Logo -->
        <div class="flex-1 text-center h-full flex items-center justify-center">
            <a href="{{ route('home', ['param1' => $locale_slug, 'param2' => $platform_slug ?? null]) }}" class="block h-full" aria-label="Home">
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
                <ul id="locale-menu" class="menu dropdown-content p-2 flex border border-base-200 flex-col bg-base-100 text-sm font-bold rounded-lg w-52 mt-2 hidden absolute left-0 -ml-20 z-40 text-base-content" role="menu" aria-label="Language Selection">
                    @if (Route::currentRouteName() == 'single.index' || Route::currentRouteName() == 'result.index' || Route::currentRouteName() == 'category.index' || Route::currentRouteName() == 'downloading.index' || Route::currentRouteName() == 'page.index')
                        @foreach ($locales as $locale)
                            <li role="none">
                                <a href="{{ $localeSwitchUrls[$locale->key] ?? '#' }}"
                                   class="rounded-lg block px-3 py-2 hover:bg-base-200"
                                   role="menuitem" title="{{ $locale->name }}">{{ $locale->name }}</a>
                            </li>
                        @endforeach
                    @else
                        @foreach ($locales as $locale)
                            <li role="none">
                                <a href="{{ route('home', ['param1' => $locale['slug'] != $default_locale_slug ? $locale['slug'] : null, 'param2' => $platform_slug ?? null]) }}"
                                   class="rounded-lg block px-3 py-2 hover:bg-base-200"
                                   role="menuitem" title="{{ $locale['name'] }}">{{ $locale['name'] }}</a>
                            </li>
                        @endforeach
                    @endif
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
</div>

<!-- Spacer Below Fixed Navbar -->
<div class="h-[64px]"></div>

<!-- Search Bar (Styled to Match Navbar) -->
<section id="search-bar" class="fixed top-0 left-0 right-0 z-40 hidden flex justify-center">
    <div class="navbar h-10 p-2 w-full max-w-[1080px] backdrop-blur-md bg-white/10  text-base-content" role="search">
        <div class="w-full flex items-center rounded-md py-1">
            <label for="search-input" class="sr-only">Search</label>
            <form class="w-full" id="search-form" >
                <input id="search-input" type="text"
                    class="input text-xl bg-transparent outline-none border-none w-full placeholder:text-base-content/70 text-base-content"
                    placeholder="Search..." aria-label="Search" >
            </form>
            <button id="close-btn" class="btn btn-ghost ml-2 rounded-full" aria-label="Close Search">
                <i id="close-icon" class="fas fa-times w-6 h-6"></i>
            </button>

        </div>
    </div>
</section>


<!-- Category Text Ribbon (Contrasting Glass Style) -->
<section class="relative w-full overflow-hidden group" aria-label="Category Navigation">
    <!-- Carousel Buttons -->
    <button class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 z-10 hidden rounded-bl-2xl carousel-prev btn-square w-7 btn-ghost text-base-content" aria-label="Previous Categories">
        <span class="font-semibold text-xl">❮</span>
    </button>
    <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 z-10 hidden rounded-br-2xl carousel-next btn-square w-7 btn-ghost text-base-content" aria-label="Next Categories">
        <span class="font-semibold text-xl">❯</span>
    </button>

    <!-- Scrollable Category List with Contrast -->
    <div class="w-full overflow-x-auto whitespace-nowrap p-1 bg-neutral backdrop-blur-md rounded-b-lg text-base-content scrollbar-hide category-scroll" role="list">
        @foreach ($categories as $cat)
            <a href="{{ $cat['url'] }}" class="inline-block text-neutral-content font-semibold mx-4 hover:text-neutral-content/70 transition" role="listitem" title="{{ $cat['name'] }}">
                {{ $cat['name'] }}
            </a>
        @endforeach
    </div>
</section>
