// hien thi mat khau
function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

$("#checkAllBtn").click(function () {
    $(".definition-col").toggle(); 
    $(".definition-header").toggle();
});

// $(document).ready(function () {
//     let message = $("#success-message");
//     if (message.length) {
//         setTimeout(function () {
//             message.fadeOut(500);
//         }, 1000);
//     }
// });