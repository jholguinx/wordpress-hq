/***
 * Scroll on Top for Iframe
 * @type {string}
 */
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
eventer(messageEvent, function (e) {
    if (e.data === 'hq-scroll-to-top' || e.message === "hq-scroll-to-top") {
        window.scroll(0,0);
    }
});