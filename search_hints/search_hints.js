let getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
let getBasicKeywordsButtonYoutube = document.querySelector("#get-basic-keywords-button-youtube");
let clearButtonBasic = document.querySelector("#clear-button-basic");
let clearButtonExcluded = document.querySelector("#clear-button-excluded");


getBasicKeywordsButtonShutterstock.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListShutterstock("from_shutterstock.php");
}, false);
getBasicKeywordsButtonYoutube.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListYoutube("from_youtube.php");
}, false);
clearButtonBasic.addEventListener("click", function (e) {
    e.preventDefault();
    clearQueryBasic();
}, false);
clearButtonExcluded.addEventListener("click", function (e) {
    e.preventDefault();
    clearQueryExcluded();
}, false);


/**
 * Functions.
 */

function sendQueryGetHintsCreateHTMLHintsListShutterstock(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();
    let url = PARAM_url;
    let mediaType = document.querySelector("input[name='media_type_shutterstock']:checked").value;
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let requestSet = mediaType + "\n" + basicKeywordsString;

    newXMLHttpRequest(url, requestSet);
    if (window.hintsObjectsArray === "") {
        return false;
    } else {
        createHTMLHintsListShutterstock(window.hintsObjectsArray);
        setTimeout("enableGetBasicKeywordsButton()", 200);
    }
}

function sendQueryGetHintsCreateHTMLHintsListYoutube(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();
    let url = PARAM_url;
    let param0Z = document.querySelector("input[name='0-z_youtube']:checked").value;
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let excludedKeywordsString = document.querySelector("#excluded_keywords_string").value;
    let requestSet = param0Z  + "\n" + basicKeywordsString  + "\n" + excludedKeywordsString;

    newXMLHttpRequest(url, requestSet);
    if (window.hintsObjectsArray === "") {
        return false;
    } else {
        createHTMLHintsListYoutube(window.hintsObjectsArray);
        setTimeout("enableGetBasicKeywordsButton()", 200);
    }
}

function newXMLHttpRequest(PARAM_url, PARAM_requestSet) {
    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Слишком длинное опорное слово.";
                window.hintsObjectsArray = "";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только кириллица, латиница, цифры, пробел, дефис, апостроф, амперсанд и подчерк.";
                window.hintsObjectsArray = "";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Пустой запрос или ответ.";
                window.hintsObjectsArray = "";
                enableGetBasicKeywordsButton();
            } else {console.log(request.responseText)
                window.hintsObjectsArray = JSON.parse(request.responseText);
            }
        }
    }
    request.open("POST", PARAM_url, false);
    request.send(PARAM_requestSet);
}

function createHTMLHintsListShutterstock(PARAM_hintsObjectsArray) {
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
        hintKeywords[i].addEventListener("click", keywordPatternToQuery);
    }
}

function createHTMLHintsListYoutube(PARAM_hintsObjectsArray) {
    let listResultArray = [];
    let listResultArrayCopy = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].includes('----', 7)) {
            listResultArray[i] = "<div class='hint-box-letter'>" +
                PARAM_hintsObjectsArray[i] +
                "</div>";
        } else {
            listResultArray[i] = "<div class='hint-box'>" +
                "<span id='youtube-hint-hover' class='youtube-hint-hover'>" + PARAM_hintsObjectsArray[i] + "</span>" +
                " → " +
                "<a href='https://www.youtube.com/results?search_query=" + PARAM_hintsObjectsArray[i] + "' target='_blank'>YouTube</a>" +
                " | " +
                "<a href='https://trends.google.com/trends/explore?date=all_2008&gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' target='_blank'>Google Trends</a>" +
                "</div>";
        }
    }

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArrayCopy[i] = "<div class='hint-box'>" +
            PARAM_hintsObjectsArray[i] +
            "</div>";
    }

    document.querySelector("#hints-area").innerHTML = listResultArray.join("") +
        "<div id='hint-copy-box' class='hint-copy-box'>" +
        listResultArrayCopy.join("") +
        "</div>";

    let resultItem = document.querySelectorAll("#youtube-hint-hover");
    for (let i = 0; i < resultItem.length; i++) {
        resultItem[i].addEventListener("click", function (e) {
            e.stopPropagation();
        }, false);
        resultItem[i].addEventListener("click", selectResult);
    }

    let resultNode = document.querySelector("#hint-copy-box");
    resultNode.addEventListener('click', selectResult);

    let hintKeywords = document.querySelectorAll(".youtube-hint-hover");

    for (let i = 0; i < hintKeywords.length; i++) {
        hintKeywords[i].addEventListener("click", function (e) {
            e.stopPropagation();
        }, false);
        hintKeywords[i].addEventListener("click", keywordPatternToQuery);
    }
}

function selectResult() {
    let selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    let select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
}

function clearQueryBasic() {
    document.getElementById("basic_keywords_string").value = "";
    document.querySelector("#error-hints").innerHTML = "";
}

function clearQueryExcluded() {
    document.getElementById("excluded_keywords_string").value = "";
}

function disableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = true;
    getBasicKeywordsButtonShutterstock.value = "";
    getBasicKeywordsButtonShutterstock.style.background = "#dddddd";
    getBasicKeywordsButtonShutterstock.style.cursor = "default";

    getBasicKeywordsButtonYoutube.disabled = true;
    getBasicKeywordsButtonYoutube.value = "";
    getBasicKeywordsButtonYoutube.style.background = "#dddddd";
    getBasicKeywordsButtonYoutube.style.cursor = "default";
}

function enableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = false;
    getBasicKeywordsButtonShutterstock.value = "От Шаттерстока";
    getBasicKeywordsButtonShutterstock.style.background = "";
    getBasicKeywordsButtonShutterstock.style.cursor = "";

    getBasicKeywordsButtonYoutube.disabled = false;
    getBasicKeywordsButtonYoutube.value = "От Ютуба";
    getBasicKeywordsButtonYoutube.style.background = "";
    getBasicKeywordsButtonYoutube.style.cursor = "";
}

function clearErrors() {
    document.querySelector("#error-hints").innerHTML = "";
}

function keywordPatternToQuery() {
    document.querySelector("#basic_keywords_string").value = this.innerHTML.replace('&amp;', '&');
}
