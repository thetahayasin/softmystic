<footer class="footer bg-secondary/20 text-md font-bold items-center p-7 rounded-t-lg" role="contentinfo" aria-label="Website Footer">
    <aside class="grid-flow-col items-center">
        <p>{{ $footer }}</p>
    </aside>

    <nav class="grid-flow-col gap-4 md:place-self-center md:justify-self-end" aria-label="Footer Navigation">
        <a href="{{ url('/') }}" title="Go to Home Page" class="hover:text-accent transition">
            Home
        </a>
        <a href="{{ url('/about') }}" title="Learn more About Us" class="hover:text-accent transition">
            About
        </a>
        <a href="{{ url('/privacy') }}" title="Read our Privacy Policy" class="hover:text-accent transition">
            Privacy
        </a>
    </nav>
</footer>
