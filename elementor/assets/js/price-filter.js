(function ($) {
    "use strict";

    function updatePriceFilter($filter) {
        const $minInput = $filter.find(".cs-price-filter__input--min");
        const $maxInput = $filter.find(".cs-price-filter__input--max");
        const $progress = $filter.find(".cs-price-filter__progress");

        let min = parseInt($minInput.val(), 10);
        let max = parseInt($maxInput.val(), 10);

        const minLimit = parseInt($minInput.attr("min"), 10);
        const maxLimit = parseInt($minInput.attr("max"), 10);

        if (min > max) {
            min = max;
            $minInput.val(min);
        }

        const percentMin = ((min - minLimit) / (maxLimit - minLimit)) * 100;
        const percentMax = ((max - minLimit) / (maxLimit - minLimit)) * 100;

        // 🔥 KEY FIX: dùng width thay vì right
        $progress.css({
            left: percentMin + "%",
            width: (percentMax - percentMin) + "%"
        });

        $filter.find(".cs-price-filter__price-min").text("$" + min);
        $filter.find(".cs-price-filter__price-max").text("$" + max);
    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/steelnova-price-filter.default", function ($scope) {
            const $filter = $scope.find(".cs-price-filter");

            updatePriceFilter($filter);

            $scope.on("input", ".cs-price-filter__input", function () {
                const $currentFilter = $(this).closest(".cs-price-filter");
                const $minInput = $currentFilter.find(".cs-price-filter__input--min");
                const $maxInput = $currentFilter.find(".cs-price-filter__input--max");

                let min = parseInt($minInput.val(), 10);
                let max = parseInt($maxInput.val(), 10);

                if (min > max) {
                    if ($(this).hasClass("cs-price-filter__input--min")) {
                        $minInput.val(max);
                    } else {
                        $maxInput.val(min);
                    }
                }

                updatePriceFilter($currentFilter);
            });
        });
    });
})(jQuery);