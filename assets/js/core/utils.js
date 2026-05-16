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