const showOverlay = () => {
    document.querySelector('.body__overlay').classList.add("is-visible");
}

const hideOverlay = () => {
    document.querySelector('.body__overlay').classList.remove("is-visible");
}

const getHeight = (element) => {
    return element ? element.offsetHeight : 0;
};
