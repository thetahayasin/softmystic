const searchBtn = document.getElementById("search-btn"),
    searchBar = document.getElementById("search-bar"),
    searchIcon = document.getElementById("search-icon"),
    closeBtn = document.getElementById("close-btn"),
    navbar = document.getElementById("navbar");
searchBtn.addEventListener("click", () => {
    searchBar.classList.contains("hidden") && (searchBar.classList.remove("hidden"), searchBar.classList.add("flex"), navbar.classList.add("hidden"), searchIcon.classList.replace("fa-search", "fa-times"));
}),
    closeBtn.addEventListener("click", () => {
        searchBar.classList.add("hidden"), searchBar.classList.remove("flex"), navbar.classList.remove("hidden"), searchIcon.classList.replace("fa-times", "fa-search");
    });
const carousel = document.querySelector(".category-scroll"),
    prevButton = document.querySelector(".carousel-prev"),
    nextButton = document.querySelector(".carousel-next");
if (carousel && prevButton && nextButton) {
    const e = 2,
        t = () => {
            const t = Math.round(carousel.scrollLeft),
                s = carousel.scrollWidth - carousel.clientWidth;
            prevButton.classList.toggle("hidden", t <= e), nextButton.classList.toggle("hidden", t >= s - e);
        },
        s = (e) => {
            carousel.scrollBy({ left: 300 * e, behavior: "smooth" }), setTimeout(t, 1);
        };
    let n;
    prevButton.addEventListener("click", () => s(-1)),
        nextButton.addEventListener("click", () => s(1)),
        carousel.addEventListener("scroll", () => {
            clearTimeout(n), (n = setTimeout(t, 1));
        }),
        t(),
        ("ontouchstart" in window || navigator.maxTouchPoints > 0) && (prevButton.classList.add("hidden"), nextButton.classList.add("hidden"));
}
const localeToggle = document.getElementById("locale-toggle"),
    localeMenu = document.getElementById("locale-menu");
localeToggle?.addEventListener("click", () => {
    localeMenu?.classList.toggle("hidden");
});
const pagesToggle = document.getElementById("pages-dropdown"),
    pagesMenu = document.getElementById("pages-menu");
pagesToggle?.addEventListener("click", () => {
    pagesMenu?.classList.toggle("hidden");
});
const carousel_app = document.getElementById("carousel-app"),
    leftBtn = document.getElementById("left-btn"),
    rightBtn = document.getElementById("right-btn");
if (carousel_app && leftBtn && rightBtn) {
    const e = 2,
        t = () => {
            const t = Math.round(carousel_app.scrollLeft),
                s = carousel_app.clientWidth,
                n = carousel_app.scrollWidth;
            leftBtn.classList.toggle("hidden", t <= e), rightBtn.classList.toggle("hidden", t + s >= n - e);
        },
        s = (e) => {
            carousel_app.scrollBy({ left: 800 * e, behavior: "smooth" }), setTimeout(t, 1);
        };
    let n;
    carousel_app.addEventListener("scroll", () => {
        clearTimeout(n), (n = setTimeout(t, 1));
    }),
        leftBtn.addEventListener("click", (e) => {
            e.preventDefault(), s(-1);
        }),
        rightBtn.addEventListener("click", (e) => {
            e.preventDefault(), s(1);
        }),
        t();
}
