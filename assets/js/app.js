// DOM Ready
let resizeTimer;
let lastScrollTop = 0;
let windowWidth = window.innerWidth;
let windowHeight = window.innerHeight;

document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".preloader").classList.add("loading");
    setMainMinHeight();
    window.addEventListener('resize', setMainMinHeight);
    initDrawer();
    initVideoPopup();
    initSubmitButtons();
    handleSubmenu();
    toggleSubmenuMobile();
    // Animate on Scroll
    let wow = new WOW({
        boxClass:     'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset:       0,          // distance to the element when triggering the animation (default is 0)
        mobile:       true,       // trigger animations on mobile devices (default is true)
        live:         true,       // act on asynchronously loaded content (default is true)
        callback:     function(box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null // optional scroll container selector, otherwise use window
    });
    wow.init();

    
    
    // Set opacity for header and footer
    const header = document.querySelector('.header');
    const footer = document.querySelector('.footer');
    if (header) header.style.opacity = '1';
    if (footer) footer.style.opacity = '1';
    
    // Event Until
    hoverActive('.cs-projects-grid[data-layout="2"][data-layout_style="2"] .project');
    hoverActive('.cs-price-carousel .price__inner');

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.cs-button--back-to-top');

        if (!button) {
            return;
        }

        e.preventDefault();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
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

// Submit CF7 form when .cs-button[data-type="submit"] clicked
const initSubmitButtons = () => {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.cs-button[data-type="submit"]');
        if (!btn) return;

        e.preventDefault();

        const formId = btn.getAttribute('data-form-id');
        if (!formId) return;

        // Find CF7 form by hidden _wpcf7 field
        const form = document.querySelector(`.wpcf7 form input[name="_wpcf7"][value="${formId}"]`)?.closest('form');

        if (!form) return;

        const submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');

        if (submitBtn) {
            submitBtn.click();
        } else if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        }
    });
};

window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);

    resizeTimer = setTimeout(function () {
        if (typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.refresh();
        }
    }, 300);
});


window.addEventListener('scroll', function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    windowWidth = window.innerWidth;
    windowHeight = window.innerHeight;

    const blurBottomSite = document.querySelector('.blur-bottom-site');
    const backToTop = document.querySelector('.cs-button--back-to-top');
    const headerSticky = document.querySelector('#header-sticky');
     // Blur Bottom Site
    if (blurBottomSite) {
        const documentHeight = document.documentElement.scrollHeight;

        if (scrollTop + windowHeight >= documentHeight - 10) {
            blurBottomSite.style.opacity = '0';
        } else {
            blurBottomSite.style.opacity = '1';
        }
    }

    // Back to top
    if (backToTop) {
        if (scrollTop > 300) {
            backToTop.classList.add('is-show');
        } else {
            backToTop.classList.remove('is-show');
        }
    }

    // Header Sticky
    if (headerSticky) {
        if (scrollTop > 150 && windowWidth >= 1200) {
            if (scrollTop > lastScrollTop) {
                // Scroll down
                document
                    .querySelectorAll('.header-sticky[data-scroll="down"]')
                    .forEach((element) => {
                        element.classList.add('is-active');
                    });

                document
                    .querySelectorAll('.header-sticky[data-scroll="up"]')
                    .forEach((element) => {
                        element.classList.remove('is-active');
                    });
            } else {
                // Scroll up
                document
                    .querySelectorAll('.header-sticky[data-scroll="up"]')
                    .forEach((element) => {
                        element.classList.add('is-active');
                    });

                document
                    .querySelectorAll('.header-sticky[data-scroll="down"]')
                    .forEach((element) => {
                        element.classList.remove('is-active');
                    });
            }
        } else if (scrollTop < 100 && windowWidth >= 1200) {
            // Back to top page, hide all sticky headers
            document
                .querySelectorAll('.header-sticky')
                .forEach((element) => {
                    element.classList.remove('is-active');
                });
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }
})

window.addEventListener('load', function () {
    const preloader = document.querySelector('.preloader');

    if (preloader) {
        preloader.classList.add('loaded');
        preloader.classList.remove('loading');
    }
});