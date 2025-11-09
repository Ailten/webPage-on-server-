
// load page.
window.addEventListener('load', () => {

    // loop every checkbox-mark.
    Array.prototype.forEach.call(
        document.getElementsByClassName("checkbox-mark"),
        checkboxMark => {

            // get input associate.
            let input = checkboxMark.previousElementSibling;
            if(input.tagName !== "INPUT")
                input = checkboxMark.nextElementSibling;
            if(input.tagName !== "INPUT")
                throw new Error("checkbox-mark has no input");
            if(!input.hasAttribute("type") || (input.getAttribute("type") !== "checkbox" && input.getAttribute("type") !== "radio"))
                throw new Error("checkbox-mark input is not checkbox");

            // checked by default.
            if(input.checked)
                checkboxMark.setAttribute("checked", "checked");
        
            // event click.
            checkboxMark.addEventListener("click", (evt) => {

                // switch checked.
                let isChecked = checkboxMark.hasAttribute("checked");
                if(isChecked && input.getAttribute("type") !== "radio")
                    checkboxMark.removeAttribute("checked")
                else
                    checkboxMark.setAttribute("checked", "checked");

                // un-check when is radio.
                if(input.getAttribute("type") === "radio"){
                    let radioName = input.getAttribute("name");
                    Array.prototype.forEach.call(
                        document.querySelectorAll(`.checkbox-mark[name=${radioName}]`),
                        (checkboxMarkMatchName) => {
                            if(checkboxMarkMatchName !== checkboxMark && checkboxMarkMatchName.hasAttribute("checked")){
                                checkboxMarkMatchName.removeAttribute("checked");
                            }
                        }
                    );
                }

                // call event input.
                input.click();
                
            });
        }
    )

});