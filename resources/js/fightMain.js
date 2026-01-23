import 'bootstrap';

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// load page.
window.addEventListener('load', () => {

    // button unfold/fold menu.
    {
        document.querySelector('.btn-unfold-menu').addEventListener('click', unfoldMenu);
    }

});

// ------>

// fold or unfold menu in fight-page.
function unfoldMenu() {
    let btn = document.querySelector('.btn-unfold-menu');
    let menu = document.querySelector('.menu');
    let isUnfoldAction = !menu.classList.contains('menu-unfold');
    if(isUnfoldAction) {
        menu.classList.remove('menu-fold');
        void menu.offsetWidth;
        menu.classList.add('menu-unfold');
        btn.setAttribute('value', 'menu >');
    } else {
        menu.classList.remove('menu-unfold');
        void menu.offsetWidth;
        menu.classList.add('menu-fold');
        btn.setAttribute('value', '< menu');
    }
    void menu.offsetWidth;
}