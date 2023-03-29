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
        tabElement.addEventListener("click", ()=> {
            // console.log("Bonjour");
            toggleTabs(tabs, tabElement);
        });
        tabElement.addEventListener("focus", ()=> {
            // console.log("Bonjour");
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
//# sourceMappingURL=global.js.map