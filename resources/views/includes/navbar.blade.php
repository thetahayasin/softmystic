    <!-- Navbar -->
    <div class="navbar bg-secondary/20 p-2 relative items-stretch">
        <!-- Left: Pages Dropdown -->
        <div id="pages-dropdown" class="dropdown-bottom z-30 flex items-center">
            <label id="pages-toggle" tabindex="0" class="btn btn-ghost text-xl rounded-full">
                OS
            </label>
            <ul id="pages-menu" tabindex="0" class="menu dropdown-content p-2 shadow bg-secondary text-white text-md font-bold rounded-box w-52 mt-2 hidden rounded-lg absolute">
                <li class="flex items-center space-x-2">
                    <button class="flex items-center space-x-2 w-full p-2 text-left bg-transparent rounded-lg focus:outline-none">
                        <i class="fab fa-windows w-6 h-6"></i>
                        <span>Windows</span>
                    </button>
                </li>
                <li class="flex items-center space-x-2">
                    <button class="flex items-center space-x-2 w-full p-2 text-left bg-transparent rounded-lg focus:outline-none">
                        <i class="fab fa-android w-6 h-6"></i>
                        <span>Android</span>
                    </button>
                </li>
                <li class="flex items-center space-x-2">
                    <button class="flex items-center space-x-2 w-full p-2 text-left bg-transparent rounded-lg focus:outline-none">
                        <i class="fab fa-apple w-6 h-6"></i>
                        <span>Mac</span>
                    </button>
                </li>
            </ul>
        </div>
    
        <!-- Center: Logo -->
        <div class="flex-1 text-center h-full flex items-center justify-center">
            <a href="#" class="block h-full">
                <div class="h-full px-4 py-2 rounded-lg flex items-center">
                    <img src="https://stc.utdstc.com/img/svgs/logo-uptodown.svg" alt="Logo" class="h-10" />
                </div>
            </a>
        </div>
    
        <!-- Right: Locale and Search -->
        <div class="flex items-center space-x-4">
            <div id="locale-dropdown" class="dropdown z-30 relative">
                <label id="locale-toggle" tabindex="0" class="btn btn-ghost rounded-full">
                    <i class="fas fa-globe text-xl"></i>
                </label>
                <ul id="locale-menu" tabindex="0" class="menu dropdown-content p-2 shadow bg-secondary text-white text-md font-bold rounded-box w-52 mt-2 absolute left-0 -ml-20 hidden">
                    <li><a href="#" class="rounded-lg">English</a></li>
                    <li><a href="#" class="rounded-lg">Spanish</a></li>
                    <li><a href="#" class="rounded-lg">French</a></li>
                </ul>
            </div>
            <!-- Search -->
            <div class="group relative">
                <button id="search-btn" class="btn btn-ghost rounded-full">
                    <i id="search-icon" class="fas fa-search text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    

    <!-- Search Bar (Overlay, Initially Hidden) -->
    <div id="search-bar" class="navbar bg-secondary p-2 fixed top-0 left-0 right-0 z-40 hidden container mx-auto max-w-[1080px]">
        <div class="w-full flex items-center bg-secondary rounded-md py-1">
            <input id="search-input" type="text" class="input text-xl bg-secondary outline-none border-none focus:outline-none w-full  placeholder:text-white/50 text-white" placeholder="Search...">
            <button id="close-btn" class="btn btn-ghost ml-2 rounded-full">
                <i id="close-icon" class="fas fa-times w-6 h-6"></i>
            </button>
        </div>
    </div>

    <!-- Category Text Ribbon (Carousel) -->
    <div class="relative w-full overflow-hidden mb-10 group">
        <!-- Carousel Buttons -->
        <button class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-primary/10 z-10  hidden rounded-bl-2xl carousel-prev btn-square w-7 btn-ghost">
            <span class="font-semibold text-xl">❮</span>
        </button>
        <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-primary/10 z-10  hidden rounded-br-2xl carousel-next btn-square w-7 btn-ghost">
            <span class="font-semibold text-xl">❯</span>
        </button>

        <!-- Category Ribbon -->
        <div class="w-full overflow-x-auto whitespace-nowrap p-2 bg-primary/20 rounded-b-lg scrollbar-hide category-scroll">
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Laptops</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Mobiles</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Accessories</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">TVs</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Cameras</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Gaming</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Watches</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Tablets</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:ttext-accent transition">Appliances</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Laptops</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:ttext-accent transition">Mobiles</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Accessories</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">TVs</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Cameras</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Gaming</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Watches</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Tablets</a>
            <a href="#" class="inline-block text-md font-semibold mx-4 hover:text-accent transition">Appliances</a>
        </div>
    </div>

