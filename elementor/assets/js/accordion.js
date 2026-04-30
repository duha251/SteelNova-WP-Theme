(function ($) {
    "use strict";

    function initAccordion($scope) {
        const $accordion = $scope.find(".cs-accordion");

        if (!$accordion.length) {
            return;
        }

        const $items = $accordion.find(".cs-accordion__item");
        const mode = $accordion.data("mode") || "one";
        const toggle = $accordion.data("toggle") || "on";

        if (!$items.length) {
            return;
        }

        $items.each(function () {
            const $item = $(this);
            const $content = $item.children(".cs-accordion__content");

            if ($item.hasClass("is-active")) {
                $content.css("height", $content[0].scrollHeight + "px");
            } else {
                $content.css("height", 0);
            }
        });

        $accordion.on("click", ".cs-accordion__header", function (e) {
                e.preventDefault();
                const $header = $(this);
                const $item = $header.closest(".cs-accordion__item");
                const $content = $item.children(".cs-accordion__content");
                const isActive = $item.hasClass("is-active");

                if (isActive && toggle === "on") {
                    $item.removeClass("is-active");
                    $content.css("height", 0);
                    return;
                }

                if (mode !== "multiple") {
                    $items.each(function () {
                        const $otherItem = $(this);
                        const $otherContent = $otherItem.children(".cs-accordion__content");

                        $otherItem.removeClass("is-active");
                        $otherContent.css("height", 0);
                    });
                }

                $item.addClass("is-active");
                $content.css("height", $content[0].scrollHeight + "px");
            });
    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/steelnova-accordion.default", initAccordion );
        
    });

})(jQuery);