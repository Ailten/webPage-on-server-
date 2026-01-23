import 'bootstrap';

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// load page.
window.addEventListener('load', () => {

    let typePage = document.body.classList.values().find(c => c.endsWith('-page')) ?? 'default';

    // eval size screen.
    evalSizeScreen();

    // set margin-top/bottom and height to center-page (prevent overlap to header/footer and footer position).
    if(typePage === 'default') {
        let centerPage = document.getElementById("center-page");

        // margin-top for header overlap.
        let headerHeight = document.getElementsByTagName("header")[0].offsetHeight;
        centerPage.style.marginTop = `${headerHeight}px`;

        // height for footer position.
        let footerHeight = document.getElementsByTagName("footer")[0].offsetHeight;
        let centerPageHeight = centerPage.getBoundingClientRect().height;
        let centerPagePosBottom = headerHeight + centerPageHeight;
        let posUpFooterTheoric = window.innerHeight - footerHeight;
        if(centerPagePosBottom < posUpFooterTheoric){
            // height for footer position.
            let centerPageHeightNeed = window.innerHeight - (headerHeight + footerHeight);
            centerPage.style.height = `${centerPageHeightNeed}px`;
        }
    }

    // set link data-href.
    {
        Array.prototype.forEach.call(
            document.querySelectorAll("*[data-href]"),
            hrefDom => {
                hrefDom.addEventListener("click", (evnt) => {
                    eventDataHrefClick(evnt.target);
                });
            }
        );
    }

    // button x (close error pop-up).
    {
        Array.prototype.forEach.call(
            document.getElementsByClassName("btn-x"),
            btnX => {
                btnX.addEventListener('click', (evnt) => {
                    eventBtnXClick(evnt.target);
                });
            }
        );
    }

    // button radio (character_spacie).
    {
        Array.prototype.forEach.call(
            document.querySelectorAll("input[type=radio]"),
            radio => {
                let divContainer = radio;
                do{
                    divContainer = divContainer.parentNode;
                }while(!divContainer.classList.contains('radio-container'));

                divContainer.addEventListener('click', (evnt) => {
                    radio.click();
                });
            }
        );
    }

});


// event resize.
window.addEventListener("resize", () => {

    // eval size screen.
    evalSizeScreen();

});


// ------ functions.


// set attribute "type-size-screen" based on width window.
function evalSizeScreen(){
    let windowWidth = window.innerWidth;
    let typeSizeScreen = (
        (windowWidth > 768)? "PC":
        (windowWidth > 600)? "Tablette":
        "Mobile"
    );
    document.body.setAttribute("data-type-size-screen", typeSizeScreen);
}

// function confirmPopUp : create a pop-up confirm and redirect url when valid confirm.
function confirmPopUp(msg, url){

    // create a pop-up confirm custom.
    let popUp = document.createElement('div');
    popUp.classList.add('pop-up-error', 'pop-up-container', 'pop-up-error-back-gradient');
    let xBtn = popUp.appendChild(document.createElement('p'));
    xBtn.innerText = 'x';
    xBtn.classList.add('btn-x');
    xBtn.addEventListener('click', (evnt) => {
        eventBtnXClick(evnt.target);
    })
    let msgContainer = popUp.appendChild(document.createElement('div'));
    msg.split('\n').forEach((line) => {
        let p = msgContainer.appendChild(document.createElement('p'));
        p.classList.add('text-center');
        p.innerText = line;
    });
    msgContainer.style.width = 'fit-content';
    popUp.style.width = 'fit-content';
    let inputContainer = popUp.appendChild(document.createElement('div'));
    inputContainer.classList.add('input-line', 'submit-line', 'd-flex', 'justify-content-center');
    let cancelBtn = inputContainer.appendChild(document.createElement('input'));
    cancelBtn.setAttribute('type', 'button');
    cancelBtn.setAttribute('value', 'Annuler');
    cancelBtn.classList.add('btn', 'btn-create', 'btn-x', 'btn-supr');
    cancelBtn.style.position = 'initial';
    cancelBtn.addEventListener('click', (evnt) => {
        eventBtnXClick(evnt.target);
    })
    let validBtn = inputContainer.appendChild(document.createElement('input'));
    validBtn.setAttribute('type', 'button');
    validBtn.setAttribute('value', 'Confirmer');
    validBtn.setAttribute('data-href', url);
    validBtn.classList.add('btn', 'btn-create', 'btn-supr');
    validBtn.addEventListener('click', (evnt) => {
        eventDataHrefClick(evnt.target);
    })
    document.body.appendChild(popUp);

    // center page.
    let spaceLeft = (window.innerWidth - popUp.getBoundingClientRect().width) / 2;
    popUp.style.left = `${spaceLeft}px`;
    let spaceUp = (window.innerHeight - popUp.getBoundingClientRect().height) / 2;
    popUp.style.top = `${spaceUp}px`;

}

function eventBtnXClick(btnX) {
    let popUpToClose = btnX;
    do{
        popUpToClose = popUpToClose.parentNode;
    }while(!popUpToClose.classList.contains('pop-up-container'));

    popUpToClose.parentNode.removeChild(popUpToClose);
}

function eventDataHrefClick(btnHref) {

    let href = btnHref.getAttribute("data-href");
    if(href === null)
        return;
    if(btnHref.classList.contains("disabled-href"))  // not used.
        return;
    
    let isConfirm = btnHref.classList.contains('href-confirm');
    if(isConfirm){
        confirmPopUp(
            'Attention !\n'+
            'L\'action que vous voulez réaliser est irévercible !\n'+
            'Etes vous sur de vouloir continuer ?',
            href
        );
        return;
    }

    let ahref = document.createElement("a");
    ahref.setAttribute("href", href);
    ahref.click();
}