let getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
let getBasicKeywordsButtonYoutube = document.querySelector("#get-basic-keywords-button-youtube");
let getBasicKeywordsButtonPond5 = document.querySelector("#get-basic-keywords-button-pond5");
let clearButtonBasic = document.querySelector("#clear-button-basic");


getBasicKeywordsButtonShutterstock.addEventListener("click", function (e) {
    e.preventDefault();
    clearErrors();
    clearHintsArea();
    disableGetBasicKeywordsButton();
    sendQueryGetHintsCreateHTMLHintsListShutterstock("from_shutterstock.php");
}, false);
getBasicKeywordsButtonYoutube.addEventListener("click", function (e) {
    e.preventDefault();
    clearErrors();
    clearHintsArea();
    disableGetBasicKeywordsButton();
    sendQueryGetHintsCreateHTMLHintsListYoutube("from_youtube.php");
}, false);
getBasicKeywordsButtonPond5.addEventListener("click", function (e) {
    e.preventDefault();
    clearErrors();
    clearHintsArea();
    disableGetBasicKeywordsButton();
    // sendQueryGetHintsCreateHTMLHintsListPond5("from_pond5.php");
    ////////////////////////////////////////start get sug without cURL
    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            console.log(request.responseText)
        }
    }

    request.open("GET", "https://www.pond5.com/ajax/search/autocomplete?frag=news&lang=en_US&type=Footage&search=p5_video_filter", false);
    request.send();
    ////////////////////////////////////////end
}, false);
clearButtonBasic.addEventListener("click", function (e) {
    e.preventDefault();
    clearQueryBasic();
}, false);


/**
 * Functions.
 */

function sendQueryGetHintsCreateHTMLHintsListShutterstock(PARAM_url) {
    let url = PARAM_url;
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let mediaType = document.querySelector("input[name='media_type_shutterstock']:checked").value;
    let requestSet = basicKeywordsString + "\n" + mediaType;

    newXMLHttpRequest(url, requestSet);
    if (window.hintsObjectsArray === "") {
        return false;
    } else {
        createHTMLHintsListShutterstock(window.hintsObjectsArray);
        setTimeout("enableGetBasicKeywordsButton()", 200);
    }
}

function sendQueryGetHintsCreateHTMLHintsListYoutube(PARAM_url) {
    let url = PARAM_url;
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let characterArray = document.querySelector("input[name='character_array']:checked").value;
    let languageCode = document.querySelector("input[name='language_code']:checked").value;
    let countryCode = document.querySelector("input[name='country_code']:checked").value;
    let requestSet = basicKeywordsString + "\n" + characterArray + "\n" + languageCode + "\n" + countryCode;

    newXMLHttpRequest(url, requestSet);
    if (window.hintsObjectsArray === "") {
        return false;
    } else {
        createHTMLHintsListYoutube(window.hintsObjectsArray);
        setTimeout("enableGetBasicKeywordsButton()", 200);
    }
}

function sendQueryGetHintsCreateHTMLHintsListPond5(PARAM_url) {
    let url = PARAM_url;
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let characterArray = document.querySelector("input[name='character_array']:checked").value;
    let mediaType = document.querySelector("input[name='media_type_pond5']:checked").value;
    let requestSet = basicKeywordsString + "\n" + characterArray + "\n" + mediaType;

    newXMLHttpRequest(url, requestSet);
    if (window.hintsObjectsArray === "") {
        return false;
    } else {
        createHTMLHintsListPond5(window.hintsObjectsArray, mediaType);
        setTimeout("enableGetBasicKeywordsButton()", 200);
    }
}

function newXMLHttpRequest(PARAM_url, PARAM_requestSet) {
    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Слишком длинный поисковый запрос.";
                window.hintsObjectsArray = "";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Недопустимый символ в поисковом запросе.";
                window.hintsObjectsArray = "";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Пустой запрос или ответ.";
                window.hintsObjectsArray = "";
                enableGetBasicKeywordsButton();
            } else {
                console.log(request.responseText)
                window.hintsObjectsArray = JSON.parse(request.responseText);
            }
        }
    }
    request.open("POST", PARAM_url, false);
    request.send(PARAM_requestSet);
}

function selectResultKeywordPattern() {
    let resultItem = document.querySelectorAll("#hint-hover");
    for (let i = 0; i < resultItem.length; i++) {
        resultItem[i].addEventListener("click", function (e) {
            e.stopPropagation();
        }, false);
        resultItem[i].addEventListener("click", selectResult);
    }
}

function createHTMLHintsListShutterstock(PARAM_hintsObjectsArray) {
    let listResultArray = [];
    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArray[i] = "<div class='hint-box'>" +
            "<span id='hint-hover' class='hint-hover'>" + PARAM_hintsObjectsArray[i] + "</span>" +
            "</div>";
    }

    document.querySelector("#hints-area").innerHTML = listResultArray.join("");

    selectResultKeywordPattern();
}

