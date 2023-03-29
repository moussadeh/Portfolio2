const header = document.querySelector(".header");

window.onscroll = function() {toggleBgHeader()};

const toggleBgHeader = () => {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        header.classList.add("show");
    } else {
        header.classList.remove("show");
    }
}