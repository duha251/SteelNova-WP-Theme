export const ready = (callback) => {
    if (document.readyState !== "loading") {
        callback();
    } else {
        document.addEventListener("DOMContentLoaded", callback, { once: true });
    }
};

export const onLoad = (callback) => {
    if (document.readyState === "complete") {
        callback();
    } else {
        window.addEventListener("load", callback, { once: true });
    }
};

export const onResize = (callback) => {
    window.addEventListener("resize", callback);
}

export const $$ = (selector, scope = document) => {
    return Array.from(scope.querySelectorAll(selector));
};

export const $ = (selector, scope = document) => {
    return scope.querySelector(selector);
};

export const markInit = (element, key = "initialized") => {
    if (!element) return false;
    if (element.dataset[key] === "true") return false;
    element.dataset[key] = "true";
    return true;
};

export const unmarkInit = (element, key = "initialized") => {
    if (!element) return;
    delete element.dataset[key];
};

export const getOuterHeight = (element, includeMargin = true) => {
  if (!(element instanceof HTMLElement)) {
    return 0;
  }

  const height = element.offsetHeight;

  if (!includeMargin) {
    return height;
  }

  const styles = window.getComputedStyle(element);
  const marginTop = parseFloat(styles.marginTop) || 0;
  const marginBottom = parseFloat(styles.marginBottom) || 0;

  return height + marginTop + marginBottom;
}