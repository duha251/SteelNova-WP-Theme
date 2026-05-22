        // sticky: function() {
        //     const $selectors = $('.is-sticky');
        //     if (!$selectors.length) {
        //         return;
        //     }
        //     let isNumberString = (value) => {
        //         return value !== '' && !isNaN(value);
        //     } 
        //     let handler = ( $elements ) => {
        //         $elements.each(function() {
        //             const $selector = $(this);
        //             const settings = $selector.data('sticky-settings') ?? {};
        //             const $parent = ( settings.trigger && settings.trigger !== '' ) ? $(settings.trigger) : $selector.parent();
        //             const screen = settings.breakOn ?? 0;
        //             if( breakOnScreen( screen ) ) {
        //                 return;
        //             }
        //             let getScrollDistance = () => {
        //                 if( isNumberString(settings.trigger) ) {
        //                     return parseFloat(settings.trigger);
        //                 }
        //                 const parentPaddingBottom = parseFloat($parent.css('padding-bottom')) || 0;
        //                 const selectorTop = $selector.offset().top;
        //                 const parentTop   = $parent.offset().top;
        //                 return $parent.outerHeight() 
        //                     - $selector.outerHeight() 
        //                     - (selectorTop - parentTop) - parentPaddingBottom;
        //             };
        //             let position = settings.position ?? 'top';
        //             let offset = settings.offset ?? 30;
        //             let triggerObj = {
        //                 trigger: $selector,   
        //                 start: `top top+=${offset}px`,     
        //                 end: () => `+=${getScrollDistance()}`,
        //                 pin: true,             
        //                 pinSpacing: settings.spacing ?? false,      
        //                 markers: false,         
        //                 invalidateOnRefresh: true,
        //                 scub: 2,
        //             }
        //             if( position == 'bottom' ) {
        //                 triggerObj.start = `bottom bottom-=${offset}`;
        //                 triggerObj.end = `bottom bottom-=${offset}`;
        //                 triggerObj.endTrigger = $parent
        //             }
        //             ScrollTrigger.create(triggerObj)
        //         });
        //     }
        //     if( $selectors.find('img').length ) {
        //         $($selectors).imagesLoaded().done( function( instance ) { 
        //             handler( $selectors )
        //         })
        //         return;
        //     }
        //     handler( $selectors );
        // }