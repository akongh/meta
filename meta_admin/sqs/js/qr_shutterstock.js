var getBasicKeywordsButton = document.querySelector("#get-basic-keywords-button");
var clearButton = document.querySelector("#clear-button");
var createResultStringButton = document.querySelector("#create-result-string-button");


window.onload = countHintsTotalAndSelected();
getBasicKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsList("php/ex_sqs_shutterstock.php");
}, false);
clearButton.addEventListener("click", clearQuery);
createResultStringButton.addEventListener("click", function (e) {
    e.preventDefault();
    createResultString();
}, false);


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
            if (request.responseText === "-1") {
                document.querySelector("#error").innerHTML = "Не более 8-ми опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else {
                document.querySelector("#error").innerHTML = "";

                var resultArray = JSON.parse(request.responseText);

                addStatusForHints(resultArray);

                if (typeof window.hintsObjectsArray !== "undefined") {
                    //удаляем дубликаты от нового массива
                    for (var i = 0; i < resultArray.length; i++) {
                        for (var j = 0; j < window.hintsObjectsArray.length; j++) {
                            if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
                                resultArray.splice([i], 1);
                                //учитываем сдвиг индексов после удаления элемента
                                i--;
                                break;
                            }
                            ;
                        }
                        ;
                    }
                    ;
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }
                ;

                countHintsTotalAndSelected();

                createHTMLHintsList(window.hintsObjectsArray);

                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
            ;
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


function countHintsTotalAndSelected() {
    var countTotal = 0;
    var countSelected = 0;
    if (typeof window.hintsObjectsArray !== "undefined") {
        countTotal = window.hintsObjectsArray.length;
        for (var i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                countSelected++;
            }
            ;
        }
        ;
    }
    ;
    document.querySelector("#hints-total-and-selected").innerHTML = countTotal + " / " + countSelected;
};


function createHTMLHintsList(PARAM_hintsObjectsArray) {

    var listResultArray = [];

    for (var i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].status === "deselect") {
            listResultArray[i] = "<div id='hint-box' class='hint-box-deselect'>" +
                "<div class='hint-keyword'>" + PARAM_hintsObjectsArray[i].hint + "</div>" +
                "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
                "</div>";
        } else {
            listResultArray[i] = "<div id='hint-box' class='hint-box-select'>" +
                "<div class='hint-keyword'>" + PARAM_hintsObjectsArray[i].hint + "</div>" +
                "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
                "</div>";
        }
        ;
    }
    ;
    document.querySelector("#hints-list").innerHTML = listResultArray.join("");

    var hintBoxes = document.querySelectorAll("#hint-box");
    for (var i = 0; i < hintBoxes.length; i++) {
        hintBoxes[i].addEventListener("click", selectDeselectHint);
    }
    ;
};


function selectDeselectHint() {
    var hint = this.firstChild.innerHTML;
    for (var i = 0; i < window.hintsObjectsArray.length; i++) {
        if (window.hintsObjectsArray[i].hint === hint) {
            if (window.hintsObjectsArray[i].status === "deselect") {
                window.hintsObjectsArray[i].status = "select";
            } else {
                window.hintsObjectsArray[i].status = "deselect"
            }
            ;
            break;
        }
        ;
    }
    ;

    countHintsTotalAndSelected();
    createHTMLHintsList(window.hintsObjectsArray);
};


function createResultString() {
    if (typeof window.hintsObjectsArray !== "undefined") {
        var resultString = [];
        var k = 0;
        for (var i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                resultString[k] = window.hintsObjectsArray[i].hint;
                k++;
            } else {
                document.querySelector("#hints-list").innerHTML = "Ничего не выбрано.";
            }
            ;
        }
        ;
        document.querySelector("#hints-list").innerHTML = resultString.join(", ");
    } else {
        document.querySelector("#hints-list").innerHTML = "Ничего не получено.";
    }
    ;
};


function clearQuery() {
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
};


function disableGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = true;
    getBasicKeywordsButton.value = "…";
    getBasicKeywordsButton.style.background = "#dddddd";
    getBasicKeywordsButton.style.cursor = "default";
};


function enableGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = false;
    getBasicKeywordsButton.value = "Получить";
    getBasicKeywordsButton.style.background = "";
    getBasicKeywordsButton.style.cursor = "";
};