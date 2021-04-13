window.addEventListener("load", function () {
    var link = document.querySelectorAll(".main-link");
    var index = document.querySelector("article").getAttribute("data-index");
    link[index].classList.add("active");
});