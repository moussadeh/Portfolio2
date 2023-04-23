const loader = document.querySelector('#loader');
window.addEventListener('load', () => {
    loader.addEventListener('transitionend', () => {    
        loader.classList.add('hidden');
    });
    loader.classList.add('hide');
});