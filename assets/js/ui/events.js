export function toggleDrawer() {
    let currentPanel = '';
    document.body.addEventListener('click', function (e) {
        const toggleBtn = e.target.closest('.button-toggle, .button-hamburger');

        if (toggleBtn) {
            e.preventDefault();

            let panel = toggleBtn.getAttribute('href') || toggleBtn.dataset.target;

            if (!panel) return;

            const panelEl = document.querySelector(panel);
            if (!panelEl) return;

            document.querySelectorAll('.body-overlay').forEach(el => {
                el.classList.add('is-visible');
            });

            document.body.classList.add('body-overflow');
            panelEl.classList.add('is-active');

            currentPanel = panel;
            return;
        }

        const closeBtn = e.target.closest('.button-close, .body-overlay');

        if (closeBtn) {
            e.preventDefault();

            if (!currentPanel) return;

            document.querySelectorAll('.body-overlay').forEach(el => {
                el.classList.remove('is-visible');
            });

            document.body.classList.remove('body-overflow');

            const panelEl = document.querySelector(currentPanel);
            if (panelEl) {
                panelEl.classList.remove('is-active');
            }
            currentPanel = '';
        }
    });
}