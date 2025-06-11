<!-- Glass Style Footer Wrapper -->
<div class="flex justify-center backdrop-blur-md border-t border-base-200 text-base-content">

    <footer class="footer text-md font-bold items-center p-7 w-full max-w-[1080px]" role="contentinfo" aria-label="Website Footer">
        <!-- Left Side: Footer Text -->
        <aside class="grid-flow-col items-center text-base-content">
            <p>{{ $footer }}</p>
        </aside>

        <!-- Right Side: Navigation Links -->
        <nav class="grid-flow-col gap-4 md:place-self-center md:justify-self-end text-base-content" aria-label="Footer Navigation">
            <a href="{{ url('/') }}" title="Go to Home Page" class="transition hover:text-base-content/70">
                Home
            </a>
            <a href="{{ url('/about') }}" title="Learn more About Us" class="transition hover:text-base-content/70">
                About
            </a>
            <a href="{{ url('/privacy') }}" title="Read our Privacy Policy" class="transition hover:text-base-content/70">
                Privacy
            </a>
        </nav>
    </footer>

</div>
