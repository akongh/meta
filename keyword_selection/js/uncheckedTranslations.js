let inputsEngListAddEvent = document.querySelectorAll("input[name='angl[]']");

for (let l = 0; l < inputsEngListAddEvent.length; l++) {
    inputsEngListAddEvent[l].addEventListener("click", missedTranslations);
}

missedTranslations();

function missedTranslations() {
    let blocksTranslation = document.getElementsByClassName("block_translated");
    for (let i = 0; i < blocksTranslation.length; i++) {
        let inputsEngList = blocksTranslation[i].querySelectorAll("input[name='angl[]']");
        let f = false;
        for (let j = 0; j < inputsEngList.length; j++) {
            if (true === inputsEngList[j].checked) {
                blocksTranslation[i].style.backgroundColor = "";
                f = true;
                break;
            }

        }

        if (false === f) {
            blocksTranslation[i].style.backgroundColor = "#dddddd";
        }
    }
}
