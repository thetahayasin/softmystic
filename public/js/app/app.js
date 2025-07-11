const searchBtn = document.getElementById("search-btn"),
      searchBar = document.getElementById("search-bar"),
      searchIcon = document.getElementById("search-icon"),
      closeBtn = document.getElementById("close-btn"),
      closeIcon = document.getElementById("close-icon"),
      navbar = document.getElementById("navbar");

searchBtn.addEventListener("click", () => {
  if (searchBar.classList.contains("hidden")) {
    searchBar.classList.remove("hidden");
    searchBar.classList.add("flex");
    navbar.classList.add("hidden");
    searchIcon.classList.remove("fa-search");
    searchIcon.classList.add("fa-times");
  }
});

closeBtn.addEventListener("click", () => {
  searchBar.classList.add("hidden");
  searchBar.classList.remove("flex");
  navbar.classList.remove("hidden");
  searchIcon.classList.remove("fa-times");
  searchIcon.classList.add("fa-search");
});

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
        carousel.scrollBy({
            left: direction * 300,
            behavior: "smooth"
        });

        // Defer the update to allow smooth scrolling to complete
        setTimeout(() => {
            requestAnimationFrame(updateButtons);
        }, 350);
    };

    prevButton.addEventListener("click", () => scrollCarousel(-1));
    nextButton.addEventListener("click", () => scrollCarousel(1));
    carousel.addEventListener("scroll", updateButtons);

    updateButtons();

    // Optional: hide buttons on touch
    if ("ontouchstart" in window || navigator.maxTouchPoints) {
        prevButton.classList.add("hidden");
        nextButton.classList.add("hidden");
    }
}


// Locale toggle
const localeToggle = document.getElementById("locale-toggle"),
      localeMenu = document.getElementById("locale-menu");

localeToggle.addEventListener("click", () => {
  localeMenu.classList.toggle("hidden");
});

// Pages dropdown toggle
const pagesToggle = document.getElementById("pages-dropdown"),
      pagesMenu = document.getElementById("pages-menu");

pagesToggle.addEventListener("click", () => {
  pagesMenu.classList.toggle("hidden");
});

// App Carousel (e.g., featured apps)
const carousel_app = document.getElementById("carousel-app"),
      leftBtn = document.getElementById("left-btn"),
      rightBtn = document.getElementById("right-btn");

// Only run carousel logic if all elements exist
if (carousel_app && leftBtn && rightBtn) {

    function scrollCarousel_app(direction) {
        carousel_app.scrollBy({
            left: direction * 400,
            behavior: "smooth"
        });

        setTimeout(() => {
            requestAnimationFrame(checkScrollPosition);
        }, 350); // wait for smooth scroll to apply
    }

    function checkScrollPosition() {
        const buffer = 2;
        const scrollLeft = Math.round(carousel_app.scrollLeft);
        const clientWidth = carousel_app.clientWidth;
        const scrollWidth = carousel_app.scrollWidth;

        leftBtn.classList.toggle("hidden", scrollLeft <= buffer);
        rightBtn.classList.toggle("hidden", scrollLeft + clientWidth >= scrollWidth - buffer);
    }

    checkScrollPosition(); // initial state
    carousel_app.addEventListener("scroll", checkScrollPosition);

    leftBtn.addEventListener("click", e => {
        e.preventDefault();
        scrollCarousel_app(-1);
    });

    rightBtn.addEventListener("click", e => {
        e.preventDefault();
        scrollCarousel_app(1);
    });
}
