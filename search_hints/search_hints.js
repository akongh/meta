let getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
let getBasicKeywordsButtonIstockphoto = document.querySelector("#get-basic-keywords-button-istockphoto");
let getBasicKeywordsButtonGetty = document.querySelector("#get-basic-keywords-button-getty");
let getBasicKeywordsButtonFotolia = document.querySelector("#get-basic-keywords-button-fotolia");
let getBasicKeywordsButtonBigstockphoto = document.querySelector("#get-basic-keywords-button-bigstockphoto");
let getBasicKeywordsButtonDepositphotos = document.querySelector("#get-basic-keywords-button-depositphotos");
let getBasicKeywordsButton123rf = document.querySelector("#get-basic-keywords-button-123rf");
let clearButton = document.querySelector("#clear-button");
let deleteDeselectedHintsButton = document.querySelector("#delete-deselected-hints-button");
let returnToListViewButton = document.querySelector("#return-to-list-view-button");
let sortAzButton = document.querySelector("#sort-a-z-button");
let createResultStringButton = document.querySelector("#create-result-string-button");
let rankHintsListButton = document.querySelector("#rank-hints-list-button");
let upButtonBlock = document.querySelector("#up-button-block");
let clearTranslationButton = document.querySelector("#clear-translation-button");
let selectAllHintsButton = document.querySelector("#select-all-hints-button");
let deselectAllHintsButton = document.querySelector("#deselect-all-hints-button");


getBasicKeywordsButtonShutterstock.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListShutterstock("php/ex_hints_shutterstock.php");
}, false);
getBasicKeywordsButtonIstockphoto.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListIstockphoto("php/ex_hints_istockphoto.php");
}, false);
getBasicKeywordsButtonGetty.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListGetty("php/ex_hints_gettyimages.php");
}, false);
getBasicKeywordsButtonFotolia.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListFotolia("php/ex_hints_fotolia.php");
}, false);
getBasicKeywordsButtonBigstockphoto.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListBigstockphoto("php/ex_hints_bigstockphoto.php");
}, false);
getBasicKeywordsButtonDepositphotos.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListDepositphotos("php/ex_hints_depositphotos.php");
}, false);
getBasicKeywordsButton123rf.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsList123rf("php/ex_hints_123rf.php");
}, false);
clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearQuery();
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


/**
 * Functions.
 */

function sendQueryGetHintsCreateHTMLHintsListShutterstock(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let mediaType = "mediaType=" + document.querySelector("input[name='media_type_shutterstock']:checked").value;
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
    let requestSet = basicKeywordsString + "&" + mediaType;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
}

