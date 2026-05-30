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

        priceFilterForm: ".cs-price-filter",
        filterLink: ".cs-categories.is-post-type-product a, .cs-tags a, .cs-brands a",
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

    function getFiltersFromUrl(url) {
        const currentUrl = new URL(window.location.href);
        const targetUrl = url ? new URL(url, window.location.origin) : currentUrl;

        const filters = {
            product_cat: currentUrl.searchParams.get("product_cat") || steelnova_ajax.product_cat || "",
            product_tag: currentUrl.searchParams.get("product_tag") || steelnova_ajax.product_tag || "",
            product_brand: currentUrl.searchParams.get("product_brand") || steelnova_ajax.product_brand || "",
            min_price: currentUrl.searchParams.get("min_price") || "",
            max_price: currentUrl.searchParams.get("max_price") || "",
        };

        const filterKeys = [
            "product_cat",
            "product_tag",
            "product_brand",
            "min_price",
            "max_price",
        ];

        filterKeys.forEach(function (key) {
            if (targetUrl.searchParams.has(key)) {
                filters[key] = targetUrl.searchParams.get(key) || "";
            }
        });

        return filters;
    }

    function updateUrl(layout, paged, filters) {
        const newUrl = new URL(window.location.href);

        newUrl.searchParams.set("product_view", layout);

        if (paged > 1) {
            newUrl.searchParams.set("paged", paged);
        } else {
            newUrl.searchParams.delete("paged");
        }

        $.each(filters || {}, function (key, value) {
            if (value !== undefined && value !== null && value !== "") {
                newUrl.searchParams.set(key, value);
            } else {
                newUrl.searchParams.delete(key);
            }
        });

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

    function updateFilterActiveStates(filters) {
        const activeFilters = filters || getFiltersFromUrl();

        updateFilterGroupActive(
            ".cs-categories.is-post-type-product .category",
            ".category__link",
            "product_cat",
            activeFilters.product_cat
        );

        updateFilterGroupActive(
            ".cs-tags .tag",
            ".tag__link",
            "product_tag",
            activeFilters.product_tag
        );

        updateFilterGroupActive(
            ".cs-brands .brand",
            ".brand__link",
            "product_brand",
            activeFilters.product_brand
        );
    }

    function updateFilterGroupActive(itemSelector, linkSelector, queryKey, activeValue) {
        $(itemSelector).each(function () {
            const $item = $(this);
            const $link = $item.find(linkSelector).first();
            const href = $link.attr("href");

            if (!href) {
                return;
            }

            const url = new URL(href, window.location.origin);
            const linkValue = url.searchParams.get(queryKey) || "";
            const isActive = activeValue !== "" && linkValue === activeValue;

            $item.toggleClass("is-active", isActive);

            if (isActive) {
                $link.attr("aria-current", "page");
            } else {
                $link.removeAttr("aria-current");
            }
        });
    }

    function loadProducts(args = {}) {
        const layout = args.layout || getCurrentLayout();
        const paged = args.paged || 1;
        const orderby = $(selectors.orderingSelect).val() || "";
        const filters = args.filters || getFiltersFromUrl();

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

                product_cat: filters.product_cat || "",
                product_tag: filters.product_tag || "",
                product_brand: filters.product_brand || "",
                min_price: filters.min_price || "",
                max_price: filters.max_price || "",
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

                updateUrl(layout, paged, filters);
                updateFilterActiveStates(filters);
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

    $(document).on("submit", selectors.priceFilterForm, function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const filters = getFiltersFromUrl();

        filters.min_price = formData.get("min_price") || "";
        filters.max_price = formData.get("max_price") || "";

        for (const [key, value] of formData.entries()) {
            if (key !== "min_price" && key !== "max_price") {
                filters[key] = value;
            }
        }

        loadProducts({
            layout: getCurrentLayout(),
            paged: 1,
            filters: filters,
        });
    });

    $(document).on("click", selectors.filterLink, function (e) {
        const href = $(this).attr("href");

        if (!href) {
            return;
        }

        e.preventDefault();

        const filters = getFiltersFromUrl(href);

        loadProducts({
            layout: getCurrentLayout(),
            paged: 1,
            filters: filters,
        });
    });
    updateFilterActiveStates();
})(jQuery);