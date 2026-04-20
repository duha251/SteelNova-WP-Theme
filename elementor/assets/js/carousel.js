(function ($) {
    "use strict";

    function initSwiperCarousel($scope) {
        const $carousels = $scope.find('.swiper');
        if (!$carousels.length) return;

        $carousels.each(function () {
            const $carousel = $(this);

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

            // 3. Xử lý Autoplay
            if (serverSettings.autoPlay && serverSettings.autoPlay.enable) {
                settings.autoplay = {
                    delay: serverSettings.autoPlay.delay || 3000,
                    disableOnInteraction: !!serverSettings.autoPlay.disableOnInteraction,
                    pauseOnMouseEnter: !!serverSettings.autoPlay.pauseOnMouseEnter,
                    reverseDirection: !!serverSettings.autoPlay.reverseDirection,
                };
            }

            // 4. Xử lý Free Mode
            if (serverSettings.free_mode && serverSettings.free_mode.enable) {
                settings.freeMode = {
                    enabled: true,
                    sticky: !!serverSettings.free_mode.sticky,
                    momentum: !!serverSettings.free_mode.momentum,
                };
            }

            // 5. Xử lý Navigation (Ưu tiên ID từ PHP nếu có)
            if (serverSettings.navigation) {
                const prevSelector = serverSettings.navigation.prevEl || '';
                const nextSelector = serverSettings.navigation.nextEl || '';
                console.log(serverSettings.navigation.prevEl)

                console.log( $(serverSettings.navigation.prevEl)[0] )
                const prevEl = prevSelector
                    ? document.querySelector(prevSelector)
                    : null;

                const nextEl = nextSelector
                    ? document.querySelector(nextSelector)
                    : null;

                settings.navigation = {
                    prevEl: prevEl || $carousel.find('.carousel-button-prev')[0] || null,
                    nextEl: nextEl || $carousel.find('.carousel-button-next')[0] || null,
                };

                console.log('navigation:', settings.navigation);
            }

            // 6. Xử lý Pagination
            if (serverSettings.pagination) {
                settings.pagination = {
                    el: $carousel.find('.carousel-pagination')[0],
                    type: 'bullets',
                    clickable: true,
                    bulletClass: 'bullet',
                    bulletActiveClass: 'is-active',
                };
            }

            // 7. Xử lý Scrollbar
            if (serverSettings.scrollBar) {
                settings.scrollbar = {
                    el: $carousel.find('.carousel-scrollbar')[0],
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
                        grid: serverSettings.breakpoints.sm?.grid
                    },
                    768: { 
                        slidesPerView: serverSettings.breakpoints.md?.slidesPerView ?? 2,
                        spaceBetween: serverSettings.breakpoints.md?.spaceBetween ?? 20,
                        grid: serverSettings.breakpoints.md?.grid
                    },
                    992: { 
                        slidesPerView: serverSettings.breakpoints.lg?.slidesPerView ?? 3,
                        spaceBetween: serverSettings.breakpoints.lg?.spaceBetween ?? 20,
                        grid: serverSettings.breakpoints.lg?.grid
                    },
                    1200: { 
                        slidesPerView: serverSettings.breakpoints.xl?.slidesPerView ?? 4,
                        spaceBetween: serverSettings.breakpoints.xl?.spaceBetween ?? 30,
                        grid: serverSettings.breakpoints.xl?.grid
                    },
                    1400: { 
                        slidesPerView: serverSettings.breakpoints.xxl?.slidesPerView ?? 5,
                        spaceBetween: serverSettings.breakpoints.xxl?.spaceBetween ?? 30,
                        grid: serverSettings.breakpoints.xxl?.grid
                    }
                };
            }

            // 9. Giữ lại các Events on của bạn
            settings.on = {
                init: function () {
                    const swiper = this;
                    const $el = $(swiper.el);
                    if ($el.closest('#horizontalCarousel').length) {
                        const mainSwiper = $('.custom-product-gallery .swiper')[0]?.swiper;
                        if (mainSwiper) {
                            $(swiper.slides).on('click', function () {
                                const index = $(this).index();
                                const realIndex = this.dataset.swiperSlideIndex !== undefined
                                    ? parseInt(this.dataset.swiperSlideIndex, 10)
                                    : index;
                                mainSwiper.slideTo(realIndex);
                            });
                        }
                    }
                },
                slideChange: function () {
                    handleBoxShadow(this);
                },
                transitionEnd: function () {
                    handleBoxShadow(this);
                }
            };

            function handleBoxShadow(swiper) {
                const $el = $(swiper.el);
                if ($el.hasClass('swiper-boxshadow')) {
                    $(swiper.slides).css('opacity', '0');
                    $(swiper.slides).filter('.swiper-slide-visible').css('opacity', '1');
                }
            }

            new Swiper($carousel[0], settings);
        });
    }

    function carouselHandler($scope, $) {
        initSwiperCarousel($scope);
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-service-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-testimonial-carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-project-image-gallery.default', carouselHandler);
    });

})(jQuery);