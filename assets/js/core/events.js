export const delegate = (parent, eventType, selector, handler) => {
    parent.addEventListener(eventType, (event) => {
        const target = event.target.closest(selector);
        if (!target || !parent.contains(target)) return;
        handler(event, target);
    });
};