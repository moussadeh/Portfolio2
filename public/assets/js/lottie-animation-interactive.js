const changeColor = (lottie) => {
    let element = lottie.shadowRoot;
    let paths = element.querySelectorAll('svg path');
    paths.forEach(path => {
        path.removeAttribute('fill');
    });
}
const playAnimation = (lottie) => {
    lottie.play();
}

const stopAnimation = (lottie) => {
    lottie.stop();
}
icons = document.querySelectorAll('.js-lottie-interactive');
icons.forEach(icon => {
    let lottie = icon.querySelector('.js-lottie-icon');
    icon.addEventListener('mouseenter',()=> {
        playAnimation(lottie);
    });
    icon.addEventListener('focus',()=> {
        playAnimation(lottie);
    });
    icon.addEventListener('mouseleave', ()=> {
        stopAnimation(lottie);
    });
    icon.addEventListener('blur', ()=> {
        stopAnimation(lottie);
    });

    // when loaded
    lottie.addEventListener('ready', ()=> {
        changeColor(lottie);
    });
});

//# sourceMappingURL=lottie-animation-interactive.js.map
