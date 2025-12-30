import 'bootstrap';

// load page.
window.addEventListener('load', () => {

    // eval size screen.
    evalSizeScreen();

    // set margin-top to center-page (prevent overlap to header).
    {
        let headerHeight = document.getElementsByTagName("header")[0].offsetHeight;
        document.getElementById("center-page").style.marginTop = `${headerHeight}px`;
    }

    // set link on menu header.
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
                    let ahref = document.createElement("a");
                    ahref.setAttribute("href", href);
                    ahref.click();
    
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