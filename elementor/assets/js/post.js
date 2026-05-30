( function( $ ) {
    "use strict";
    function getArchiveContext() {
        return SteelNovaAjax.archive_context || {};
    }

    const ajaxHandler = ( paramObject ) => {
        const {
            page = 1,
            settings = {},
            layout = 1,
            wrapper = '',
            action = '',
            catSlug = '',
            archiveContext = {}
        } = paramObject;

        let data = {
            action: 'load_posts',
            page: page,
            settings: settings,
            layout: layout,
            archive_context: archiveContext,
            _ajax_nonce: SteelNovaAjax.nonce
        }

        if( action === 'filter' ) {
            data.cat_slug = catSlug;
        }

        $.ajax({
            url: SteelNovaAjax.ajaxurl, 
            type: 'POST',
            data: data,
            success: function(response) {
                if( response.data ) {
                    const gridHtml = response.data.grid_html;
                    const paginationHtml = response.data.pagination_html;
                    if( wrapper.length ) {
                        if( action === 'load_more' ) {
                            wrapper.find('.grid__inner:not(.posts-grid__feature)').append(gridHtml);
                            return;
                        }
                        wrapper.find('.grid__inner:not(.posts-grid__feature)').html(gridHtml);
                        wrapper.find('.pagination.ajax').replaceWith(paginationHtml)
                    }
                }
            },
            complete: function() {
                if( wrapper.length ) {
                    wrapper.removeClass('is-loading');
                }
            }
        });
    }

    function ajaxPagination() {        
        $(document.body).off('click', '.pagination.ajax a').on('click', '.pagination.ajax a', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const page = $btn.attr('href').replace('#', '');
            const $parent = $btn.closest('.grid');
            const settings = $parent.data('settings');
            const layout = $parent.data('layout');
            $parent.addClass('is-loading');
            $('html, body').animate({
                scrollTop: $parent.offset().top - 100
            }, 1000);
            ajaxHandler({
                page: page,
                settings: settings,
                layout: layout,
                wrapper: $parent,
                action: 'pagination',
                archiveContext: getArchiveContext()
            });
        });
    }

    function ajaxLoadMore() {
        $(document.body).off('click', '.grid-load-more.ajax .button-load-more').on('click', '.grid-load-more.ajax .button-load-more', function(e) {
            e.preventDefault();
            const $btn = $(this);   
            const $parent = $btn.closest('.grid');
            const currentPage = parseInt( $btn.data('current-page') ) || 1;
            const nextPage = currentPage + 1;
            const settings = $parent.data('settings');
            const layout = $parent.data('layout');
            $parent.addClass('is-loading');
            ajaxHandler({
                page: nextPage,
                settings: settings,
                layout: layout,
                wrapper: $parent,
                action: 'load_more',
                archiveContext: getArchiveContext()
            });
            $parent.data('current-page', nextPage);
        });
    }

    
    $( window ).on( 'elementor/frontend/init', function() {
        ajaxPagination();
        ajaxLoadMore();
    });
    

} )( jQuery );