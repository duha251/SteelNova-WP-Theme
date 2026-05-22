function handleSubmenu() {
    const subMenus = document.querySelectorAll('.header-menu .sub-menu');
    const windowWidth = window.innerWidth;

    subMenus.forEach((submenu) => {
        const rect = submenu.getBoundingClientRect();
        const submenuLeft = rect.left + window.scrollX;
        const submenuWidth = submenu.offsetWidth;

        if (submenuLeft + submenuWidth > windowWidth) {
            submenu.classList.add('submenu-reverse');
        }
    });
}

function toggleSubmenuMobile() {
    const headerNavigation = document.querySelector('.header-navigation');

    if (!headerNavigation) {
        return;
    }

    headerNavigation.addEventListener('click', function (e) {
        const trigger = e.target.closest('.menu-link-icon--mobile');

        if (!trigger || !headerNavigation.contains(trigger)) {
            return;
        }

        e.preventDefault();
        e.stopPropagation();

        const parent = trigger.closest('li.menu-item');

        if (!parent) {
            return;
        }

        const submenu = parent.querySelector(':scope > .sub-menu, :scope > .pxl-mega-menu');

        if (!submenu) {
            return;
        }

        slideToggle(submenu, 300, function () {
            parent.classList.toggle('is-open');
        });

        // Accordion style: đóng các menu khác cùng cấp
        // parent.parentElement.querySelectorAll(':scope > .menu-item.is-open').forEach((item) => {
        //     if (item === parent) return;

        //     const otherSubmenu = item.querySelector(':scope > .sub-menu, :scope > .pxl-mega-menu');

        //     if (otherSubmenu) {
        //         slideUp(otherSubmenu, 300, function () {
        //             item.classList.remove('is-open');
        //         });
        //     }
        // });
    });
}