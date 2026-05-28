(function ($) {
    "use strict";

    const selectors = {
        contentArea: ".content-area",
        toggleButton: ".cs-button--toggle-layout",
        productsGrid: ".products-grid",
        paginationWrap: ".pagination.ajax",
        paginationLink: ".pagination.ajax a",
        resultCount: ".steelnova-result-count",
        orderingForm: ".woocommerce-ordering",
        orderingSelect: ".woocommerce-ordering select.orderby",
    };

    function getCurrentLayout() {
        const $activeButton = $(selectors.toggleButton + ".is-active");

        if ($activeButton.length) {
            return $activeButton.data("layout") === "list" ? "list" : "grid";
        }

        const layout = $(selectors.productsGrid).data("layout");

        return layout === "list" ? "list" : "grid";
    }

    function getPageFromUrl(url) {
        if (!url) {
            return 1;
        }

        if (url.indexOf("#") !== -1) {
            const hashPage = url.split("#")[1];

            if (hashPage && !isNaN(hashPage)) {
                return parseInt(hashPage, 10);
            }
        }

        const pagePathMatches = url.match(/\/page\/([0-9]+)/);

        if (pagePathMatches && pagePathMatches[1]) {
            return parseInt(pagePathMatches[1], 10);
        }

        const pagedMatches = url.match(/[?&]paged=([0-9]+)/);

        if (pagedMatches && pagedMatches[1]) {
            return parseInt(pagedMatches[1], 10);
        }

        const pageMatches = url.match(/[?&]page=([0-9]+)/);

        if (pageMatches && pageMatches[1]) {
            return parseInt(pageMatches[1], 10);
        }

        return 1;
    }

    function updateUrl(layout, paged) {
        const newUrl = new URL(window.location.href);

        newUrl.searchParams.set("product_view", layout);

        if (paged > 1) {
            newUrl.searchParams.set("paged", paged);
        } else {
            newUrl.searchParams.delete("paged");
        }

        window.history.pushState({}, "", newUrl.toString());
    }

    function scrollToProducts() {
        const $contentArea = $(selectors.contentArea);

        if (!$contentArea.length) {
            return;
        }

        $("html, body").animate({
            scrollTop: $contentArea.offset().top - 100,
        }, 300);
    }

    function setLoading(isLoading) {
        $(selectors.contentArea).toggleClass("is-loading", isLoading);
        $(selectors.productsGrid).toggleClass("is-loading", isLoading);
    }

    function loadProducts(args = {}) {
        const layout = args.layout || getCurrentLayout();
        const paged = args.paged || 1;
        const orderby = $(selectors.orderingSelect).val() || "";

        $.ajax({
            url: steelnova_ajax.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "steelnova_products_ajax",
                nonce: steelnova_ajax.nonce,
                layout: layout,
                paged: paged,
                orderby: orderby,
                product_cat: steelnova_ajax.product_cat || "",
                product_tag: steelnova_ajax.product_tag || "",
            },
            beforeSend: function () {
                setLoading(true);
            },
            success: function (res) {
                if (!res.success) {
                    return;
                }

                if (res.data.products_html) {
                    $(selectors.productsGrid).replaceWith(res.data.products_html);
                }

                if (res.data.pagination_html) {
                    if ($(selectors.paginationWrap).length) {
                        $(selectors.paginationWrap).replaceWith(res.data.pagination_html);
                    } else {
                        $(selectors.productsGrid).after(res.data.pagination_html);
                    }
                } else {
                    $(selectors.paginationWrap).remove();
                }

                if (res.data.result_count) {
                    $(selectors.resultCount).html(res.data.result_count);
                }

                $(selectors.toggleButton).removeClass("is-active");
                $(selectors.toggleButton + '[data-layout="' + layout + '"]').addClass("is-active");

                updateUrl(layout, paged);
                scrollToProducts();
            },
            complete: function () {
                setLoading(false);
            },
        });
    }

    $(document).on("click", selectors.toggleButton, function (e) {
        e.preventDefault();

        const $button = $(this);
        const layout = $button.data("layout") === "list" ? "list" : "grid";

        if ($button.hasClass("is-active")) {
            return;
        }

        loadProducts({
            layout: layout,
            paged: 1,
        });
    });

    $(document).on("click", selectors.paginationLink, function (e) {
        e.preventDefault();

        const href = $(this).attr("href");
        const paged = getPageFromUrl(href);

        loadProducts({
            layout: getCurrentLayout(),
            paged: paged,
        });
    });

    $(document).on("change", selectors.orderingSelect, function (e) {
        e.preventDefault();

        loadProducts({
            layout: getCurrentLayout(),
            paged: 1,
        });
    });

    $(document).on("submit", selectors.orderingForm, function (e) {
        e.preventDefault();

        loadProducts({
            layout: getCurrentLayout(),
            paged: 1,
        });
    });

})(jQuery);