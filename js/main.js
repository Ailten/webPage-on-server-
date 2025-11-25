
// load page.
window.addEventListener('load', () => {

    // eval size screen.
    {
        let windowWidth = window.innerWidth;
        let typeSizeScreen = (
            (windowWidth > 768)? "PC":
            (windowWidth > 600)? "Tablette":
            "Mobile"
        );
        document.body.setAttribute("type-size-screen", typeSizeScreen);
    }

    // set margin-top to center-page (prevent overlap to header).
    {
        let headerHeight = document.getElementsByTagName("header")[0].offsetHeight;
        document.getElementById("center-page").style.marginTop = `${headerHeight}px`;
    }

});