let clearButton = document.querySelector("#clear-button");
let deleteHintsObjectsArrayButton = document.querySelector("#delete-hints-objects-array-button");
let deleteDeselectedHintsButton = document.querySelector("#delete-deselected-hints-button");
let returnToListViewButton = document.querySelector("#return-to-list-view-button");
let sortAzButton = document.querySelector("#sort-a-z-button");
let createResultStringButton = document.querySelector("#create-result-string-button");
let rankHintsListButton = document.querySelector("#rank-hints-list-button");
let hintsTotalAndSelected = document.querySelector("#hints-total-and-selected");
let upButtonBlock = document.querySelector("#up-button-block");
let addKeywordsToListButton = document.querySelector("#add-keywords-to-list-button");
let getTranslationButton = document.querySelector("#get-translation-button");
let clearTranslationButton = document.querySelector("#clear-translation-button");
let selectAllHintsButton = document.querySelector("#select-all-hints-button");
let deselectAllHintsButton = document.querySelector("#deselect-all-hints-button");


window.onload = countHintsTotalAndSelected();
window.onload = viewHideUpButton();
addKeywordsToListButton.addEventListener("click", function (e) {
    e.preventDefault();
    addKeywordsToList("add_keywords_to_set.php");
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
    sendQueryGetTranslationsCreateHTMLTranslationsList("translations.php");
}, false);
selectAllHintsButton.addEventListener("click", function (e) {
    e.preventDefault();
    selectAllHints();
}, false);
deselectAllHintsButton.addEventListener("click", function (e) {
    e.preventDefault();
    deselectAllHints();
}, false);
clearTranslationButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearTranslationArea();
}, false);
window.addEventListener("scroll", viewHideUpButton);


/**
 * Functions.
 */

function addKeywordsToList(PARAM_url) {
    clearErrors();
    reSortingHintsObjectsArray();
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;

    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {

// console.log(request.responseText);

            if (request.responseText === "err_1") {
                document.querySelector("#error-hints").innerHTML = "Превышен допустимый размер введённых данных и они были обрезаны.";
            } else if (request.responseText === "err_2") {
                document.querySelector("#error-hints").innerHTML = "Нечего добавлять.";
            } else if (request.responseText === "err_3") {
                document.querySelector("#error-hints").innerHTML = "Слишком много добавляемых ключевых слов.";
            } else if (request.responseText === "err_4") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
            } else {
                let resultArray = JSON.parse(request.responseText);

                addDeselectStatusForHints(resultArray);

                if (typeof window.hintsObjectsArray !== "undefined") {
                    for (let i = 0; i < resultArray.length; i++) {
                        for (let j = 0; j < window.hintsObjectsArray.length; j++) {
                            if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
                                resultArray.splice(i, 1);
                                i--;
                                break;
                            }
                        }
                    }
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                document.querySelector("#basic_keywords_string").value = "";
            }
        }
    };

    request.open("POST", PARAM_url, true);
    request.send(basicKeywordsString);
}

function sendQueryGetTranslationsCreateHTMLTranslationsList(PARAM_url) {
    clearErrors();

    let request = new XMLHttpRequest();
    let keywordInRussian = "keywordInRussian=" + document.querySelector("#in-russian").value;

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

                let hintKeywords = document.querySelectorAll(".hover-invert");
                for (let i = 0; i < hintKeywords.length; i++) {
                    hintKeywords[i].addEventListener("click", function (e) {
                        e.stopPropagation();
                    }, false);
                    hintKeywords[i].addEventListener("click", keywordwPatternToQuery);
                }
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(keywordInRussian.replace('&', '%26'));
}

function clearTranslationArea() {
    clearErrors();
    document.querySelector("#in-russian").value = "";
    document.querySelector("#translations-area").innerHTML = "Список перевода пуст.";
}

function addDeselectStatusForHints(PARAM_hintsObjectsArray) {
    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        PARAM_hintsObjectsArray[i].status = "deselect";
    }
}

function countHintsTotalAndSelected() {
    let countTotal = 0;
    let countSelected = 0;
    if (typeof window.hintsObjectsArray !== "undefined") {
        countTotal = window.hintsObjectsArray.length;
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                countSelected++;
            }
        }
    }
    document.querySelector("#hints-total-and-selected-top").innerHTML = countSelected + " / " + countTotal;
    document.querySelector("#hints-total-and-selected").innerHTML = countSelected + " / " + countTotal;
}

function createHTMLHintsList(PARAM_hintsObjectsArray) {
    clearErrors();
    let listResultArray = [];
    let statusClass;

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].status === "deselect") {
            statusClass = "hint-box-deselect";
        } else {
            statusClass = "hint-box-select";
        }
        listResultArray[i] = "<div id='hint-box' class='" + statusClass + "'>" +
            "<span class='hover-invert'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
            "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
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

    let hintBoxes = document.querySelectorAll("#hint-box");
    for (let i = 0; i < hintBoxes.length; i++) {
        hintBoxes[i].addEventListener("click", selectDeselectHint);
    }
}

function selectDeselectHint() {
    clearErrors();
    let hint = this.firstChild.innerHTML;
    for (let i = 0; i < window.hintsObjectsArray.length; i++) {
        if (window.hintsObjectsArray[i].hint === hint.replace(/&amp;/g, '&')) {
            if (window.hintsObjectsArray[i].status === "deselect") {
                window.hintsObjectsArray[i].status = "select";
            } else {
                window.hintsObjectsArray[i].status = "deselect"
            }

            break;
        }
    }

    countHintsTotalAndSelected();
    createHTMLHintsList(window.hintsObjectsArray);
}

