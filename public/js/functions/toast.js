function showToast(type, message) {
    var toast;

    if (type == "success") {
        toast = document.getElementById("success-toast");
        document.getElementById("success-toast-text").innerHTML = message;
    } else if (type == "error") {
        toast = document.getElementById("error-toast");
        document.getElementById("error-toast-text").innerHTML = message;
    }

    toast.classList.remove("hide");
    toast.classList.add("show");

    var closeButton = toast.querySelector(".toast-close");
    closeButton.addEventListener("click", function () {
        toast.classList.remove("show");
        toast.classList.add("hide");
    });

    setTimeout(function () {
        toast.classList.remove("show");
        toast.classList.add("hide");
    }, 5000);
}
