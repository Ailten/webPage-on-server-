
// load page.
window.addEventListener('load', () => {

    // button unfold/fold menu.
    {
        document.getElementById('btn-unfold-menu')?.addEventListener('click', unfoldMenu);
    }

    // buttons fill menu-contend.
    {
        document.getElementById('btn-fight-twitch-option')?.addEventListener('click', _ => {
            closeMenu();
            openMenuTwitch();
        });
    }

});

// ------>

// fold or unfold menu in fight-page.
function unfoldMenu() {
    let btn = document.getElementById('btn-unfold-menu');
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

// clean the menu-contend.
function closeMenu() {
    let menuContend = document.getElementById('menu-contend');
    menuContend.innerHTML = "";
}

// fill the menu-contend with form twitch-option.
function openMenuTwitch() {
    let menuContend = document.getElementById('menu-contend');
    let form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', ACTION_OPTION['twitchOption']);
    route('log.character.createValidate')
    form.addEventListener('submit', (evnt) => {
        evnt.preventDefault();
        submitFormMenu(evnt.target);
    });
    // todo: add inputs and button submit (maybe make function JS for add line inputs).
    menuContend.appendChild(form);
}


// call fetch on an end-point back.
function submitFormMenu(form) {
    let method = form.getAttribute('method');
    let url = form.getAttribute('action');
    let formData = new FormData(form);  // todo: debug console ?.

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Succes :', data);
    })
    .catch(error => {
        console.error('Error :', error);
    });
}