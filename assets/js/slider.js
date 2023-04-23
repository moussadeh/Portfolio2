const project = new Splide('#project-slider', {
    // type   : 'loop',
    // perPage: 3,
    autoWidth: true,
    autoHeight: true,
    // heightRatio: 0.5,
    autoplay: true,
    gap: '2rem',
    arrows:false,
    pauseOnHover: true,
    pagination: false,
    isNavigation: true,
    drag: true,
});
project.mount();
console.log('test');