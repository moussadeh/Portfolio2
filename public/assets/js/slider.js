const project = new Splide('#project-slider', {
    // type   : 'loop',
    // perPage: 1,
    autoWidth: true,
    autoHeight: true,
    // heightRatio: 0.5,
    autoplay: false,
    gap: '2rem',
    arrows:false,
    pauseOnHover: true,
    pagination: true,
    isNavigation: false,
    updateOnMove: true,
    drag: true,
    mediaQuery: 'min',
    slideFocus: true,
    lazyLoad: 'nearby',
    breakpoints: {
        768: {
            // pagination:false,
            isNavigation: true,
            // arrows:true,
            // drag: true,
        },
    }
});
project.mount();
// console.log('test');
//# sourceMappingURL=slider.js.map