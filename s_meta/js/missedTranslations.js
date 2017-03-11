/**
 * Created by Andrei on 10.03.2017.
 */
missedTranslations();

function missedTranslations() {
    var inputsEngListAddEvent = document.querySelectorAll("input[name='angl[]']");
    for (var l = 0; l < inputsEngListAddEvent.length; l++) {
        inputsEngListAddEvent[l].addEventListener("click", missedTranslations);
    }
    ;
    var blocksTranslation = document.getElementsByClassName("blok_perevoda");
    for (var i = 0; i < blocksTranslation.length; i++) {
        var inputsEngList = blocksTranslation[i].querySelectorAll("input[name='angl[]']");
            var f = false;
            for (var j = 0; j < inputsEngList.length; j++) {
                if (inputsEngList[j].checked == true) {
                    blocksTranslation[i].style.backgroundColor = "";
                    f = true;
                    break;
                }
                ;
            }
            ;
            if (f == false) {
                blocksTranslation[i].style.backgroundColor = "#FFEEEE";
            }
            ;
    }
    ;
};