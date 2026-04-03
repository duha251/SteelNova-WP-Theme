export const refreshScrollTrigger = () => {
    if (window.gsap && window.ScrollTrigger) {
        window.ScrollTrigger.refresh();
    }
};