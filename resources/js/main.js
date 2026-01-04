import 'bootstrap';

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