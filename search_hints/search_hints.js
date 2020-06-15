let getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
let clearButton = document.querySelector("#clear-button");


getBasicKeywordsButtonShutterstock.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListShutterstock("from_shutterstock.php");
}, false);
clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearQuery();
}, false);


/**
 * Functions.
 */

function sendQueryGetHintsCreateHTMLHintsListShutterstock(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();
    let mediaType = document.querySelector("input[name='media_type_shutterstock']:checked").value;
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let requestSet = mediaType + "\n" + basicKeywordsString;

    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Слишком длинное опорное слово.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else {

                window.hintsObjectsArray = JSON.parse(request.responseText);

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.send(requestSet);
}

function createHTMLHintsList(PARAM_hintsObjectsArray) {
    let listResultArray = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArray[i] = "<div class='hint-box'><span class='hover-invert'>" +
            PARAM_hintsObjectsArray[i]["pattern"] +
            "</span> — " +
            PARAM_hintsObjectsArray[i]["probability"] +
            "</div>";
    }

    document.querySelector("#hints-area").innerHTML = listResultArray.join("");

    let hintKeywords = document.querySelectorAll(".hover-invert");

    for (let i = 0; i < hintKeywords.length; i++) {
        hintKeywords[i].addEventListener("click", function (e) {
            e.stopPropagation();
        }, false);
        hintKeywords[i].addEventListener("click", keywordwPatternToQuery);
    }
}

function clearQuery() {
    document.getElementById("basic_keywords_string").value = "";
}

function disableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = true;
    getBasicKeywordsButtonShutterstock.value = "";
    getBasicKeywordsButtonShutterstock.style.background = "#dddddd";
    getBasicKeywordsButtonShutterstock.style.cursor = "default";
}

function enableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = false;
    getBasicKeywordsButtonShutterstock.value = "От Шаттерстока";
    getBasicKeywordsButtonShutterstock.style.background = "";
    getBasicKeywordsButtonShutterstock.style.cursor = "";
}

function clearErrors() {
    document.querySelector("#error-hints").innerHTML = "";
}

function keywordwPatternToQuery() {
    document.querySelector("#basic_keywords_string").value = this.innerHTML.replace('&amp;', '&');
}