function createHTMLHintsListYoutube(PARAM_hintsObjectsArray) {
    let listResultArray = [];
    // LIST TO SELECTION
    let listResultArrayCopy = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].includes('____', 7)) {
            listResultArray[i] = "<div class='hint-box-letter'>" +
                PARAM_hintsObjectsArray[i] +
                "</div>";
        } else {
            listResultArray[i] = "<div class='hint-box'>" +
                "<span id='hint-hover' class='hint-hover'>" + PARAM_hintsObjectsArray[i] + "</span>" +
                " → " +
                "<a href='https://www.youtube.com/results?search_query=" + PARAM_hintsObjectsArray[i] + "&sp=CAMSBAgFEAE%253D' target='_blank'>YT</a>" +
                " " +
                "<a href='https://trends.google.com/trends/explore?date=all_2008&gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' class='a_highlight_1' target='_blank'>GTall</a>" +
                " " +
                "<a href='https://trends.google.com/trends/explore?cat=3&date=all_2008&gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' target='_blank'>GTall3</a>" +
                " " +
                "<a href='https://trends.google.com/trends/explore?cat=71&date=all_2008&gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' target='_blank'>GTall71</a>" +
                " " +
                "<a href='https://trends.google.com/trends/explore?gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' class='a_highlight_1' target='_blank'>GT12m</a>" +
                " " +
                "<a href='https://trends.google.com/trends/explore?cat=3&gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' target='_blank'>GT12m3</a>" +
                " " +
                "<a href='https://trends.google.com/trends/explore?cat=71&gprop=youtube&q=" + PARAM_hintsObjectsArray[i] + "' target='_blank'>GT12m71</a>" +
                "</div>";
        }
    }

    // LIST TO SELECTION START
    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArrayCopy[i] = "<div class='hint-box'>" +
            PARAM_hintsObjectsArray[i] +
            "</div>";
    }
    // LIST TO SELECTION END

    // LIST TO SELECTION START
    document.querySelector("#hints-area").innerHTML = "<details>" +
        "<summary>Развернуть и скопировать</summary>" +
        "<div id='hint-copy-box' class='hint-copy-box'>" +
        listResultArrayCopy.join("") +
        "</div></details>" +
        listResultArray.join("");
    // LIST TO SELECTION END

    selectResultKeywordPattern();

    // LIST TO SELECTION START
    let resultNode = document.querySelector("#hint-copy-box");
    resultNode.addEventListener('click', selectResult);
    // LIST TO SELECTION END
}

function createHTMLHintsListPond5(PARAM_hintsObjectsArray, PARAM_mediaType) {
    let listResultArray = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].includes('____', 7)) {
            listResultArray[i] = "<div class='hint-box-letter'>" +
                PARAM_hintsObjectsArray[i] +
                "</div>";
        } else if (PARAM_hintsObjectsArray[i].includes('no_result')) {
            listResultArray[i] = "<div class='hint-box'>No result.</div>";
        } else {
            listResultArray[i] = "<div class='hint-box'>" +
                "<span id='hint-hover' class='hint-hover'>" + PARAM_hintsObjectsArray[i] + "</span>" +
                " → " +
                "<a href='https://www.pond5.com/search?kw=" + PARAM_hintsObjectsArray[i] + "&media=" + PARAM_mediaType + "' target='_blank'>Pond5 (" + PARAM_mediaType + ")</a>" +
                "</div>";
        }
    }

    document.querySelector("#hints-area").innerHTML = listResultArray.join("");

    selectResultKeywordPattern();
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

function disableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = true;
    getBasicKeywordsButtonShutterstock.value = "";
    getBasicKeywordsButtonShutterstock.style.background = "#dddddd";
    getBasicKeywordsButtonShutterstock.style.cursor = "default";

    getBasicKeywordsButtonYoutube.disabled = true;
    getBasicKeywordsButtonYoutube.value = "";
    getBasicKeywordsButtonYoutube.style.background = "#dddddd";
    getBasicKeywordsButtonYoutube.style.cursor = "default";

    getBasicKeywordsButtonPond5.disabled = true;
    getBasicKeywordsButtonPond5.value = "";
    getBasicKeywordsButtonPond5.style.background = "#dddddd";
    getBasicKeywordsButtonPond5.style.cursor = "default";
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

    getBasicKeywordsButtonPond5.disabled = false;
    getBasicKeywordsButtonPond5.value = "From Pond5";
    getBasicKeywordsButtonPond5.style.background = "";
    getBasicKeywordsButtonPond5.style.cursor = "";
}

function clearErrors() {
    document.querySelector("#error-hints").innerHTML = "";
}

function clearHintsArea() {
    document.querySelector("#hints-area").innerHTML = "";
}
