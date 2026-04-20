(function ($) {
    "use strict";

    function accordionHandler($scope) {
        const $accordion = $scope.find(".steelnova-accordion");

        if (!$accordion.length) {
            return;
        }

        $accordion.each(function () {
            const $thisAccordion = $(this);
            const $items = $thisAccordion.find(".steelnova-accordion__item");
            const mode = $thisAccordion.data("mode") || "one";
            const toggle = $thisAccordion.data("toggle") || "on";

            if (!$items.length) {
                return;
            }

            $items.each(function () {
                const $item = $(this);
                const $content = $item.children(".steelnova-accordion__content");

                if ($item.hasClass("is-active")) {
                    $content.css("height", $content[0].scrollHeight + "px");
                } else {
                    $content.css("height", 0);
                }
            });

            $thisAccordion
                .off("click.steelnovaAccordion", ".steelnova-accordion__header")
                .on("click.steelnovaAccordion", ".steelnova-accordion__header", function (e) {
                    e.preventDefault();

                    const $header = $(this);
                    const $item = $header.closest(".steelnova-accordion__item");
                    const $content = $item.children(".steelnova-accordion__content");
                    const isActive = $item.hasClass("is-active");

                    if (isActive && toggle === "on") {
                        $item.removeClass("is-active");
                        $content.css("height", 0);
                        return;
                    }

                    if (mode !== "multiple") {
                        $items.each(function () {
                            const $otherItem = $(this);
                            const $otherContent = $otherItem.children(".steelnova-accordion__content");

                            $otherItem.removeClass("is-active");
                            $otherContent.css("height", 0);
                        });
                    }

                    $item.addClass("is-active");
                    $content.css("height", $content[0].scrollHeight + "px");
                });
        });
    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/steelnova-accordion.default",
            accordionHandler
        );
    });

})(jQuery);