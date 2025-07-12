// 🔍 Search Bar Toggle
const searchBtn = document.getElementById("search-btn"),
    searchBar = document.getElementById("search-bar"),
    searchIcon = document.getElementById("search-icon"),
    closeBtn = document.getElementById("close-btn"),
    navbar = document.getElementById("navbar");

searchBtn.addEventListener("click", () => {
    if (searchBar.classList.contains("hidden")) {
        searchBar.classList.remove("hidden");
        searchBar.classList.add("flex");
        navbar.classList.add("hidden");
        searchIcon.classList.replace("fa-search", "fa-times");
    }
});

closeBtn.addEventListener("click", () => {
    searchBar.classList.add("hidden");
    searchBar.classList.remove("flex");
    navbar.classList.remove("hidden");
    searchIcon.classList.replace("fa-times", "fa-search");
});

// 🖼️ Category Carousel
const carousel = document.querySelector(".category-scroll"),
    prevButton = document.querySelector(".carousel-prev"),
    nextButton = document.querySelector(".carousel-next");

if (carousel && prevButton && nextButton) {
    const buffer = 2;

    const updateButtons = () => {
        const scrollLeft = Math.round(carousel.scrollLeft);
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;
        prevButton.classList.toggle("hidden", scrollLeft <= buffer);
        nextButton.classList.toggle("hidden", scrollLeft >= maxScroll - buffer);
    };

    const scrollCarousel = (direction) => {
        carousel.scrollBy({ left: direction * 300, behavior: "smooth" });
        setTimeout(updateButtons, 350);
    };

    prevButton.addEventListener("click", () => scrollCarousel(-1));
    nextButton.addEventListener("click", () => scrollCarousel(1));

    // Throttle scroll event
    let scrollTimeout;
    carousel.addEventListener("scroll", () => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(updateButtons, 100);
    });

    updateButtons();

    // Hide buttons on mobile/touch
    if ("ontouchstart" in window || navigator.maxTouchPoints > 0) {
        prevButton.classList.add("hidden");
        nextButton.classList.add("hidden");
    }
}

// 🌐 Locale Dropdown
const localeToggle = document.getElementById("locale-toggle"),
    localeMenu = document.getElementById("locale-menu");

localeToggle?.addEventListener("click", () => {
    localeMenu?.classList.toggle("hidden");
});

// 📄 Pages Dropdown
const pagesToggle = document.getElementById("pages-dropdown"),
    pagesMenu = document.getElementById("pages-menu");

pagesToggle?.addEventListener("click", () => {
    pagesMenu?.classList.toggle("hidden");
});

// 🎮 App Carousel
const carousel_app = document.getElementById("carousel-app"),
    leftBtn = document.getElementById("left-btn"),
    rightBtn = document.getElementById("right-btn");

if (carousel_app && leftBtn && rightBtn) {
    const buffer = 2;

    const checkScrollPosition = () => {
        const scrollLeft = Math.round(carousel_app.scrollLeft);
        const clientWidth = carousel_app.clientWidth;
        const scrollWidth = carousel_app.scrollWidth;
        leftBtn.classList.toggle("hidden", scrollLeft <= buffer);
        rightBtn.classList.toggle("hidden", scrollLeft + clientWidth >= scrollWidth - buffer);
    };

    const scrollCarouselApp = (direction) => {
        carousel_app.scrollBy({ left: direction * 800, behavior: "smooth" });
        setTimeout(checkScrollPosition, 350);
    };

    // Throttle scroll event
    let appScrollTimeout;
    carousel_app.addEventListener("scroll", () => {
        clearTimeout(appScrollTimeout);
        appScrollTimeout = setTimeout(checkScrollPosition, 100);
    });

    leftBtn.addEventListener("click", (e) => {
        e.preventDefault();
        scrollCarouselApp(-1);
    });

    rightBtn.addEventListener("click", (e) => {
        e.preventDefault();
        scrollCarouselApp(1);
    });

    checkScrollPosition();
}
