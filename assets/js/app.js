import { ready, onLoad, onResize } from "./core/dom.js";
import { debounce, raf } from "./core/utils.js";

import { initDrawer } from "./components/drawer.js";

import { setMainMinHeight } from "./components/layout.js";

const initApp = (scope = document) => {
    setMainMinHeight();
};


const refreshApp = (scope = document) => {
    raf(() => {
        setMainMinHeight();
    });
};

ready(() => {
    initApp(document);
    initDrawer();
});

onLoad(() => {
    refreshApp(document);
});


onResize(() => {    
    debounce(() => { 
        refreshApp(document);
    }, 150)
});