function returnToListView() {
    clearErrors();
    reSortingHintsObjectsArray();
    if (typeof window.hintsObjectsArray !== "undefined") {
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Список подсказок пуст.";
    }
}

function selectResult() {
    let selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    let select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
}

function createResultString() {
    clearErrors();
    reSortingHintsObjectsArray();
    if (typeof window.hintsObjectsArray !== "undefined") {
        let resultString = [];
        let k = 0;
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                resultString[k] = window.hintsObjectsArray[i].hint;
                k++;
            }
        }
        if (resultString.length > 0) {
            let request = new XMLHttpRequest();

            // request.onreadystatechange = function () {
            //     if (request.readyState === 4 && request.status === 200) {
            //         console.log(request.responseText);
            //     }
            // }

            let jsonHintsStringForTranlation = JSON.stringify(resultString);
            request.open("POST", 'add_keyword_to_db.php', true);
            request.send(jsonHintsStringForTranlation);

            document.querySelector("#hints-area").innerHTML = "<span id='select-result'>" +
                resultString.join(", ") +
                "</span>";
            let resultNode = document.querySelector("#select-result");
            resultNode.addEventListener('click', selectResult);
        } else {
            document.querySelector("#hints-area").innerHTML = "Ничего не выбрано.";
        }
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего собирать в результат.";
    }
}

function rankHintsList() {
    clearErrors();
    reSortingHintsObjectsArray();

    if (typeof window.hintsObjectsArray !== "undefined") {

        let listResultArray = [];
        let classDeselect;

        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "deselect") {
                classDeselect = "sortable_element_deselect";
            } else {
                classDeselect = "sortable_element";
            }
            listResultArray[i] = "<li class='" + classDeselect + "'>" +
                window.hintsObjectsArray[i].hint +
                "</li>";
        }
        document.querySelector("#hints-area").innerHTML = "<ul id='sortable'>" + listResultArray.join("") + "</ul>";

        $(function () {
            $("#sortable").sortable().disableSelection();
        });

    } else {
        document.querySelector("#hints-area").innerHTML = "Нечему задавать очерёдность.";
    }
}

function reSortingHintsObjectsArray() {
    let rankHintsBoxes = document.querySelectorAll('.rank-hint-box');
    if (rankHintsBoxes.length > 0) {
        window.hintsObjectsArrayReRank = [];
        for (let i = 0; i < rankHintsBoxes.length; i++) {
            for (let j = 0; j < window.hintsObjectsArray.length; j++) {
                if (rankHintsBoxes[i].innerText === window.hintsObjectsArray[j].hint) {
                    window.hintsObjectsArrayReRank[i] = window.hintsObjectsArray[j];
                    break;
                }
            }
        }
        window.hintsObjectsArray = window.hintsObjectsArrayReRank;
        delete window.hintsObjectsArrayReRank;
    }
}

function clearQuery() {
    clearErrors();
    document.querySelector("textarea[name='basic_keywords_string']").value = "";
}

function deleteHintsObjectsArray() {
    clearErrors();
    if (typeof window.hintsObjectsArray !== "undefined") {
        delete window.hintsObjectsArray;
        countHintsTotalAndSelected();
        document.querySelector("#hints-area").innerHTML = "Список подсказок удалён.";
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего удалять.";
    }
}

function deleteDeselectedHints() {
    if (typeof window.hintsObjectsArray !== "undefined") {
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "deselect") {
                window.hintsObjectsArray.splice(i, 1);
                i--;
            }
        }
        if (window.hintsObjectsArray.length > 0) {
            countHintsTotalAndSelected();
            createHTMLHintsList(window.hintsObjectsArray);
        } else {
            delete window.hintsObjectsArray;
            countHintsTotalAndSelected();
            document.querySelector("#hints-area").innerHTML = "Список подсказок пуст.";
        }
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего очищать.";
    }
}

function compareObjectHints(a, b) {
    if (a.hint > b.hint) return 1;
    if (a.hint < b.hint) return -1;
}

function sortAz() {
    clearErrors();
    if (typeof window.hintsObjectsArray !== "undefined") {

        window.hintsObjectsArray.sort(compareObjectHints);
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего сортировать.";
    }
}

function keywordwPatternToQuery() {
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;

    if (basicKeywordsString !== "" || basicKeywordsString.trim() !== "") {
        document.querySelector("#basic_keywords_string").value = basicKeywordsString.trim() + "\n" + this.innerHTML.replace(/&amp;/g, '&');
    } else {
        document.querySelector("#basic_keywords_string").value = this.innerHTML.replace(/&amp;/g, '&');
    }
}

function viewHideUpButton() {
    if (hintsTotalAndSelected.getBoundingClientRect().bottom < 0) {
        upButtonBlock.style.display = "inline-block";
    } else {
        upButtonBlock.style.display = "none";
    }
}

function selectAllHints() {
    clearErrors();
    reSortingHintsObjectsArray();

    if (typeof window.hintsObjectsArray !== "undefined") {
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            window.hintsObjectsArray[i].status = 'select';
        }
        countHintsTotalAndSelected();
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего выбирать.";
    }
}

function deselectAllHints() {
    clearErrors();
    reSortingHintsObjectsArray();

    if (typeof window.hintsObjectsArray !== "undefined") {
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            window.hintsObjectsArray[i].status = 'deselect';
        }
        countHintsTotalAndSelected();
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего невыбирать.";
    }
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
    document.querySelector("#error-translations").innerHTML = "";
}
