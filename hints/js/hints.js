var getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
var getBasicKeywordsButtonIstock = document.querySelector("#get-basic-keywords-button-istock");
var getBasicKeywordsButtonGetty = document.querySelector("#get-basic-keywords-button-getty");
var getBasicKeywordsButtonFotolia = document.querySelector("#get-basic-keywords-button-fotolia");
var clearButton = document.querySelector("#clear-button");
var deleteHintsObjectsArrayButton = document.querySelector("#delete-hints-objects-array-button");
var deleteDeselectedHintsButton = document.querySelector("#delete-deselected-hints-button");
var returnToListViewButton = document.querySelector("#return-to-list-view-button");
var sortAzButton = document.querySelector("#sort-a-z-button");
var createResultStringButton = document.querySelector("#create-result-string-button");
var rankHintsListButton = document.querySelector("#rank-hints-list-button");
var hintsArea = document.querySelector("#hints-area");
var upButtonBlock = document.querySelector("#up-button-block");
var addKeywordsToListButton = document.querySelector("#add-keywords-to-list-button");
var getTranslationButton = document.querySelector("#get-translation-button");
var clearTranslationButton = document.querySelector("#clear-translation-button");


window.onload = countHintsTotalAndSelected();
window.onload = viewHideUpButton();
getBasicKeywordsButtonShutterstock.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListShutterstock("php/ex_hints_shutterstock.php");
}, false);
getBasicKeywordsButtonIstock.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListIstock("php/ex_hints_istockphoto.php");
}, false);
getBasicKeywordsButtonGetty.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListGetty("php/ex_hints_gettyimages.php");
}, false);
getBasicKeywordsButtonFotolia.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListFotolia("php/ex_hints_fotolia.php");
}, false);
addKeywordsToListButton.addEventListener("click", function (e) {
    e.preventDefault();
    addKeywordsToList("php/ex_add_keywords_to_list.php");
}, false);
clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearQuery();
}, false);
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
rankHintsListButton.addEventListener("click", function (e) {
    e.preventDefault();
    rankHintsList();
}, false);
getTranslationButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetTranslationsCreateHTMLTranslationsList("php/ex_translations.php");
}, false);
clearTranslationButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearTranslationArea();
}, false);
window.addEventListener("scroll", viewHideUpButton);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function addKeywordsToList(PARAM_url) {
    clearErrors();
    reSortingHintsObjectsArray();
    var basicKeywordsString = document.querySelector("#basic-keywords-string");
    var basicKeywordsStringTrim = basicKeywordsString.value.trim();

    if (basicKeywordsStringTrim === "") {
        document.querySelector("#hints-area").innerHTML = "Нечего добавлять.";
    } else {
        var request = new XMLHttpRequest();
        basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(basicKeywordsString.value);

        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                if (request.responseText === "-1") {
                    document.querySelector("#error-hints").innerHTML = "Не более 80-ти добавляемых ключевых слов.";
                } else if (request.responseText === "-2") {
                    document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
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
                }
                ;
            }
            ;
        };
        request.open("POST", PARAM_url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(basicKeywordsString);
    }
    ;
};


function sendQueryGetHintsCreateHTMLHintsListShutterstock(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var mediaType = "mediaType=" + document.querySelector("input[name='media-type']:checked").value;
    var basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);
    var requestSet = basicKeywordsString + "&" + mediaType;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 8-ми опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
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


function sendQueryGetHintsCreateHTMLHintsListIstock(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 8-ми опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
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
    request.send(basicKeywordsString);
};


function sendQueryGetHintsCreateHTMLHintsListGetty(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 8-ми опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
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
    request.send(basicKeywordsString);
};


function sendQueryGetHintsCreateHTMLHintsListFotolia(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 8-ми опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
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
    request.send(basicKeywordsString);
};


function sendQueryGetTranslationsCreateHTMLTranslationsList(PARAM_url) {
    clearErrors();

    var request = new XMLHttpRequest();
    var keywordInRussian = "keywordInRussian=" + document.querySelector("#in-russian").value;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#translations-area").innerHTML = "Перевода нет.";
            } else if (request.responseText === "-2") {
                document.querySelector("#translations-area").innerHTML = "Нечего переводить.";
            } else if (request.responseText === "-3") {
                document.querySelector("#error-translations").innerHTML = "Только кириллица, цифры, пробел и дефис.";
            } else {
                document.querySelector("#translations-area").innerHTML = JSON.parse(request.responseText).join("");

                var hintKeywords = document.querySelectorAll("#hint-keyword");
                for (var i = 0; i < hintKeywords.length; i++) {
                    hintKeywords[i].addEventListener("click", function (e) {
                        e.stopPropagation();
                    }, false);
                    hintKeywords[i].addEventListener("click", keywordwPatternToQuery);
                }
                ;
            }
            ;
        }
        ;
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(keywordInRussian);
}
;


