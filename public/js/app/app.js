// SEARCH TOGGLE
const searchBtn = document.getElementById("search-btn");
const searchBar = document.getElementById("search-bar");
const searchIcon = document.getElementById("search-icon");
const closeBtn = document.getElementById("close-btn");
const navbar = document.getElementById("navbar");

searchBtn?.addEventListener("click", () => {
    if (searchBar?.classList.contains("hidden")) {
        searchBar.classList.remove("hidden");
        searchBar.classList.add("flex");
        navbar?.classList.add("hidden");
        searchIcon?.classList.replace("fa-search", "fa-times");
    }
});

closeBtn?.addEventListener("click", () => {
    searchBar?.classList.add("hidden");
    searchBar?.classList.remove("flex");
    navbar?.classList.remove("hidden");
    searchIcon?.classList.replace("fa-times", "fa-search");
});

// CATEGORY CAROUSEL SCROLL
const categoryCarousel = document.querySelector(".category-scroll");
const prevCategoryBtn = document.querySelector(".carousel-prev");
const nextCategoryBtn = document.querySelector(".carousel-next");

if (categoryCarousel && prevCategoryBtn && nextCategoryBtn) {
    const scrollOffset = 2;
    const scrollAmount = 300;

    const updateCategoryNavVisibility = () => {
        const scrollLeft = Math.round(categoryCarousel.scrollLeft);
        const maxScroll = categoryCarousel.scrollWidth - categoryCarousel.clientWidth;

        prevCategoryBtn.classList.toggle("hidden", scrollLeft <= scrollOffset);
        nextCategoryBtn.classList.toggle("hidden", scrollLeft >= maxScroll - scrollOffset);
    };

    const scrollCategory = (direction) => {
        categoryCarousel.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
        requestAnimationFrame(() => requestAnimationFrame(updateCategoryNavVisibility));
    };

    let categoryScrollTimeout;
    categoryCarousel.addEventListener("scroll", () => {
        clearTimeout(categoryScrollTimeout);
        categoryScrollTimeout = setTimeout(() => {
            requestAnimationFrame(updateCategoryNavVisibility);
        }, 100);
    });

    prevCategoryBtn.addEventListener("click", () => scrollCategory(-1));
    nextCategoryBtn.addEventListener("click", () => scrollCategory(1));

    updateCategoryNavVisibility();

    // Hide on touch devices
    if ("ontouchstart" in window || navigator.maxTouchPoints > 0) {
        prevCategoryBtn.classList.add("hidden");
        nextCategoryBtn.classList.add("hidden");
    }
}

// LOCALE TOGGLE
const localeToggle = document.getElementById("locale-toggle");
const localeMenu = document.getElementById("locale-menu");

localeToggle?.addEventListener("click", () => {
    localeMenu?.classList.toggle("hidden");
});

// PAGES DROPDOWN
const pagesToggle = document.getElementById("pages-dropdown");
const pagesMenu = document.getElementById("pages-menu");

pagesToggle?.addEventListener("click", () => {
    pagesMenu?.classList.toggle("hidden");
});

// APP CAROUSEL
const appCarousel = document.getElementById("carousel-app");
const leftAppBtn = document.getElementById("left-btn");
const rightAppBtn = document.getElementById("right-btn");

if (appCarousel && leftAppBtn && rightAppBtn) {
    const scrollOffset = 2;
    const scrollAmount = 800;

    const updateAppNavVisibility = () => {
        const scrollLeft = Math.round(appCarousel.scrollLeft);
        const visibleWidth = appCarousel.clientWidth;
        const totalScroll = appCarousel.scrollWidth;

        leftAppBtn.classList.toggle("hidden", scrollLeft <= scrollOffset);
        rightAppBtn.classList.toggle("hidden", scrollLeft + visibleWidth >= totalScroll - scrollOffset);
    };

    const scrollAppCarousel = (direction) => {
        appCarousel.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
        requestAnimationFrame(() => requestAnimationFrame(updateAppNavVisibility));
    };

    let appScrollTimeout;
    appCarousel.addEventListener("scroll", () => {
        clearTimeout(appScrollTimeout);
        appScrollTimeout = setTimeout(() => {
            requestAnimationFrame(updateAppNavVisibility);
        }, 100);
    });

    leftAppBtn.addEventListener("click", (e) => {
        e.preventDefault();
        scrollAppCarousel(-1);
    });

    rightAppBtn.addEventListener("click", (e) => {
        e.preventDefault();
        scrollAppCarousel(1);
    });

    updateAppNavVisibility();
}
