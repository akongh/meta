var getBasicKeywordsButton = document.querySelector("#get-basic-keywords-button");
var clearButton = document.querySelector("#clear-button");
var deleteHintsObjectsArrayButton = document.querySelector("#delete-hints-objects-array-button");
var deleteDeselectedHintsButton = document.querySelector("#delete-deselected-hints-button");
var returnToListViewButton = document.querySelector("#return-to-list-view-button");
var sortAzButton = document.querySelector("#sort-a-z-button");
var createResultStringButton = document.querySelector("#create-result-string-button");
var hintsArea = document.querySelector("#hints-area");
var upButtonBlock = document.querySelector("#up-button-block");


window.onload = countHintsTotalAndSelected();
window.onload = viewHideUpButton();
getBasicKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsList("php/ex_sqs_shutterstock.php");
}, false);
clearButton.addEventListener("click", clearQuery);
deleteHintsObjectsArrayButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteHintsObjectsArray();
}, false);
deleteDeselectedHintsButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteDeselectedHints();
}, false);
returnToListViewButton.addEventListener("click", function (e) {
    e.preventDefault();
    returnToListView();
}, false);
sortAzButton.addEventListener("click", function (e) {
    e.preventDefault();
    sortAz();
}, false);
createResultStringButton.addEventListener("click", function (e) {
    e.preventDefault();
    createResultString();
}, false);
window.addEventListener("scroll", viewHideUpButton);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function sendQueryGetHintsCreateHTMLHintsList(PARAM_url) {
    document.querySelector("#error").innerHTML = "";
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

                var resultArray = JSON.parse(request.responseText);

                addStatusForHints(resultArray);

                if (typeof window.hintsObjectsArray !== "undefined") {
                    for (var i = 0; i < resultArray.length; i++) {
                        for (var j = 0; j < window.hintsObjectsArray.length; j++) {
                            if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
                                resultArray.splice(i, 1);
                                i--;
                                break;
                            }
                            ;
                        }
                        ;
                    }
                    ;
                    window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
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
    document.querySelector("#error").innerHTML = "";
    var listResultArray = [];

    for (var i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].status === "deselect") {
            listResultArray[i] = "<div id='hint-box' class='hint-box-deselect'>" +
                "<span id='hint-keyword' class='hint-keyword'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
                "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
                "</div>";
        } else {
            listResultArray[i] = "<div id='hint-box' class='hint-box-select'>" +
                "<span id='hint-keyword' class='hint-keyword'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
                "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
                "</div>";
        }
        ;
    }
    ;
    document.querySelector("#hints-area").innerHTML = listResultArray.join("");

    var hintKeywords = document.querySelectorAll("#hint-keyword");
    for (i = 0; i < hintKeywords.length; i++) {
        hintKeywords[i].addEventListener("click", function (e) {
            e.stopPropagation();
        }, false);
        hintKeywords[i].addEventListener("click", keywordwPatternToQuery);
    }
    ;

    var hintBoxes = document.querySelectorAll("#hint-box");
    for (i = 0; i < hintBoxes.length; i++) {
        hintBoxes[i].addEventListener("click", selectDeselectHint);
    }
    ;
};


function selectDeselectHint() {
    document.querySelector("#error").innerHTML = "";
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


function returnToListView() {
    document.querySelector("#error").innerHTML = "";
    if (typeof window.hintsObjectsArray !== "undefined") {
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Список подсказок пуст.";
    }
    ;
};


function createResultString() {
    document.querySelector("#error").innerHTML = "";
    if (typeof window.hintsObjectsArray !== "undefined") {
        var resultString = [];
        var k = 0;
        for (var i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                resultString[k] = window.hintsObjectsArray[i].hint;
                k++;
            }
            ;
        }
        ;
        if (resultString.length > 0) {
            document.querySelector("#hints-area").innerHTML = "<span id='select-result' class='result'>" +
                resultString.join(", ") +
                "</span>";
            var resultNode = document.querySelector("#select-result");
            resultNode.addEventListener('click', selectResult);
            function selectResult() {
                var selectRange = document.createRange();
                selectRange.selectNodeContents(this);
                var select = window.getSelection();
                select.removeAllRanges();
                select.addRange(selectRange);
            };
        } else {
            document.querySelector("#hints-area").innerHTML = "Ничего не выбрано.";
        }
        ;
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего собирать в результат.";
    }
    ;
};


function clearQuery() {
    document.querySelector("#error").innerHTML = "";
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
    document.querySelector("textarea[name='basic-keywords-string']").focus();
};


function deleteHintsObjectsArray() {
    document.querySelector("#error").innerHTML = "";
    if (typeof window.hintsObjectsArray !== "undefined") {
        delete window.hintsObjectsArray;
        countHintsTotalAndSelected();
        document.querySelector("#hints-area").innerHTML = "Список подсказок удалён.";
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего удалять.";
    }
    ;
};


function deleteDeselectedHints() {
    if (typeof window.hintsObjectsArray !== "undefined") {
        for (var i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "deselect") {
                window.hintsObjectsArray.splice(i, 1);
                i--;
            }
            ;
        }
        ;
        if (window.hintsObjectsArray.length > 0) {
            countHintsTotalAndSelected();
            createHTMLHintsList(window.hintsObjectsArray);
        }
        else {
            delete window.hintsObjectsArray;
            countHintsTotalAndSelected();
            document.querySelector("#hints-area").innerHTML = "Список подсказок пуст.";
        }
        ;
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего удалять.";
    }
    ;
};


function sortAz() {
    document.querySelector("#error").innerHTML = "";
    if (typeof window.hintsObjectsArray !== "undefined") {
        function compareObjectHints(a, b) {
            if (a.hint > b.hint) return 1;
            if (a.hint < b.hint) return -1;
        };
        window.hintsObjectsArray.sort(compareObjectHints);
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего сортировать.";
    }
    ;
};


function keywordwPatternToQuery() {
    var lastKws = document.querySelector("#basic-keywords-string").value;

    if (lastKws !== "" || lastKws.trim() !== "") {
        document.querySelector("#basic-keywords-string").value = lastKws.trim() + "\n" + this.innerHTML;
    } else {
        document.querySelector("#basic-keywords-string").value = this.innerHTML;
    }
    ;
};


function viewHideUpButton() {
    if (hintsArea.getBoundingClientRect().top < 0) {
        upButtonBlock.style.display = "inline-block";
    } else {
        upButtonBlock.style.display = "none";
    }
    ;
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