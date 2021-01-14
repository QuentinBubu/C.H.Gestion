let cross = document.querySelectorAll(".cross");

cross.forEach((element) => {
    element.addEventListener("click", function () {
        window.location = window.location.href.split("?")[0];
    });
});
