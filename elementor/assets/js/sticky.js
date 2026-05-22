(function ($) {
    "use strict";

    function initSticky($scope, $) {
        setTimeout(() => {
            const $selectors = $scope.find('[data-sticky-settings]');
    
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
    
                    const settings = $selector.data('sticky-settings') ?? {};
    
                    const $parent = settings.trigger && settings.trigger !== ''
                        ? $(settings.trigger).first()
                        : $selector.parent();
    
                    if (!$parent.length) {
                        return;
                    }
    
                    const screen = settings.breakOn ?? 0;
    
                    // if (breakOnScreen(screen)) {
                    //     return;
                    // }
    
                    const getScrollDistance = () => {
                        if (isNumberString(settings.trigger)) {
                            return parseFloat(settings.trigger);
                        }
    
                        // const parentPaddingBottom = parseFloat($parent.css('padding-bottom')) || 0;
                        const selectorTop = $selector.offset().top;
                        const parentTop = $parent.offset().top;
    
                        return $parent.outerHeight()
                            - $selector.outerHeight()
                            - (selectorTop - parentTop)
                            // - parentPaddingBottom;
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
        }, 300)
    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/steelnova-projects-grid.default",
            initSticky
        );
    });

})(jQuery);