function sendQueryGetHintsCreateHTMLHintsListIstockphoto(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsListGetty(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsListFotolia(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsListBigstockphoto(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let type = "type=" + document.querySelector("input[name='type']:checked").value;
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
    let requestSet = basicKeywordsString + "&" + type;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
}

function sendQueryGetHintsCreateHTMLHintsListDepositphotos(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsList123rf(PARAM_url) {
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-2") {
                document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
                enableGetBasicKeywordsButton();
            } else if (request.responseText === "-3") {
                document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
                enableGetBasicKeywordsButton();
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
                    // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
                } else {
                    window.hintsObjectsArray = resultArray;
                }

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function clearTranslationArea() {
    document.querySelector("#in-russian").value = "";
    document.querySelector("#translations-area").innerHTML = "Список перевода пуст.";
}

function addDeselectStatusForHints(PARAM_hintsObjectsArray) {
    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        PARAM_hintsObjectsArray[i].status = "deselect";
    }
}

function createHTMLHintsList(PARAM_hintsObjectsArray) {
    let listResultArray = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArray[i] = "<div id='hint-box'>" +
            "<span class='hover-invert'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
            "</div>";
    }
    document.querySelector("#hints-area").innerHTML = listResultArray.join("");
}

function returnToListView() {
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
            let jsonHintsStringForTranlation = 'jsonHintsStringForTranlation=' + encodeURIComponent(JSON.stringify(resultString));
            request.open("POST", 'php/ex_add_hints_to_translation.php', true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(jsonHintsStringForTranlation);

            document.querySelector("#hints-area").innerHTML = "<span id='select-result' class='result'>" +
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
    document.querySelector("textarea[name='basic_keywords_string']").value = "";
}

function deleteHintsObjectsArray() {
    if (typeof window.hintsObjectsArray !== "undefined") {
        delete window.hintsObjectsArray;
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
            createHTMLHintsList(window.hintsObjectsArray);
        } else {
            delete window.hintsObjectsArray;
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
    if (typeof window.hintsObjectsArray !== "undefined") {

        window.hintsObjectsArray.sort(compareObjectHints);
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего сортировать.";
    }
}

function selectAllHints() {
    reSortingHintsObjectsArray();

    if (typeof window.hintsObjectsArray !== "undefined") {
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            window.hintsObjectsArray[i].status = 'select';
        }
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего выбирать.";
    }
}

function deselectAllHints() {
    reSortingHintsObjectsArray();

    if (typeof window.hintsObjectsArray !== "undefined") {
        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            window.hintsObjectsArray[i].status = 'deselect';
        }
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

    getBasicKeywordsButtonIstockphoto.disabled = true;
    getBasicKeywordsButtonIstockphoto.value = "";
    getBasicKeywordsButtonIstockphoto.style.background = "#dddddd";
    getBasicKeywordsButtonIstockphoto.style.cursor = "default";

    getBasicKeywordsButtonGetty.disabled = true;
    getBasicKeywordsButtonGetty.value = "";
    getBasicKeywordsButtonGetty.style.background = "#dddddd";
    getBasicKeywordsButtonGetty.style.cursor = "default";

    getBasicKeywordsButtonFotolia.disabled = true;
    getBasicKeywordsButtonFotolia.value = "";
    getBasicKeywordsButtonFotolia.style.background = "#dddddd";
    getBasicKeywordsButtonFotolia.style.cursor = "default";

    getBasicKeywordsButtonBigstockphoto.disabled = true;
    getBasicKeywordsButtonBigstockphoto.value = "";
    getBasicKeywordsButtonBigstockphoto.style.background = "#dddddd";
    getBasicKeywordsButtonBigstockphoto.style.cursor = "default";

    getBasicKeywordsButtonDepositphotos.disabled = true;
    getBasicKeywordsButtonDepositphotos.value = "";
    getBasicKeywordsButtonDepositphotos.style.background = "#dddddd";
    getBasicKeywordsButtonDepositphotos.style.cursor = "default";

    getBasicKeywordsButton123rf.disabled = true;
    getBasicKeywordsButton123rf.value = "";
    getBasicKeywordsButton123rf.style.background = "#dddddd";
    getBasicKeywordsButton123rf.style.cursor = "default";
}

function enableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = false;
    getBasicKeywordsButtonShutterstock.value = "От Шаттерстока";
    getBasicKeywordsButtonShutterstock.style.background = "";
    getBasicKeywordsButtonShutterstock.style.cursor = "";

    getBasicKeywordsButtonIstockphoto.disabled = false;
    getBasicKeywordsButtonIstockphoto.value = "От Айстокфото";
    getBasicKeywordsButtonIstockphoto.style.background = "";
    getBasicKeywordsButtonIstockphoto.style.cursor = "";

    getBasicKeywordsButtonGetty.disabled = false;
    getBasicKeywordsButtonGetty.value = "От Геттиимаджес";
    getBasicKeywordsButtonGetty.style.background = "";
    getBasicKeywordsButtonGetty.style.cursor = "";

    getBasicKeywordsButtonFotolia.disabled = false;
    getBasicKeywordsButtonFotolia.value = "От Фотолии";
    getBasicKeywordsButtonFotolia.style.background = "";
    getBasicKeywordsButtonFotolia.style.cursor = "";

    getBasicKeywordsButtonBigstockphoto.disabled = false;
    getBasicKeywordsButtonBigstockphoto.value = "От Бигстокфото";
    getBasicKeywordsButtonBigstockphoto.style.background = "";
    getBasicKeywordsButtonBigstockphoto.style.cursor = "";

    getBasicKeywordsButtonDepositphotos.disabled = false;
    getBasicKeywordsButtonDepositphotos.value = "От Депозитфотос";
    getBasicKeywordsButtonDepositphotos.style.background = "";
    getBasicKeywordsButtonDepositphotos.style.cursor = "";

    getBasicKeywordsButton123rf.disabled = false;
    getBasicKeywordsButton123rf.value = "От 123РФ";
    getBasicKeywordsButton123rf.style.background = "";
    getBasicKeywordsButton123rf.style.cursor = "";
}
