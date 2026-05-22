(function ($) {
    "use strict";

    function setCenterVisibleSlide(swiper) {
        const $visibleSlides = $(swiper.slides).filter('.swiper-slide-visible');

        $(swiper.slides).removeClass('swiper-slide-center');

        if (!$visibleSlides.length) return;

        const centerIndex = Math.floor($visibleSlides.length / 2);

        $visibleSlides.eq(centerIndex).addClass('swiper-slide-center');
    }

    function initSwiperCarousel($scope) {
        const $carousels = $scope.find('.swiper');
        if (!$carousels.length) return;

        $carousels.each(function () {
            const $carousel = $(this);
            const carouselClasses = $carousel.attr('class');
            if ($carousel.hasClass('swiper-initialized')) return;

            const serverSettings = $carousel.data('swiper') || {};
            let settings = {
                slidesPerView: 1,
                spaceBetween: 0,
                wrapperClass: 'swiper-wrapper',
                slideClass: 'swiper-slide',
                watchSlidesProgress: true,
                observer: true,
                observeParents: true,
                speed: 600,
                grabCursor: true,
                
                direction: serverSettings.direction || 'horizontal',
                loop: !!serverSettings.loop,
                centeredSlides: !!serverSettings.centeredSlides,
                allowTouchMove: serverSettings.allowTouchMove !== undefined ? !!serverSettings.allowTouchMove : true,
                initialSlide: serverSettings.initialSlide || 0,
                mousewheel: !!serverSettings.mousewheel,
            };

            if( serverSettings.effect ) {
                settings.effect = serverSettings.effect;
                if( serverSettings.effect === 'fade' ) {
                    settings.fadeEffect = {
                        crossFade: true
                    };
                }
            }

            if (serverSettings.autoPlay && serverSettings.autoPlay.enable) {
                settings.autoplay = {
                    delay: serverSettings.autoPlay.delay || 3000,
                    disableOnInteraction: !!serverSettings.autoPlay.disableOnInteraction,
                    pauseOnMouseEnter: !!serverSettings.autoPlay.pauseOnMouseEnter,
                    reverseDirection: !!serverSettings.autoPlay.reverseDirection,
                };
            }

            if (serverSettings.free_mode && serverSettings.free_mode.enable) {
                settings.freeMode = {
                    enabled: true,
                    sticky: !!serverSettings.free_mode.sticky,
                    momentum: !!serverSettings.free_mode.momentum,
                };
            }

            if (serverSettings.navigation) {
                const prevSelector = serverSettings.navigation.prevEl || '';
                const nextSelector = serverSettings.navigation.nextEl || '';

                const prevEl = prevSelector
                    ? document.querySelector(prevSelector)
                    : null;

                const nextEl = nextSelector
                    ? document.querySelector(nextSelector)
                    : null;

                settings.navigation = {
                    prevEl: prevEl || $carousel.find('.carousel__button-prev')[0] || null,
                    nextEl: nextEl || $carousel.find('.carousel__button-next')[0] || null,
                };

            }

            if ( serverSettings.pagination !== false ) {
                settings.pagination = {
                    el: $carousel.find('.carousel__pagination')[0],
                    type: 'bullets',
                    clickable: true,
                    bulletClass: 'bullet',
                };
            }

            if (serverSettings.scrollBar) {
                settings.scrollbar = {
                    el: $carousel.find('.carousel__scrollbar')[0],
                };
            }

            if (serverSettings.breakpoints) {
                settings.breakpoints = {
                    0: { 
                        slidesPerView: serverSettings.breakpoints.xs?.slidesPerView ?? 1,
                        spaceBetween: serverSettings.breakpoints.xs?.spaceBetween ?? 0,
                        grid: serverSettings.breakpoints.xs?.grid
                    },
                    576: { 
                        slidesPerView: serverSettings.breakpoints.sm?.slidesPerView ?? 1,
                        spaceBetween: serverSettings.breakpoints.sm?.spaceBetween ?? 0,
                        grid: serverSettings.breakpoints.sm?.grid ?? 1
                    },
                    768: { 
                        slidesPerView: serverSettings.breakpoints.md?.slidesPerView ?? 2,
                        spaceBetween: serverSettings.breakpoints.md?.spaceBetween ?? 20,
                        grid: serverSettings.breakpoints.md?.grid ?? 1
                    },
                    992: { 
                        slidesPerView: serverSettings.breakpoints.lg?.slidesPerView ?? 3,
                        spaceBetween: serverSettings.breakpoints.lg?.spaceBetween ?? 20,
                        grid: serverSettings.breakpoints.lg?.grid ?? 1
                    },
                    1200: { 
                        slidesPerView: serverSettings.breakpoints.xl?.slidesPerView ?? 4,
                        spaceBetween: serverSettings.breakpoints.xl?.spaceBetween ?? 30,
                        grid: serverSettings.breakpoints.xl?.grid ?? 1
                    },
                    1400: { 
                        slidesPerView: serverSettings.breakpoints.xxl?.slidesPerView ?? 5,
                        spaceBetween: serverSettings.breakpoints.xxl?.spaceBetween ?? 30,
                        grid: serverSettings.breakpoints.xxl?.grid ?? 1
                    }
                };
            }

            settings.on = {
                init: function () {
                    const swiper = this;
                    const swiperEl = $(swiper.el);
                    setCenterVisibleSlide(swiper)
                },
                slideChange: function () {
                    const swiper = this;
                    const activeIndex = swiper.activeIndex;
                    let realIndex = swiper.realIndex;
                    let index = serverSettings.loop == true ? activeIndex : realIndex;
                    if( carouselClasses.includes('cs-testimonial-carousel__content') ) {
                        const $carouselThumbs = $carousel.siblings('.cs-testimonial-carousel__images');
                        if( $carouselThumbs.length ) {
                            $carouselThumbs.get(0).swiper.slideTo(index);
                        }
                    }
                    setCenterVisibleSlide(swiper)
                },
                transitionEnd: function () {
                }
            };

            new Swiper($carousel[0], settings);
        });
    }

    function carouselHandler($scope, $) {
        initSwiperCarousel($scope);
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-services-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-testimonial-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-project-image-gallery.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-steps-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-members-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-icons-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-posts-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-price-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-projects-carousel.default', carouselHandler);
    });

})(jQuery);