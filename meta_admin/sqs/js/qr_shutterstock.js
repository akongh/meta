var getBasicKeywordsButton = document.querySelector("#get-basic-keywords-button");
var clearButton = document.querySelector("#clearButton");


getBasicKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsList("php/ex_sqs_shutterstock.php");
}, false);
clearButton.addEventListener("click", clearQuery);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function sendQueryGetHintsCreateHTMLHintsList(PARAM_url) {
    disableGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var mediaType = "mediaType=" + document.querySelector("input[name='media-type']:checked").value;
    var basicKeywordsString = "basicKeywordsString=" + document.querySelector("#basic-keywords-string").value;
    var requestSet = basicKeywordsString + "&" + mediaType;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {

            var resultArray = JSON.parse(request.responseText);

            addStatusForHints(resultArray);

            if (typeof window.hintsObjectsArray !== "undefined") {
                window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
            } else {
                window.hintsObjectsArray = resultArray;
            }
            ;

            createHTMLHintsList(window.hintsObjectsArray);

            setTimeout("enableGetBasicKeywordsButton()", 200);
        }
        ;
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
};


function addStatusForHints(PARAM_hintsObjectsArray) {
    for (var i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        PARAM_hintsObjectsArray[i].status = "deselect";
    }
    ;
};


function createHTMLHintsList(PARAM_hintsObjectsArray) {

    var listResultArray = [];

    for (var i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArray[i] = "<span class='bold'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
            "<br>" +
            PARAM_hintsObjectsArray[i].translation.join("<br>");
    }
    ;
    document.querySelector("#hints-list").innerHTML = listResultArray.join("<br>");
};


function clearQuery() {
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
};


function disableGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = true;
    getBasicKeywordsButton.value = "Ждём…";
    getBasicKeywordsButton.style.background = "#dddddd";
    getBasicKeywordsButton.style.cursor = "default";
};


function enableGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = false;
    getBasicKeywordsButton.value = "Глянуть";
    getBasicKeywordsButton.style.background = "";
    getBasicKeywordsButton.style.cursor = "";
};