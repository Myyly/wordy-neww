
$("#checkAllBtn").click(function () {
    $(".definition-col").toggle(); 
    $(".definition-header").toggle();
});

$(document).ready(function () {
    let message = $("#success-message");
    if (message.length) {
        setTimeout(function () {
            message.fadeOut(500); // Ẩn dần trong 0.5 giây
        }, 1000); // 3 giây
    }
});
