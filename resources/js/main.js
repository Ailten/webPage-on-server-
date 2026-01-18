import 'bootstrap';

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// load page.
window.addEventListener('load', () => {

    // eval size screen.
    evalSizeScreen();

    // set margin-top/bottom and height to center-page (prevent overlap to header/footer and footer position).
    {
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

                hrefDom.addEventListener("click", (e) => {

                    let dom = e.target;
                    let href = dom.getAttribute("data-href");
                    if(href === null)
                        return;
                    if(dom.classList.contains("disabled-href"))  // not used.
                        return;
                    
                    let isConfirm = dom.classList.contains('href-confirm');
                    if(isConfirm){
                        isConfirm = confirm(  // todo: overide confirm function with bootstrap.
                            'Attention !\n'+
                            'L\'action que vous voulez réaliser est irévercible !\n'+
                            'Etes vous sur de vouloir continuer ?'
                        );
                        if(isConfirm === false)
                            return;
                    }

                    let ahref = document.createElement("a");
                    ahref.setAttribute("href", href);
                    ahref.click();
    
                });

            }
        );
    }

    // button x (close error pop-up).
    {
        Array.prototype.forEach.call(
            document.getElementsByClassName("btn-x"),
            btnX => {
                let popUpToClose = btnX;
                do{
                    popUpToClose = popUpToClose.parentNode;
                }while(!popUpToClose.classList.contains('pop-up-container'));

                btnX.addEventListener('click', (evnt) => {
                    popUpToClose.parentNode.removeChild(popUpToClose);
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

// overide confirm function.
let confirm_base = confirm;
confirm = function(msg, url=null){
    if(url===null){  // do basic confirm.
        return confirm_base(msg);
    }

    // create a pop-up confirm custom.
    let popUp = document.createElement('div');
    popUp.classList.add('pop-up', 'pop-up-container');
    let xBtn = popUp.appendChild(document.createElement('p'));
    xBtn.innerText = 'x';
    xBtn.classList.add('btn-x');
    let msgContainer = popUp.appendChild(document.createElement('div'));
    msg.split('\n').forEach((line) => {
        let p = msgContainer.appendChild('p');
        p.innerText = line;
    });
    let inputContainer = popUp.appendChild(document.createElement('div'));
    inputContainer.classList.add('input-line');  //submit-line d-flex justify-content-center
    let cancelBtn = inputContainer.appendChild(document.createElement('input'));
    cancelBtn.setAttribute('type', 'button');
    cancelBtn.setAttribute('value', 'Annuler');
    cancelBtn.classList.add('btn', 'btn-create', 'btn-x');
    let validBtn = inputContainer.appendChild(document.createElement('input'));
    validBtn.setAttribute('type', 'button');
    validBtn.setAttribute('value', 'Confirmer');
    validBtn.setAttribute('data-href', url);
    validBtn.classList.add('btn', 'btn-create');
    document.body.appendChild(popUp);

}