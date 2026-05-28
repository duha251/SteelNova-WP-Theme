(function ($) {
    "use strict";

    const breakOnScreen = function( screen ) {
        let screenWidth = 0;
        if (screen === 'widescreen') {
            screenWidth = 2400;
        } else if (screen === 'desktop') {
            screenWidth = 1920;
        } else if (screen === 'laptop') {
            screenWidth = 1400;
        } else if (screen === 'tablet_extra') {
            screenWidth = 1200;
        } else if (screen === 'tablet') {
            screenWidth = 992;
        } else if (screen === 'mobile_extra') {
            screenWidth = 768;
        } else if (screen === 'mobile') {
            screenWidth = 576;
        }
        return $(window).width() < screenWidth;
    }

    function initSticky($scope, $) {
        setTimeout(() => {
            let $selectors = $scope.find('[data-sticky-settings]');

            /**
             * Trường hợp chính $scope cũng là sticky element
             */
            if ($scope.is('[data-sticky-settings]')) {
                $selectors = $selectors.add($scope);
            }

            /**
             * Trường hợp $scope có class is-sticky nhưng chưa có data-sticky-settings
             */
            if ($scope.hasClass('is-sticky') && !$scope.is('[data-sticky-settings]')) {
                $scope.attr('data-sticky-settings', JSON.stringify({
                    position: 'top',
                    offset: 30,
                    spacing: false,
                    trigger: '',
                    breakOn: 0
                }));

                $selectors = $selectors.add($scope);
            }

            if (!$selectors.length) {
                return;
            }

            const isNumberString = (value) => {
                return value !== '' && !isNaN(value);
            };

            const handler = ($elements) => {
                $elements.each(function () {
                    const $selector = $(this);

                    if ($selector.data('sticky-initialized')) {
                        return;
                    }

                    $selector.data('sticky-initialized', true);

                    let settings = $selector.data('sticky-settings') ?? {};

                    /**
                     * Fallback nếu data-sticky-settings là string
                     */
                    if (typeof settings === 'string') {
                        try {
                            settings = JSON.parse(settings);
                        } catch (e) {
                            settings = {};
                        }
                    }

                    const $parent = settings.trigger && settings.trigger !== '' && !isNumberString(settings.trigger)
                        ? $(settings.trigger).first()
                        : $selector.parent();

                    if (!$parent.length) {
                        return;
                    }

                    const screen = settings.breakOn ?? 0;

                    if (breakOnScreen(screen)) {
                        return;
                    }

                    const getScrollDistance = () => {
                        if (isNumberString(settings.trigger)) {
                            return parseFloat(settings.trigger);
                        }

                        const selectorTop = $selector.offset().top;
                        const parentTop = $parent.offset().top;

                        return $parent.outerHeight()
                            - $selector.outerHeight()
                            - (selectorTop - parentTop);
                    };

                    const position = settings.position ?? 'top';
                    const offset = settings.offset ?? 30;

                    const triggerObj = {
                        trigger: $selector[0],
                        start: `top top+=${offset}px`,
                        end: () => `+=${getScrollDistance()}`,
                        pin: true,
                        pinSpacing: settings.spacing ?? false,
                        markers: false,
                        invalidateOnRefresh: true,
                        scrub: 2,
                    };

                    if (position === 'bottom') {
                        triggerObj.start = `bottom bottom-=${offset}px`;
                        triggerObj.end = `bottom bottom-=${offset}px`;
                        triggerObj.endTrigger = $parent[0];
                    }

                    ScrollTrigger.create(triggerObj);
                });

                ScrollTrigger.refresh();
            };

            if ($selectors.find('img').length) {
                $selectors.imagesLoaded().done(function () {
                    handler($selectors);
                });

                return;
            }

            handler($selectors);
        }, 300);
    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/steelnova-projects-grid.default",
            initSticky
        );
        elementorFrontend.hooks.addAction('frontend/element_ready/container', initSticky);
    });

})(jQuery);