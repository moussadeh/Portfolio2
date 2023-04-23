const loader = document.querySelector('#loader');

const awaitLoading = document.querySelectorAll('.await-loading');
window.addEventListener('load', () => {
    loader.addEventListener('transitionend', () => {    
        loader.classList.add('hidden');
    });
    loader.classList.add('hide');

    setTimeout(() => {
        awaitLoading.forEach(element => {
            element.classList.remove('await-loading');
            element.classList.add('is-loaded');
        });
    }, 150);
    
});
//# sourceMappingURL=loader.js.map