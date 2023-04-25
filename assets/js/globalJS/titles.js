const titles = document.querySelectorAll('.js-title-move');
window.addEventListener('scroll', () => {
    titles.forEach(title => {
        isShow(title);
        // console.log(title);
    });
    // isShow(titles);
});

const isShow = (title) => {
    const titleHeight = title.offsetHeight;
    const titleTop = title.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;
    const windowMiddle = windowHeight * 0.75;
    // console.log(titleTop);
    // console.log(windowMiddle);
    if (titleTop < windowMiddle) {
        title.classList.add('title-is-show');
    } else {
        title.classList.remove('title-is-show');
    }
}




