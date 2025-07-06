<!-- Fixed Glass Navbar -->
<div class="fixed top-0 left-0 right-0 z-30 flex justify-center backdrop-blur-md bg-white/10 border-b border-base-200">
    <nav class="navbar p-2 relative items-stretch w-full max-w-[1080px] text-base-content" role="navigation" aria-label="Main Navigation">

        <!-- Left: Pages Dropdown -->
        <div id="pages-dropdown" class="dropdown z-30 items-center relative">
            <button id="pages-toggle" tabindex="0" class="btn btn-ghost text-lg rounded-full" aria-haspopup="true" aria-label="Change Platform" aria-expanded="false" aria-controls="platforms-menu">
                OS
            </button>
            <ul id="pages-menu" class="menu dropdown-content p-2 flex flex-col bg-base-100 border border-base-200 text-sm font-bold w-52 mt-2 hidden absolute z-40 text-base-content" role="menu" aria-label="Platform List">
                @foreach ($platforms as $platform)

                    <li role="none">
                        <a href="{{ route('home', ['param1' => $locale_slug, 'param2' => $platform['slug'] != $default_platform_slug ? $platform['slug'] : null]) }}"
                           class="flex items-center space-x-2 w-full p-2 hover:bg-base-200/60" role="menuitem" title="{{ $platform['name'] }}">
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
                    <svg class="w-6 h-6 text-base-content" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" 
                                  stroke="currentColor" stroke-width="2"/>
                            <path d="M3.5 11H6C7.10457 11 8 11.8954 8 13C8 14.1046 8.89543 15 10 15C11.1046 15 12 15.8954 12 17V20.5" 
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 4V5C8 6.10457 8.89543 7 10 7H10.1459C11.1699 7 12 7.83011 12 8.8541C12 9.55638 12.3968 10.1984 13.0249 10.5125L13.1056 10.5528C13.6686 10.8343 14.3314 10.8343 14.8944 10.5528L14.9751 10.5125C15.6032 10.1984 16 9.55638 16 8.8541C16 7.83011 16.8301 7 17.8541 7H19.5" 
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 19.5V17C16 15.8954 16.8954 15 18 15H20" 
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </button>

                <ul id="locale-menu" class="menu dropdown-content p-2 flex border border-base-200 flex-col bg-base-100 text-sm font-bold w-52 mt-2 hidden absolute left-0 -ml-20 z-40 text-base-content" role="menu" aria-label="Language Selection">
                    @if (Route::currentRouteName() == 'single.index' || Route::currentRouteName() == 'result.index' || Route::currentRouteName() == 'category.index' || Route::currentRouteName() == 'downloading.index' || Route::currentRouteName() == 'page.index')
                        @foreach ($locales as $locale)
                            <li role="none">
                                <a href="{{ $localeSwitchUrls[$locale->key] ?? '#' }}"
                                   class="block px-3 py-2 hover:bg-base-200/60"
                                   role="menuitem" title="{{ $locale->name }}">{{ $locale->name }}</a>
                            </li>
                        @endforeach
                    @else
                        @foreach ($locales as $locale)
                            <li role="none">
                                <a href="{{ route('home', ['param1' => $locale['slug'] != $default_locale_slug ? $locale['slug'] : null, 'param2' => $platform_slug ?? null]) }}"
                                   class="block px-3 py-2 hover:bg-base-200/60"
                                   role="menuitem" title="{{ $locale['name'] }}">{{ $locale['name'] }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <!-- Search Icon -->
            <div class="group relative">
                <button id="search-btn" class="btn btn-ghost rounded-full" aria-label="Open Search">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 text-base-content transition" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 6C13.7614 6 16 8.23858 16 11M16.6588 16.6549L21 21M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" 
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
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
                <svg class="w-6 h-6 text-base-content transition" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="currentColor"></path>
                </svg>            
            </button>


        </div>
    </div>
</section>


<!-- Category Text Ribbon (Contrasting Glass Style) -->
<section class="relative w-full overflow-hidden group" aria-label="Category Navigation">
    <!-- Carousel Buttons -->
    <button class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 z-10 hidden rounded-bl-2xl carousel-prev btn-square w-7 btn-ghost text-primary-content" aria-label="Previous Categories">
        <span class="font-semibold text-xl">❮</span>
    </button>
    <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 z-10 hidden rounded-br-2xl carousel-next btn-square w-7 btn-ghost text-primary-content" aria-label="Next Categories">
        <span class="font-semibold text-xl">❯</span>
    </button>

    <!-- Scrollable Category List with Contrast -->
    <div class="w-full overflow-x-auto whitespace-nowrap p-1 bg-primary backdrop-blur-md rounded-b-lg text-base-content scrollbar-hide category-scroll">
        @foreach ($categories as $cat)
            <a href="{{ $cat['url'] }}" class="inline-block text-primary-content/70 font-semibold mx-3 hover:text-primary-content transition" title="{{ $cat['name'] }}">
                {{ $cat['name'] }}
            </a>
        @endforeach
    </div>
</section>
