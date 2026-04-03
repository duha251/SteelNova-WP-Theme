
let isDrawerBound = false;
let currentPanel = null;

const SELECTORS = {
    toggle: ".button-toggle, .button-hamburger",
    close: ".button-close, .body-overlay",
    overlay: ".body-overlay",
};

const getPanelSelector = (trigger) => {
    if (!trigger) return "";

    const href = trigger.getAttribute("href");
    const target = trigger.dataset.target;

    if (target && target.trim() !== "") {
        return target.trim();
    }

    if (href && href.startsWith("#")) {
        return href.trim();
    }

    return "";
};

const getPanelElement = (trigger) => {
    const selector = getPanelSelector(trigger);
    if (!selector) return null;

    try {
        return document.querySelector(selector);
    } catch (error) {
        console.warn("Invalid drawer selector:", selector, error);
        return null;
    }
};

const showOverlays = () => {
    document.querySelectorAll(SELECTORS.overlay).forEach((overlay) => {
        overlay.classList.add("is-visible");
    });
};

const hideOverlays = () => {
    document.querySelectorAll(SELECTORS.overlay).forEach((overlay) => {
        overlay.classList.remove("is-visible");
    });
};

export const closeDrawer = (panel = currentPanel) => {
    if (!panel) return;

    panel.classList.remove("is-active");
    hideOverlays();
    document.body.classList.remove("body-overflow");

    if (currentPanel === panel) {
        currentPanel = null;
    }
};

export const openDrawer = (panel) => {
    if (!panel) return;

    if (currentPanel && currentPanel !== panel) {
        closeDrawer(currentPanel);
    }

    panel.classList.add("is-active");
    showOverlays();
    document.body.classList.add("body-overflow");

    currentPanel = panel;
};

export const initDrawer = () => {
    if (isDrawerBound) return;
    isDrawerBound = true;

    document.body.addEventListener("click", (event) => {
        const toggleBtn = event.target.closest(SELECTORS.toggle);

        if (toggleBtn) {
            const panel = getPanelElement(toggleBtn);

            if (!panel) return;

            event.preventDefault();

            if (panel.classList.contains("is-active")) {
                closeDrawer(panel);
            } else {
                openDrawer(panel);
            }

            return;
        }

        const closeBtn = event.target.closest(SELECTORS.close);

        if (closeBtn) {
            event.preventDefault();
            closeDrawer();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && currentPanel) {
            closeDrawer();
        }
    });
};