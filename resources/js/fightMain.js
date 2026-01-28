
// load page.
window.addEventListener('load', () => {

    // button unfold/fold menu.
    {
        document.getElementById('btn-unfold-menu')?.addEventListener('click', unfoldMenu);
    }

    // buttons fill menu-contend.
    {
        document.getElementById('btn-fight-navigation-option')?.addEventListener('click', _ => {
            switchMenu(_ => {
                closeMenu();
                openMenuNavigation();
            });
        });
        document.getElementById('btn-fight-twitch-option')?.addEventListener('click', _ => {
            switchMenu(_ => {
                closeMenu();
                openMenuTwitch();
            });
        });
        document.getElementById('btn-fight-character-option')?.addEventListener('click', _ => {
            switchMenu(_ => {
                closeMenu();
                openMenuCharacter();
            });
        });
        document.getElementById('btn-fight-mob-option')?.addEventListener('click', _ => {
            switchMenu(_ => {
                closeMenu();
                openMenuMob();
            });
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

    // set margin-top on menu-contend based on current header height.
    {
        let menuHeight = document.getElementsByTagName('header')[0].getBoundingClientRect().height;
        document.getElementById('menu-contend').style.marginTop = `${menuHeight}px`;
    }
}

// clean the menu-contend.
function closeMenu() {
    let menuContend = document.getElementById('menu-contend');
    menuContend.innerHTML = "";
}

// switch to one menu to another (animated).
function switchMenu(eventChange) {
    let menuContend = document.getElementById('menu-contend');

    if(menuContend.classList.contains('menu-change-lock'))
        return;
    menuContend.classList.add('menu-change-lock');  // lock.

    console.log('A');
    menuContend.addEventListener('animationend', _ => {
        console.log('B');
        menuContend.classList.remove('hidde-opacity');
        eventChange();  // do changes.
        menuContend.addEventListener('animationend', _ => {
            console.log('C');
            menuContend.classList.remove('show-opacity');
            menuContend.classList.remove('menu-change-lock');
        }, { once: true });
        void menuContend.offsetWidth;
        menuContend.classList.add('show-opacity');
    }, { once: true });
    void menuContend.offsetWidth;
    menuContend.classList.add('hidde-opacity');
}

// fill menu DOM html.
function fillMenu(name, isPreventSubmut=true) {
    let form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', ACTION_OPTION[name]);
    form.addEventListener('submit', (evnt) => {
        evnt.preventDefault();
        submitFormMenu(evnt.target);
    });
    return form;
}
function fillFormLineButton(labelStr, button, id, eventClick) {
    let line = document.createElement('div');
    line.classList.add('input-line', 'd-flex', 'justify-content-center');
    let label = line.appendChild(document.createElement('label'));
    label.setAttribute('for', id);
    label.classList.add('p-align-btn');
    label.innerText = labelStr;
    let inputContainer = line.appendChild(document.createElement('div'));
    inputContainer.classList.add('input-error-container');
    let input = inputContainer.appendChild(document.createElement('input'));
    input.setAttribute('type', 'button');
    input.setAttribute('name', id);
    input.setAttribute('id', id);
    input.setAttribute('value', button);
    input.classList.add('btn', 'btn-create');
    input.addEventListener('click', eventClick);
    let pError = inputContainer.appendChild(document.createElement('p'));
    pError.classList.add('input-error', 'hidden-p-error');
    return line;
}

// fill the menu-contend with form navigation-option.
function openMenuNavigation() {
    let menuContend = document.getElementById('menu-contend');
    let form = fillMenu('navigationOption');
    form.appendChild(fillFormLineButton('retour au site', 'retour', 'back-main-age',
        _ => {
            window.location.href = ACTION_OPTION['index'];
        }
    ));
    menuContend.appendChild(form);
}
// fill the menu-contend with form twitch-option.
function openMenuTwitch() {
    let menuContend = document.getElementById('menu-contend');
    let form = fillMenu('twitchOption');
    // todo: add inputs and button submit (maybe make function JS for add line inputs).
    menuContend.appendChild(form);
}
// fill the menu-contend with form character-option.
function openMenuCharacter() {
    let menuContend = document.getElementById('menu-contend');
    let form = fillMenu('characterOption');
    // todo: add inputs and button submit (maybe make function JS for add line inputs).
    menuContend.appendChild(form);
}
// fill the menu-contend with form mob-option.
function openMenuMob() {
    let menuContend = document.getElementById('menu-contend');
    let form = fillMenu('mobOption');
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