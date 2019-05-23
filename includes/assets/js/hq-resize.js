iFrameResize({
    log: false,
    checkOrigin: false,
    maxWidth: screen.width,
    sizeWidth: true,
    onResized: function(message) {
        var height = document.getElementById('hq-rental-iframe').clientHeight;
        var newheight = height * 1.1;
        document.getElementById("hq-rental-iframe").style.height = newheight + "px";
    }
}, '#hq-rental-iframe');
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
/*
*  Redirect Safari Browser
* */
redirectInSafariBrowser();

function redirectInSafariBrowser(){
    if(hqSafariData.isSafari === '1'){
        window.open(hqSafariData.urlRedirect);
        return false;
    }
}
