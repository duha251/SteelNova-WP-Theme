(function ($) {
    "use strict";

    $(document).on("click", ".cs-button--toggle-layout", function () {
        const $btn = $(this);

        let layout = $btn.data('layout') === 'list' ? 'list' : 'grid';

        $(".cs-button--toggle-layout").removeClass("is-active");
        $btn.addClass("is-active");

        $.ajax({
            url: steelnova_ajax.ajax_url,
            type: "POST",
            data: {
                action: "steelnova_toggle_layout",
                layout: layout,
            },
            beforeSend: function () {
                $(".products-grid").addClass("is-loading");
            },
            success: function (res) {
                if (res.success) {
                    $(".products-grid").replaceWith(res.data.html);
                }
            }
        });
    });

})(jQuery);