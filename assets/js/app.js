// DOM Ready
document.addEventListener("DOMContentLoaded", function() {
    // setMainMinHeight();
    initDrawer();
    initVideoPopup();
    hoverActive('.cs-projects-grid[data-layout="2"][data-layout_style="2"] .project');
    hoverActive('.cs-price-carousel .price__inner');
});

const setMainMinHeight = () => {
    const header = document.querySelector("#headerDesktop:not(.header-transparent)");
    const footer = document.querySelector("#footer");
    const hero = document.querySelector("#hero");
    const main = document.querySelector("#main");

    if (!main) return;

    const minHeight =
        window.innerHeight -
        getHeight(header) -
        getHeight(footer) -
        getHeight(hero);

    if (minHeight > 0) {
        main.style.minHeight = `${minHeight}px`;
    } else {
        main.style.removeProperty("min-height");
    }
};
