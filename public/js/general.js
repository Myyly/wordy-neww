$(document).ready(function () {
    let message = $("#success-message");
    if (message.length) {
        setTimeout(function () {
            message.fadeOut(500);
        }, 1000);
    }
});
