export const delegate = (parent, eventType, selector, handler) => {
    parent.addEventListener(eventType, (event) => {
        const target = event.target.closest(selector);
        if (!target || !parent.contains(target)) return;
        handler(event, target);
    });
};


// playVideoPopup: function() {
//     const getEmbedUrl = function(url) {
//         let embedUrl = null;
        
//         const youtubeRegex = /(?:[?&]v=([^&]+)|youtu\.be\/([^?]+))/;
//         let ytMatch = url.match(youtubeRegex);
        
//         if (ytMatch) {
//             const videoId = ytMatch[1] || ytMatch[2]; 
//             embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
//             return embedUrl;
//         }

//         const vimeoRegex = /vimeo\.com\/(?:video\/)?(\d+)/;
//         let vimeoMatch = url.match(vimeoRegex);
        
//         if (vimeoMatch) {
//             const videoId = vimeoMatch[1];
//             embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
//             return embedUrl;
//         }

//         if (url.endsWith('.mp4')) {
//             return `<video controls autoplay src="${url}"></video>`;
//         }
//         return null;
//     }

//     const closeVideoPopup = function() {
//         const $overlay = $('.body-overlay');
//         const $popup = $('.video-popup');

//         if (!$popup.length) return;

//         $overlay.removeClass('is-visible');
//         $popup.removeClass('is-visible');
//         $('body').removeClass('body-overflow');

//         $popup.one('transitionend webkitTransitionEnd oTransitionEnd', function() {
//             $popup.remove();
//         });
//     }
//     $(document.body).on('click', '.button[data-type="play"]', function(e) {
//         e.preventDefault();
        
//         const videoUrl = $(this).attr('href');
//         if (!videoUrl) return;

//         const embedContent = getEmbedUrl(videoUrl);
        
//         if (!embedContent) {
//             console.error('Unable to recognize video link:', videoUrl);
//             return;
//         }

//         let playerHtml = embedContent.startsWith('<video') 
//             ? embedContent 
//             : `<iframe src="${embedContent}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;

//         const modalHtml = `
//             <div class="video-popup">
//             <div class="video-popup-inner">
//                 <button class="button button-close" aria-label="Close">
//                     <span class="icon-X"></span>
//                 </button>
//                     ${playerHtml}
//                 </div>
//             </div>
//         `;

//         const $overlay = $('.body-overlay');
        
//         const $popup = $(modalHtml);

//         $('body').append($popup).addClass('body-overflow');

//         setTimeout(function() {
//             $overlay.addClass('is-visible'); 
//             $popup.addClass('is-visible');    
//         }, 10);
//     });
//     $(document.body).on('click', '.body-overlay.is-visible', function() {
//         closeVideoPopup();
//     });

//     $(document.body).on('click', '.video-popup .button-close', function() {
//         closeVideoPopup();
//     });
// },