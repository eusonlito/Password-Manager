window.byQuery = (selector, fallback) => document.querySelector(selector) || fallback;
window.byId = (id, fallback) => document.getElementById(id) || fallback;