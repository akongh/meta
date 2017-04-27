var getBasicKeywordsButton = document.querySelector("#get-basic-keywords-button");
var clearButton = document.querySelector("#clearButton");


getBasicKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHints("php/ex_sqs_shutterstock.php");
}, false);
clearButton.addEventListener("click", clearQuery);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function sendQueryGetHints(url) {
    hideGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var mediaType = "mediaType=" + document.querySelector("input[name='media-type']:checked").value;
    var basicKeywordsString = "basicKeywordsString=" + document.querySelector("#basic-keywords-string").value;
    var requestSet = basicKeywordsString + "&" + mediaType;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            var resultArray = JSON.parse(request.responseText);
            if (typeof window.hintsObjectsArray !== "undefined") {
                window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
            } else {
                window.hintsObjectsArray = resultArray;
            }
            ;
            var listResultArray = [];
            for (var i = 0; i < window.hintsObjectsArray.length; i++) {
                listResultArray[i] = "<span class='bold'>" + window.hintsObjectsArray[i].hint + "</span><br>" + window.hintsObjectsArray[i].translation.join("<br>");
            }
            ;
            document.querySelector("#hints-list").innerHTML = listResultArray.join("<br>");
            setTimeout("visibleGetBasicKeywordsButton()", 200);
        }
        ;
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
};

function hideGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = true;
    getBasicKeywordsButton.value = "Ждём…";
    getBasicKeywordsButton.style.background = "#dddddd";
    getBasicKeywordsButton.style.cursor = "default";
};

function visibleGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = false;
    getBasicKeywordsButton.value = "Глянуть";
    getBasicKeywordsButton.style.background = "";
    getBasicKeywordsButton.style.cursor = "";
};

function clearQuery() {
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
};