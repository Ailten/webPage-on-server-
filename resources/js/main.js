import './bootstrap';


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
            document.querySelectorAll("header menu ul li"),
            li => {

                li.addEventListener("click", (e) => {

                    let href = li.getAttribute("href");
                    if(href === null)
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
    document.body.setAttribute("type-size-screen", typeSizeScreen);
}