let upButtonBlock = document.querySelector("#up-button-block");

let clearButton = document.querySelector("#clear-button");

let addKeywordsToSetButton = document.querySelector("#add-keywords-to-set-button");
let addSimilarYoutubeSearchQueriesToSetButton = document.querySelector("#similar-youtube-search-queries");

let rankHintsListButton = document.querySelector("#rank-hints-list-button");
let returnToListViewButton = document.querySelector("#return-to-list-view-button");
let sortAzButton = document.querySelector("#sort-a-z-button");
let createResultStringButton = document.querySelector("#create-result-string-button");
let createResultListButton = document.querySelector("#create-result-list-button");

let deleteDeselectedHintsButton = document.querySelector("#delete-deselected-hints-button");
let selectAllHintsButton = document.querySelector("#select-all-hints-button");
let deselectAllHintsButton = document.querySelector("#deselect-all-hints-button");

let hintsTotalAndSelected = document.querySelector("#hints-total-and-selected");
let deleteHintsObjectsArrayButton = document.querySelector("#delete-hints-objects-array-button");


window.onload = countHintsTotalAndSelected();
window.onload = viewHideUpButton();
addKeywordsToSetButton.addEventListener("click", function (e) {
    e.preventDefault();
    addKeywordsToSet("add_keywords_to_set.php");
}, false);
addSimilarYoutubeSearchQueriesToSetButton.addEventListener("click", function (e) {
    e.preventDefault();
    addSimilarYoutubeSearchQueriesToSet();
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
createResultListButton.addEventListener("click", function (e) {
    e.preventDefault();
    createResultList();
}, false);
rankHintsListButton.addEventListener("click", function (e) {
    e.preventDefault();
    rankHintsList();
}, false);
selectAllHintsButton.addEventListener("click", function (e) {
    e.preventDefault();
    selectAllHints();
}, false);
deselectAllHintsButton.addEventListener("click", function (e) {
    e.preventDefault();
    deselectAllHints();
}, false);
window.addEventListener("scroll", viewHideUpButton);


/**
 * Functions.
 */

function addKeywordsToSet(PARAM_url) {
    clearErrors();
    reSortingHintsObjectsArray();
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let withoutTrim = "false";
    let withoutPregMatch = "false";
    if (document.querySelector("#without-trim").checked) {
        withoutTrim = "true";
    }
    if (document.querySelector("#without-preg-match").checked) {
        withoutPregMatch = "true";
    }
    let sendingData = [basicKeywordsString, withoutTrim, withoutPregMatch];
    let sendingDataJSON = JSON.stringify(sendingData);

    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "err_1") {
                document.querySelector("#error-hints").innerHTML = "Превышен допустимый размер введённых данных и они были обрезаны.";
            } else if (request.responseText === "err_2") {
                document.querySelector("#error-hints").innerHTML = "Нечего добавлять.";
            } else if (request.responseText === "err_3") {
                document.querySelector("#error-hints").innerHTML = "Слишком много добавляемых ключевых слов.";
            } else if (request.responseText.includes("err_4", 0)) {
                document.querySelector("#error-hints").innerHTML = "Только кириллица, латиница, цифры, пробел, дефис, апостроф, амперсанд и октоторп.";
                document.querySelector("#error-hints-trigger").innerHTML = request.responseText.substring(5);
            } else {console.log(request.responseText);
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
    }

    request.open("POST", PARAM_url, true);
    request.send(sendingDataJSON);
}

function addSimilarYoutubeSearchQueriesToSet() {
    clearErrors();
    let basicKeywordsString = document.querySelector("#basic_keywords_string").value;
    let basicKeywordsArray = basicKeywordsString.split("\n");
    let resultArray = basicKeywordsArray.map(Item => {
        Item = Item.replace(/,+/gi, " ").replace(/\s+/gi, " ").trim();
        let ItemOrderedView = Item.split(" ").sort().join("");

        return {hint : ItemOrderedView + " | " + Item};
        //оставил возможность для создания ассоциативного массива в соответствии с $result_array в add_keywords_to_set.php
    });

    addDeselectStatusForHints(resultArray);
    window.hintsObjectsArray = resultArray.sort();
    countHintsTotalAndSelected();
    createHTMLHintsListForSimilar(window.hintsObjectsArray);
    document.querySelector("#basic_keywords_string").value = "";
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
            statusClass = " hint-box-deselect";
        } else {
            statusClass = " hint-box-select";
        }
        listResultArray[i] = "<div class='hint-box" + statusClass + "' title=''>" +
            "<span class='hint-hover'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
            "</div>" +
            "<p class='hint-links-box'>" +
            " → " +
            "<a href='https://www.youtube.com/results?search_query=" + PARAM_hintsObjectsArray[i].hint + "&sp=CAMSBAgFEAE%253D' target='_blank'>YT</a>" +
            " " +
            "<a href='https://trends.google.com/trends/explore?cat=71&date=all_2008&gprop=youtube&q=" + PARAM_hintsObjectsArray[i].hint + "' target='_blank'>GTall</a>" +
            " " +
            "<a href='https://trends.google.com/trends/explore?cat=71&gprop=youtube&q=" + PARAM_hintsObjectsArray[i].hint + "' target='_blank'>GT12m</a>" +
            "</p>";// todo: make a category select
    }
    document.querySelector("#hints-area").innerHTML = listResultArray.join("");

    let hintBoxes = document.querySelectorAll(".hint-box");
    for (let i = 0; i < hintBoxes.length; i++) {
        hintBoxes[i].addEventListener("click", selectDeselectHint);
    }
}

