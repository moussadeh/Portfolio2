// not_empty
const classNotEmpty = 'not_empty';
const fields = document.querySelectorAll('.field__input, .field__textarea');
fields.forEach(field => {
    // console.log(field);
    field.addEventListener('keydown', (e) => {
        if (e.target.value != '') {
            e.target.classList.add(classNotEmpty);
        } else {
            e.target.classList.remove(classNotEmpty);
        }
    });
});

// const foo = new Foo();
// foo.log("Hello World"); // Prints "Hello World" to the console.
const header = document.querySelector(".header");

window.onscroll = function() {toggleBgHeader()};

const toggleBgHeader = () => {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        header.classList.add("show");
    } else {
        header.classList.remove("show");
    }
}
tabs = document.querySelectorAll('[ role="tab"]');
tablists = document.querySelectorAll('[ role="tablist"]');
tablists.forEach(tablist => {
    tabs = tablist.querySelectorAll('[ role="tab"]');
    tabs.forEach(tabElement => {
        tabElement.addEventListener("click", (e)=> {
            e.preventDefault();
            toggleTabs(tabs, tabElement);
        });
        tabElement.addEventListener("focus", ()=> {
            toggleTabs(tabs, tabElement);
        });
    });
});
const toggleTabs= (tabs, activeElement) =>{
    tabs.forEach(tabElement => {
        // element = tabElement.getAttribute('aria-controls');
        console.log(tabElement.getAttribute('aria-controls'));
        element = document.querySelector("#"+tabElement.getAttribute('aria-controls'));
        if (tabElement == activeElement) {
            tabElement.setAttribute('aria-selected', 'true');
            element.classList.remove('hidden');
        }else{
            tabElement.setAttribute('aria-selected', 'false');
            element.classList.add('hidden');
        }
        // element.getAttribute('id');
    });
}
// console.log('efee');
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




//# sourceMappingURL=global.js.map
