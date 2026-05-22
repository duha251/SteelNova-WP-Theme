const initVideoPopup = () => {
    const body = document.body;

    const getEmbedUrl = (url) => {
        const youtubeRegex = /(?:[?&]v=([^&]+)|youtu\.be\/([^?]+))/;
        const ytMatch = url.match(youtubeRegex);

        if (ytMatch) {
            const videoId = ytMatch[1] || ytMatch[2];
            return `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        }

        const vimeoRegex = /vimeo\.com\/(?:video\/)?(\d+)/;
        const vimeoMatch = url.match(vimeoRegex);

        if (vimeoMatch) {
            const videoId = vimeoMatch[1];
            return `https://player.vimeo.com/video/${videoId}?autoplay=1`;
        }

        if (url.endsWith(".mp4")) {
            return `<video controls autoplay src="${url}"></video>`;
        }

        return null;
    };

    const closeVideoPopup = () => {
        const popup = document.querySelector(".video-popup");
        const inner = popup?.querySelector(".video-popup__inner");

        if (!popup || !inner) return;

        popup.classList.remove("is-visible");
        hideOverlay();
        body.classList.remove("body-overflow");

        const removePopup = () => popup.remove();

        inner.addEventListener("transitionend", removePopup, { once: true });
        setTimeout(removePopup, 400);
    };

    body.addEventListener("click", (e) => {
        const btn = e.target.closest('.cs-button[data-type="play"]');
        if (!btn) return;

        e.preventDefault();

        const videoUrl = btn.getAttribute("href");
        if (!videoUrl) return;

        const oldPopup = document.querySelector(".video-popup");
        if (oldPopup) oldPopup.remove();

        const embedContent = getEmbedUrl(videoUrl);

        if (!embedContent) {
            console.error("Unable to recognize video link:", videoUrl);
            return;
        }

        const playerHtml = embedContent.startsWith("<video")
            ? embedContent
            : `<iframe src="${embedContent}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;

        const modalHtml = `
            <div class="video-popup">
                <div class="video-popup__inner">
                    <button class="cs-button cs-button--close" aria-label="Close">
                        <span class="icon-x"></span>
                    </button>
                    ${playerHtml}
                </div>
            </div>
        `;

        const wrapper = document.createElement("div");
        wrapper.innerHTML = modalHtml.trim();
        const popup = wrapper.firstElementChild;

        body.appendChild(popup);
        body.classList.add("body-overflow");

        requestAnimationFrame(() => {
            showOverlay();
            popup.classList.add("is-visible");
        });
    });

    body.addEventListener("click", (e) => {
        if (e.target.closest(".body__overlay.is-visible")) {
            closeVideoPopup();
        }
    });

    body.addEventListener("click", (e) => {
        if (e.target.closest(".video-popup .cs-button--close")) {
            closeVideoPopup();
        }
    });
};