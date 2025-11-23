
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

    // loop every input file remap.
    Array.prototype.forEach.call(
        document.getElementsByClassName("input-file-remap"),
        inputFileRemap => {

            // get file input in child.
            let inputFile = inputFileRemap.querySelector("input[type=file]");
            let text = inputFileRemap.getElementsByClassName("input-file-remap-text")[0];

            // set default text.
            text.innerText = text.getAttribute("placeholder") || "Parcourir...";

            // remap click event.
            inputFileRemap.addEventListener("click", () => {
                inputFile.click();
            });
            inputFileRemap.addEventListener("change", () => {
                text.innerText = Array.from(inputFile.files || text.getAttribute("placeholder") || "Parcourir...")
                    .map((f) => f.name).join(", ");
            });

            // prevent to open the file drag on a new tab.
            inputFileRemap.addEventListener("dragover", (e) => {
                e.preventDefault();
            }, false);
            
            // add class to style drag.
            inputFileRemap.addEventListener("dragenter", () => {
                let dragCount = inputFileRemap.getAttribute("drag-count") || 0;
                dragCount = Number(dragCount);
                dragCount += 1;
                if(dragCount === 1){
                    inputFileRemap.classList.add("input-file-drag");
                }
                inputFileRemap.setAttribute("drag-count", dragCount);
            });
            
            // remove class to style drag.
            inputFileRemap.addEventListener("dragleave", () => {
                let dragCount = inputFileRemap.getAttribute("drag-count") || 0;
                dragCount = Number(dragCount);
                dragCount -= 1;
                if(dragCount === 0){
                    inputFileRemap.removeAttribute("drag-count");
                    return;
                }
                inputFileRemap.setAttribute("drag-count", dragCount);
            });
            
            // send files drop to input.
            inputFileRemap.addEventListener("drop", (e) => {
                e.preventDefault();
                inputFile.files = e.dataTransfer.files;
                text.innerText = Array.from(e.dataTransfer.files || text.getAttribute("placeholder") || "Parcourir...")
                    .map((f) => f.name).join(", ");
                inputFileRemap.removeAttribute("drag-count");
            });

        }
    );


    // combobox implement.
    Array.prototype.forEach.call(
        document.getElementsByClassName("combobox-container"),
        comboboxContainer => {

            let inputCombobox = comboboxContainer.querySelector("input[type=combobox]");
            let ul = comboboxContainer.querySelector("ul");
            let inputHidden = comboboxContainer.querySelector("input[type=hidden]");
            
            // verify if somthing wrong.
            if(inputCombobox === null)
                throw new Error("combobox-container has no input combobox");
            if(ul === null)
                throw new Error("combobox-container has no ul");

            // set default css ul.
            ul.style.display = "none";
            ul.style.minWidth = inputCombobox.offsetWidth + "px";

            inputCombobox.addEventListener("keyup", (e) => {

                // switch input validity.
                inputCombobox.setAttribute("invalid", "");
                inputCombobox.removeAttribute("valid");
                if(inputHidden !== null){
                    inputHidden.setAttribute("invalid", "");
                    inputHidden.removeAttribute("valid");
                }

                let value = e.target.value.trim();
                let minKeySearch = Number(inputCombobox.getAttribute("min-key-search") || 3);

                // hidde the whole pool.
                if(value.length < minKeySearch){
                    ul.style.display = "none";
                    return;
                }
                ul.style.display = "";
                
                // show only li match the filter.
                Array.prototype.forEach.call(
                    ul.getElementsByTagName("li"),
                    li => {
                        let liText = li.innerText.trim();
                        let isInclude = liText.includes(value);
                        li.style.display = (isInclude ? "": "none");
                    }
                );

            });

            // set event click on li.
            Array.prototype.forEach.call(
                ul.getElementsByTagName("li"),
                li => {

                    li.style.display = "none";
                    
                    li.addEventListener("click", (e) => {

                        // switch input validity.
                        inputCombobox.setAttribute("valid", "");
                        inputCombobox.removeAttribute("invalid");
                        if(inputHidden !== null){
                            inputHidden.setAttribute("valid", "");
                            inputHidden.removeAttribute("invalid");
                        }

                        // un-show the ul.
                        ul.style.display = "none";

                        // set input combobox value.
                        inputCombobox.value = li.innerText.trim();

                        // set input hidden id value (facultatif).
                        if(inputHidden !== null && li.hasAttribute("combobox-id")){
                            inputHidden.value = li.getAttribute("combobox-id");
                        }
                    });

                }
            );
        }
    );


});