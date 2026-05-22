const showOverlay = () => {
    document.querySelector('.body__overlay').classList.add("is-visible");
}

const hideOverlay = () => {
    document.querySelector('.body__overlay').classList.remove("is-visible");
}

const getHeight = (element) => {
    return element ? element.offsetHeight : 0;
};


function hoverActive(selector, activeClass = 'is-active') {
  const items = document.querySelectorAll(selector);

  if (!items.length) return;

  items.forEach((item) => {
    item.addEventListener('mouseenter', function () {
      items.forEach((el) => el.classList.remove(activeClass));
      this.classList.add(activeClass);
    });
  });
}

function slideUp(element, duration = 300, callback) {
    element.style.height = `${element.offsetHeight}px`;
    element.style.overflow = 'hidden';
    element.style.transitionProperty = 'height, margin, padding';
    element.style.transitionDuration = `${duration}ms`;
    element.style.transitionTimingFunction = 'ease';

    element.offsetHeight;

    element.style.height = '0';
    element.style.paddingTop = '0';
    element.style.paddingBottom = '0';
    element.style.marginTop = '0';
    element.style.marginBottom = '0';

    window.setTimeout(() => {
        element.style.display = 'none';
        element.style.removeProperty('height');
        element.style.removeProperty('overflow');
        element.style.removeProperty('transition-property');
        element.style.removeProperty('transition-duration');
        element.style.removeProperty('transition-timing-function');
        element.style.removeProperty('padding-top');
        element.style.removeProperty('padding-bottom');
        element.style.removeProperty('margin-top');
        element.style.removeProperty('margin-bottom');

        if (typeof callback === 'function') {
            callback();
        }
    }, duration);
}

function slideDown(element, duration = 300, callback) {
    element.style.removeProperty('display');

    let display = window.getComputedStyle(element).display;

    if (display === 'none') {
        display = 'block';
    }

    element.style.display = display;

    const height = element.scrollHeight;

    element.style.height = '0';
    element.style.overflow = 'hidden';
    element.style.transitionProperty = 'height, margin, padding';
    element.style.transitionDuration = `${duration}ms`;
    element.style.transitionTimingFunction = 'ease';

    element.offsetHeight;

    element.style.height = `${height}px`;

    window.setTimeout(() => {
        element.style.removeProperty('height');
        element.style.removeProperty('overflow');
        element.style.removeProperty('transition-property');
        element.style.removeProperty('transition-duration');
        element.style.removeProperty('transition-timing-function');

        if (typeof callback === 'function') {
            callback();
        }
    }, duration);
}

function slideToggle(element, duration = 300, callback) {
    const isHidden = window.getComputedStyle(element).display === 'none';

    if (isHidden) {
        slideDown(element, duration, callback);
    } else {
        slideUp(element, duration, callback);
    }
}
