<!-- Glass Style Footer Wrapper -->
<div class="flex justify-center backdrop-blur-md border-t border-base-200 text-base-content mt-0 pt-0">
    <footer class="footer flex flex-col md:flex-row justify-between items-center w-full max-w-[1080px] px-4 py-6 text-md font-bold text-base-content" role="contentinfo" aria-label="Website Footer">
        
        <!-- Left Side: Footer Text -->
        <aside class="mb-0 md:mb-0 md:mr-4 text-center md:text-left">
            <p class="m-0">{{ $footer }}</p>
        </aside>

        <!-- Right Side: Navigation Links -->
        <nav class="flex gap-4 justify-center md:justify-end text-center">
            @foreach ($pages as $page)
            
                <a href="{{ url('/') }}" title="Go to Home Page" class="transition hover:text-base-content/70">
                    {{ $page->translations->first()?->title }}
                </a>
                
            @endforeach

        </nav>

    </footer>
</div>