function createHTMLHintsListForSimilar(PARAM_hintsObjectsArray) {
    clearErrors();
    let listResultArray = [];
    let statusClass;

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].status === "deselect") {
            statusClass = " hint-box-deselect";
        } else {
            statusClass = " hint-box-select";
        }
        listResultArray[i] = "<div class='hint-box" + statusClass + "' title=''>" +
            "<span>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
            "</div>";
    }
    document.querySelector("#hints-area").innerHTML = listResultArray.join("");

    let hintBoxes = document.querySelectorAll(".hint-box");
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
        document.querySelector("#hints-area").innerHTML =
            "<p>Список подсказок пуст.</p>";
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
        let resultArray = [];
        let k = 0;
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                resultArray[k] = window.hintsObjectsArray[i].hint;
                k++;
            }
        }
        if (resultArray.length > 0) {
            document.querySelector("#hints-area").innerHTML =
                "<p>Внимание!<br>Пробел после запятой не схлопывается с первым пробелом в ключевом слове, если такой имеется.</p>" +
                "<span id='select-result'>" +
                resultArray.join(", ") +
                "</span>";
            let resultNode = document.querySelector("#select-result");
            resultNode.addEventListener('click', selectResult);
        } else {
            document.querySelector("#hints-area").innerHTML =
                "<p>Ничего не выбрано.</p>";
        }
    } else {
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего собирать в результат строкой.</p>";
    }
}

function createResultList() {
    clearErrors();
    reSortingHintsObjectsArray();
    if (typeof window.hintsObjectsArray !== "undefined") {
        let resultArray = [];
        let k = 0;
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            if (window.hintsObjectsArray[i].status === "select") {
                resultArray[k] = window.hintsObjectsArray[i].hint;
                k++;
            }
        }
        if (resultArray.length > 0) {

            document.querySelector("#hints-area").innerHTML =
                "<span id='select-result'>" +
                resultArray.join("\n") +
                "</span>";
            let resultNode = document.querySelector("#select-result");
            resultNode.addEventListener('click', selectResult);
        } else {
            document.querySelector("#hints-area").innerHTML =
                "<p>Ничего не выбрано.</p>";
        }
    } else {
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего собирать в результат списком.</p>";
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
        document.querySelector("#hints-area").innerHTML =
            "<ul id='sortable'>" + listResultArray.join("") + "</ul>";

        $(function () {
            $("#sortable").sortable().disableSelection();
        });

    } else {
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечему задавать очерёдность.</p>";
    }
}

function reSortingHintsObjectsArray() {
    let rankHintsBoxes = document.querySelectorAll('.ui-sortable-handle');
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
        document.querySelector("#hints-area").innerHTML =
            "<p>Список подсказок удалён.</p>";
    } else {
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего удалять.</p>";
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
            document.querySelector("#hints-area").innerHTML =
                "<p>Список подсказок пуст.</p>";
        }
    } else {
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего очищать.</p>";
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
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего сортировать.</p>";
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
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего выбирать.</p>";
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
        document.querySelector("#hints-area").innerHTML =
            "<p>Нечего невыбирать.</p>";
    }
}

function clearErrors() {
    document.querySelector("#error-hints").innerHTML = "";
    document.querySelector("#error-hints-trigger").innerHTML = "";
}
