// Handle search bar toggle, navbar visibility and icon change
const searchBtn = document.getElementById('search-btn');
const searchBar = document.getElementById('search-bar');
const searchIcon = document.getElementById('search-icon');
const closeBtn = document.getElementById('close-btn');
const closeIcon = document.getElementById('close-icon');
const navbar = document.getElementById('navbar');

// Toggle search bar visibility, navbar hiding, and change search icon to cross
searchBtn.addEventListener('click', () => {
    if (searchBar.classList.contains('hidden')) {
        searchBar.classList.remove('hidden');
        searchBar.classList.add('flex');
        navbar.classList.add('hidden'); // Hide navbar when search is open
        // Change search icon to cross
        searchIcon.classList.remove('fa-search');
        searchIcon.classList.add('fa-times');
    }
});

// Close the search bar, show navbar and revert the icon to search
closeBtn.addEventListener('click', () => {
    searchBar.classList.add('hidden');
    searchBar.classList.remove('flex');
    navbar.classList.remove('hidden'); // Show navbar when search is closed
    // Revert cross icon to search
    searchIcon.classList.remove('fa-times');
    searchIcon.classList.add('fa-search');
});



const carousel = document.querySelector('.category-scroll');
const prevButton = document.querySelector('.carousel-prev');
const nextButton = document.querySelector('.carousel-next');

const updateButtons = () => {
    const scrollLeft = carousel.scrollLeft;
    const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;

    // Show buttons only when the user scrolls
    if (scrollLeft > 0) {
        prevButton.classList.remove('hidden');
    } else {
        prevButton.classList.add('hidden');
    }

    if (scrollLeft < maxScrollLeft) {
        nextButton.classList.remove('hidden');
    } else {
        nextButton.classList.add('hidden');
    }
};

const scrollCarousel = (direction) => {
    const scrollAmount = 300; // Number of pixels to scroll per click
    carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    updateButtons();
};

prevButton.addEventListener('click', () => scrollCarousel(-1));
nextButton.addEventListener('click', () => scrollCarousel(1));

// Update buttons visibility on scroll
carousel.addEventListener('scroll', updateButtons);

// Initially check the button visibility
updateButtons();

// Hide carousel buttons on touch devices
if ('ontouchstart' in window || navigator.maxTouchPoints) {
    prevButton.style.display = 'none';
    nextButton.style.display = 'none';
}



    // Handle dropdown toggle for locale
    const localeToggle = document.getElementById('locale-toggle');
    const localeMenu = document.getElementById('locale-menu');

    localeToggle.addEventListener('click', () => {
        localeMenu.classList.toggle('hidden'); // Toggle the visibility of the dropdown
    });
    // Handle dropdown toggle for locale
    const pagesToggle = document.getElementById('pages-dropdown');
    const pagesMenu = document.getElementById('pages-menu');

    pagesToggle.addEventListener('click', () => {
        pagesMenu.classList.toggle('hidden'); // Toggle the visibility of the dropdown
    });

const carousel_app = document.getElementById('carousel-app');
const leftBtn = document.getElementById('left-btn');
const rightBtn = document.getElementById('right-btn');

function scrollCarousel_app(direction) {
    const scrollAmount = 400;
    carousel_app.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
    setTimeout(checkScrollPosition, 300);
}

function checkScrollPosition() {
    leftBtn.classList.toggle('hidden', carousel_app.scrollLeft <= 0);
    rightBtn.classList.toggle('hidden', carousel_app.scrollLeft + carousel_app.clientWidth >= carousel_app.scrollWidth);
}

// Initial check
checkScrollPosition();

// Listen for Scroll
carousel_app.addEventListener('scroll', checkScrollPosition);

// Prevent scroll to top on button click
leftBtn.addEventListener('click', (event) => {
    event.preventDefault();
    scrollCarousel_app(-1);
});

rightBtn.addEventListener('click', (event) => {
    event.preventDefault();
    scrollCarousel_app(1);
});




