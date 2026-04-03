import { debounce, raf } from "../core/utils.js";

let resizeTimer = null;

const getHeight = (element) => {
    return element ? element.offsetHeight : 0;
};

export const setMainMinHeight = () => {
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