function clearTranslationArea() {
    clearErrors();
    document.querySelector("#in-russian").value = "";
    document.querySelector("#translations-area").innerHTML = "Список перевода пуст.";
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
    clearErrors();
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
    clearErrors();
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
    clearErrors();
    reSortingHintsObjectsArray();
    if (typeof window.hintsObjectsArray !== "undefined") {
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Список подсказок пуст.";
    }
    ;
};


function createResultString() {
    clearErrors();
    reSortingHintsObjectsArray();
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


            var request = new XMLHttpRequest();
            var jsonHintsStringForTranlation = 'jsonHintsStringForTranlation=' + encodeURIComponent(JSON.stringify(resultString));
            request.open("POST", 'php/ex_add_hints_to_translation.php', true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(jsonHintsStringForTranlation);


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


function rankHintsList() {
    clearErrors();
    // reSortingHintsObjectsArray();
    deleteDeselectedHints();

    if (typeof window.hintsObjectsArray !== "undefined") {

        var listResultArray = [];

        for (var i = 0; i < window.hintsObjectsArray.length; i++) {
            listResultArray[i] = "<div class='rank-hint-box'>" +
                "<span class='bold'>" + window.hintsObjectsArray[i].hint + "</span>" +
                "</div>";
        }
        ;
        document.querySelector("#hints-area").innerHTML = "<div id='rank-hints-list'>" + listResultArray.join("") + "</div>";

        $(function () {
            $("#rank-hints-list").sortable();
            $("#rank-hints-list").disableSelection();
        });

    } else {
        document.querySelector("#hints-area").innerHTML = "Нечему задавать очерёдность.";
    }
    ;
};


function reSortingHintsObjectsArray() {
    var rankHintsBoxes = document.querySelectorAll('.rank-hint-box');
    if (rankHintsBoxes.length > 0) {
        window.hintsObjectsArrayReRank = [];
        for (var i = 0; i < rankHintsBoxes.length; i++) {
            rankHintsBoxes[i].innerText = rankHintsBoxes[i].innerText.replace('&amp;', '&');
            rankHintsBoxes[i].innerText = rankHintsBoxes[i].innerText.replace('&', '&amp;');
            for (var j = 0; j < window.hintsObjectsArray.length; j++) {
                if (rankHintsBoxes[i].innerText === window.hintsObjectsArray[j].hint) {
                    window.hintsObjectsArrayReRank[i] = window.hintsObjectsArray[j];
                    break;
                }
                ;
            }
            ;
        }
        ;
        window.hintsObjectsArray = window.hintsObjectsArrayReRank;
        delete window.hintsObjectsArrayReRank;
    }
    ;
};


function clearQuery() {
    clearErrors();
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
};


function deleteHintsObjectsArray() {
    clearErrors();
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
    clearErrors();
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
        document.querySelector("#basic-keywords-string").value = lastKws.trim() + "\n" + this.innerHTML.replace('&amp;', '&');
    } else {
        document.querySelector("#basic-keywords-string").value = this.innerHTML.replace('&amp;', '&');
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
    getBasicKeywordsButtonShutterstock.disabled = true;
    getBasicKeywordsButtonShutterstock.value = "…";
    getBasicKeywordsButtonShutterstock.style.background = "#dddddd";
    getBasicKeywordsButtonShutterstock.style.cursor = "default";

    getBasicKeywordsButtonIstock.disabled = true;
    getBasicKeywordsButtonIstock.value = "…";
    getBasicKeywordsButtonIstock.style.background = "#dddddd";
    getBasicKeywordsButtonIstock.style.cursor = "default";

    getBasicKeywordsButtonGetty.disabled = true;
    getBasicKeywordsButtonGetty.value = "…";
    getBasicKeywordsButtonGetty.style.background = "#dddddd";
    getBasicKeywordsButtonGetty.style.cursor = "default";

    getBasicKeywordsButtonFotolia.disabled = true;
    getBasicKeywordsButtonFotolia.value = "…";
    getBasicKeywordsButtonFotolia.style.background = "#dddddd";
    getBasicKeywordsButtonFotolia.style.cursor = "default";
};


function enableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = false;
    getBasicKeywordsButtonShutterstock.value = "От Шаттерстока";
    getBasicKeywordsButtonShutterstock.style.background = "";
    getBasicKeywordsButtonShutterstock.style.cursor = "";

    getBasicKeywordsButtonIstock.disabled = false;
    getBasicKeywordsButtonIstock.value = "От Айстокфото";
    getBasicKeywordsButtonIstock.style.background = "";
    getBasicKeywordsButtonIstock.style.cursor = "";

    getBasicKeywordsButtonGetty.disabled = false;
    getBasicKeywordsButtonGetty.value = "От Геттиимаджес";
    getBasicKeywordsButtonGetty.style.background = "";
    getBasicKeywordsButtonGetty.style.cursor = "";

    getBasicKeywordsButtonFotolia.disabled = false;
    getBasicKeywordsButtonFotolia.value = "От Фотолии";
    getBasicKeywordsButtonFotolia.style.background = "";
    getBasicKeywordsButtonFotolia.style.cursor = "";
};


function clearErrors() {
    document.querySelector("#error-hints").innerHTML = "";
    document.querySelector("#error-translations").innerHTML = "";
};