(function ($) {
    "use strict";

    function tabsInit($scope) {
        const $tabs = $scope.find(".cs-tabs");
        const $tabButtons = $tabs.find(".cs-tabs__nav button");
        const $tabContents = $tabs.find(".cs-tabs__contents .cs-tabs__content");

        if (!$tabs.length || !$tabButtons.length || !$tabContents.length) return;

        let currentIndex = 0;
        let isAnimating = false;
        const duration = 300;
        const distance = 30;

        // Init
        $tabButtons.removeClass("is-active");
        $tabContents
            .removeClass("is-active")
            .hide()
            .css({
                opacity: 0,
                position: "relative",
                top: 0
            });

        $tabButtons.eq(0).addClass("is-active");
        $tabContents.eq(0)
            .addClass("is-active")
            .show()
            .css({
                opacity: 1,
                top: 0
            });

        $tabButtons.off("click.csTabs").on("click.csTabs", function (e) {
            e.preventDefault();

            if (isAnimating) return;

            const $button = $(this);
            const nextIndex = $button.index();

            if (nextIndex === currentIndex) return;

            const $currentContent = $tabContents.eq(currentIndex);
            const $nextContent = $tabContents.eq(nextIndex);

            isAnimating = true;

            $tabButtons.removeClass("is-active");
            $button.addClass("is-active");

            // Current content: fade down
            $currentContent
                .stop(true, true)
                .animate(
                    {
                        opacity: 0,
                        top: distance
                    },
                    duration,
                    function () {
                        $currentContent
                            .removeClass("is-active")
                            .hide()
                            .css({
                                top: 0
                            });

                        // Next content: fade up
                        $nextContent
                            .stop(true, true)
                            .css({
                                opacity: 0,
                                top: distance,
                                position: "relative"
                            })
                            .show()
                            .addClass("is-active")
                            .animate(
                                {
                                    opacity: 1,
                                    top: 0
                                },
                                duration,
                                function () {
                                    currentIndex = nextIndex;
                                    isAnimating = false;
                                }
                            );
                    }
                );
        });
    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/steelnova-tabs.default",
            tabsInit
        );
    });

})(jQuery);