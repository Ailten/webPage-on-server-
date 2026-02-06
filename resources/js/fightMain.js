
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

    menuContend.addEventListener('animationend', _ => {
        menuContend.classList.remove('hidde-opacity');
        eventChange();  // do changes.
        menuContend.addEventListener('animationend', _ => {
            menuContend.classList.remove('show-opacity', 'menu-change-lock');
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
    form.setAttribute('action', DATA_VIEW_TO_JS[name]);
    form.addEventListener('submit', (evnt) => {
        evnt.preventDefault();
        submitFormMenu(evnt.target);
    });
    return form;
}
function fillFormLineButton(labelStr, button, id, eventClick=null) {
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
    if(eventClick !== null)
        input.addEventListener('click', eventClick);
    let pError = inputContainer.appendChild(document.createElement('p'));
    pError.classList.add('input-error', 'hidden-p-error');
    return line;
}
function fillFormLineP(pStr) {
    let line = document.createElement('div');
    line.classList.add('input-line', 'd-flex', 'justify-content-center', 'single-element');
    let p = line.appendChild(document.createElement('p'));
    p.classList.add('p-align-btn', 'text-center', 'w-100');
    p.innerText = pStr;
    return line;
}
function fillFormLineInput(labelStr, inputStr, id, eventChange=null) {
    let line = document.createElement('div');
    line.classList.add('input-line', 'd-flex', 'justify-content-center');
    let label = line.appendChild(document.createElement('label'));
    label.setAttribute('for', id);
    label.classList.add('p-align-btn');
    label.innerText = labelStr;
    let inputContainer = line.appendChild(document.createElement('div'));
    inputContainer.classList.add('input-error-container');
    let input = inputContainer.appendChild(document.createElement('input'));
    input.setAttribute('type', 'text');
    input.setAttribute('name', id);
    input.setAttribute('id', id);
    input.setAttribute('value', inputStr);
    if(eventChange !== null)
        input.addEventListener('change', eventChange);
    let pError = inputContainer.appendChild(document.createElement('p'));
    pError.classList.add('input-error', 'hidden-p-error');
    return line;
}
function fillFormLineSubmit(labelStr, inputStr) {
    let line = fillFormLineButton(labelStr, inputStr, 'submit');
    line.classList.add('submit-line');
    line.getElementsByTagName('input')[0].setAttribute('type', 'submit');
    return line;
}

// fill the menu-contend with form navigation-option.
function openMenuNavigation() {
    let menuContend = document.getElementById('menu-contend');
    let form = fillMenu('navigationOption');
    form.appendChild(fillFormLineButton('retour au site', 'retour', 'back-main-age',
        _ => {
            window.location.href = DATA_VIEW_TO_JS['index'];
        }
    ));
    menuContend.appendChild(form);
}
// fill the menu-contend with form twitch-option.
function openMenuTwitch() {
    let menuContend = document.getElementById('menu-contend');
    let form = fillMenu('twitchOption');
    form.appendChild(fillFormLineP(`compt twitch : ${DATA_VIEW_TO_JS['pseudoTwitch']}`));
    // todo : add an event change to input cmd, for edit color outline when change but not submit.
    form.appendChild(fillFormLineInput(`commande rejoindre : `, cmdTwitch['cmdJoin'], 'cmdJoin',
        (evnt) => {
            let input = evnt.target;
            let isEdited = evnt.target.value !== cmdTwitch['cmdJoin'];
            if(isEdited ^ input.classList.contains('input-edited-not-saved')){
                input.classList.toggle('input-edited-not-saved');
            }
        }
    ));
    form.appendChild(fillFormLineSubmit('confirm : ', 'valider'));
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
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let formEndPointDest = form.getAttribute('action').split('/').findLast(_ => true);

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        // clean 'p-errors'.
        Array.prototype.forEach.call(
            document.querySelectorAll('p.input-error'),
            (p) => {
                p.innerText = '';
                p.classList.remove('hidden-p-error');
            }
        );

        if(data.isSucces){

            // edit let cmdTwitch with new values.
            if(formEndPointDest === 'twitchOption'){
                for(const [key, value] of Object.entries(data.values)){
                    if(key.startsWith('cmd'))
                        cmdTwitch[key] = value;
                }
            }
            // remove all class "input-edited-not-saved".
            Array.prototype.forEach.call(
                document.querySelectorAll('.input-edited-not-saved'),
                (input) => {
                    input.classList.remove('input-edited-not-saved');
                }
            );
            // pop up success confirm.
            setConfirmSubmit('success !');

            return;
        }

        // add new 'p-errors' contend.
        for(const [key, value] of Object.entries(data.errors)){
            //document.
        }

        // pop up error.
        setErrorSubmit('rejeté, champ(s) invalide.');

    })
    .catch(error => {
        console.error('Error :', error);
        // pop up error.
        setErrorSubmit('une erreur server est survenue !');
    });
}

// write an error in p-error of submit button form.
function setErrorSubmit(msg) {
    let pErrorSubmit = document.querySelector('div.submit-line p.input-error');
    pErrorSubmit.innerText = msg;
    pErrorSubmit.classList.remove('hidden-p-error');
}
// write an error in p-error (but in green, and auto-erase it after some secondes).
function setConfirmSubmit(msg) {
    let pErrorSubmit = document.querySelector('div.submit-line p.input-error');
    pErrorSubmit.innerText = msg;
    pErrorSubmit.classList.remove('hidden-p-error');
    pErrorSubmit.classList.add('p-error-set-in-confirm');
    setTimeout(_ => {
        pErrorSubmit.innerText = '';
        pErrorSubmit.classList.add('hidden-p-error');
        pErrorSubmit.classList.remove('p-error-set-in-confirm');
    }, 600);

}