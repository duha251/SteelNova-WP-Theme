export const debounce = (fn, delay = 150) => {
    let timer = null;

    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
};

export const throttle = (fn, limit = 100) => {
    let inThrottle = false;

    return function (...args) {
        if (inThrottle) return;

        fn.apply(this, args);
        inThrottle = true;

        setTimeout(() => {
            inThrottle = false;
        }, limit);
    };
};

export const raf = (callback) => {
    return requestAnimationFrame(callback);
};