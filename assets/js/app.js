import * as Layout from "./ui/layout.js";
import * as Events from "./ui/events.js";
import * as Effects from "./ui/effects.js";

document.addEventListener('DOMContentLoaded', function () {
    Layout.setMainMinHeight();
    Events.toggleDrawer();
});


// let ready = (callback) => {
//   if (document.readyState != "loading") callback();
//   else document.addEventListener("DOMContentLoaded", callback);
// }

// ready(() => { 
//   /* Làm gì đó khi DOM đã được tải hết */
// });