
// load page.
window.addEventListener('load', () => {

    // loop every input checkbox-mark.
    Array.prototype.forEach.call(
        document.getElementsByClassName("checkbox-mark"),
        checkboxMark => {

            // get input associate.
            let input = checkboxMark.previousElementSibling;
            if(input.tagName !== "INPUT")
                throw new Error("checkbox-mark has no input");
            if(!input.hasAttribute("type") || (input.getAttribute("type") !== "checkbox" && input.getAttribute("type") !== "radio"))
                throw new Error("checkbox-mark input is not checkbox or mark");

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
    );


    // loop every input file.
    Array.prototype.forEach.call(
        document.querySelectorAll("input[type=file]"),
        inputFile => {

            // prevent to open the file drag on a new tab.
            inputFile.addEventListener("dragover", (e) => {
                e.preventDefault();
            }, false);
            
            // add class to style drag.
            inputFile.addEventListener("dragenter", () => {
                let dragCount = inputFile.getAttribute("drag-count") || 0;
                dragCount = Number(dragCount);
                dragCount += 1;
                if(dragCount === 1){
                    inputFile.classList.add("input-file-drag");
                }
                inputFile.setAttribute("drag-count", dragCount);
            });
            
            // remove class to style drag.
            inputFile.addEventListener("dragleave", (e) => {
                let dragCount = inputFile.getAttribute("drag-count") || 0;
                dragCount = Number(dragCount);
                dragCount -= 1;
                if(dragCount === 0){
                    inputFile.removeAttribute("drag-count");
                    return;
                }
                inputFile.setAttribute("drag-count", dragCount);
            });
            
            // send files drop to input.
            inputFile.addEventListener("drop", (e) => {
                e.preventDefault();
                inputFile.files = e.dataTransfer.files;
                inputFile.removeAttribute("drag-count");
            });

        }
    );

});