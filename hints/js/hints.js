let getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
let getBasicKeywordsButtonIstock = document.querySelector("#get-basic-keywords-button-istock");
let getBasicKeywordsButtonGetty = document.querySelector("#get-basic-keywords-button-getty");
let getBasicKeywordsButtonFotolia = document.querySelector("#get-basic-keywords-button-fotolia");
let getBasicKeywordsButtonBigstockphoto = document.querySelector("#get-basic-keywords-button-bigstockphoto");
let getBasicKeywordsButtonDepositphotos = document.querySelector("#get-basic-keywords-button-depositphotos");
let getBasicKeywordsButton123rf = document.querySelector("#get-basic-keywords-button-123rf");
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


// Functions

function addKeywordsToList(PARAM_url) {
    clearErrors();
    reSortingHintsObjectsArray();
    let basicKeywordsString = document.querySelector("#basic-keywords-string");
    let basicKeywordsStringTrim = basicKeywordsString.value.trim();

    if (basicKeywordsStringTrim === "") {
        document.querySelector("#hints-area").innerHTML = "Нечего добавлять.";
    } else {
        let request = new XMLHttpRequest();
        basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(basicKeywordsString.value);

        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                if (request.responseText === "-1") {
                    document.querySelector("#error-hints").innerHTML = "Не более 10&nbsp;000 добавляемых ключевых слов.";
                } else if (request.responseText === "-2") {
                    document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и&nbsp;амперсанд.";
                } else {
                    let resultArray = JSON.parse(request.responseText);
                    addStatusForHints(resultArray);

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

                    countHintsTotalAndSelected();
                    createHTMLHintsList(window.hintsObjectsArray);
                    document.querySelector("#basic-keywords-string").value = '';
                }
            }
        };
        request.open("POST", PARAM_url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(basicKeywordsString);
    }
}

function sendQueryGetHintsCreateHTMLHintsListShutterstock(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let mediaType = "mediaType=" + document.querySelector("input[name='media-type']:checked").value;
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);
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

                addStatusForHints(resultArray);

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
                    window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);                } else {
                    window.hintsObjectsArray = resultArray;
                }

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
}

function sendQueryGetHintsCreateHTMLHintsListIstock(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

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

                addStatusForHints(resultArray);

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

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsListGetty(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

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

                addStatusForHints(resultArray);

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

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsListFotolia(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

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

                addStatusForHints(resultArray);

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

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsListBigstockphoto(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let type = "type=" + document.querySelector("input[name='type']:checked").value;
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);
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

                addStatusForHints(resultArray);

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

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
}

function sendQueryGetHintsCreateHTMLHintsListDepositphotos(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

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

                addStatusForHints(resultArray);

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

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(basicKeywordsString);
}

function sendQueryGetHintsCreateHTMLHintsList123rf(PARAM_url) {
    clearErrors();
    disableGetBasicKeywordsButton();

    let request = new XMLHttpRequest();
    let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic-keywords-string").value);

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

                addStatusForHints(resultArray);

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

                countHintsTotalAndSelected();
                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
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

function addStatusForHints(PARAM_hintsObjectsArray) {
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
    document.querySelector("#hints-total-and-selected-top").innerHTML = countTotal + " / " + countSelected;
    document.querySelector("#hints-total-and-selected").innerHTML = countTotal + " / " + countSelected;
}

function createHTMLHintsList(PARAM_hintsObjectsArray) {
    clearErrors();
    let listResultArray = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        if (PARAM_hintsObjectsArray[i].status === "deselect") {
            listResultArray[i] = "<div id='hint-box' class='hint-box-deselect'>" +
                "<span class='hover-invert'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
                "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
                "</div>";
        } else {
            listResultArray[i] = "<div id='hint-box' class='hint-box-select'>" +
                "<span class='hover-invert'>" + PARAM_hintsObjectsArray[i].hint + "</span>" +
                "<div class='hint-translations'>" + PARAM_hintsObjectsArray[i].translation.join("<br>") + "</div>" +
                "</div>";
        }
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
        if (window.hintsObjectsArray[i].hint === hint) {
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
            let jsonHintsStringForTranlation = 'jsonHintsStringForTranlation=' + encodeURIComponent(JSON.stringify(resultString));
            request.open("POST", 'php/ex_add_hints_to_translation.php', true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(jsonHintsStringForTranlation);


            document.querySelector("#hints-area").innerHTML = "<span id='select-result' class='result'>" +
                resultString.join(", ") +
                "</span>";
            let resultNode = document.querySelector("#select-result");
            resultNode.addEventListener('click', selectResult);
            function selectResult() {
                let selectRange = document.createRange();
                selectRange.selectNodeContents(this);
                let select = window.getSelection();
                select.removeAllRanges();
                select.addRange(selectRange);
            }
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
    deleteDeselectedHints();

    if (typeof window.hintsObjectsArray !== "undefined") {

        let listResultArray = [];

        for (let i = 0; i < window.hintsObjectsArray.length; i++) {
            listResultArray[i] = "<div class='rank-hint-box'>" +
                "<span class='bold'>" + window.hintsObjectsArray[i].hint + "</span>" +
                "</div>";
        }
        document.querySelector("#hints-area").innerHTML = "<div id='rank-hints-list'>" + listResultArray.join("") + "</div>";

        $(function () {
            $("#rank-hints-list").sortable().disableSelection();
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
            rankHintsBoxes[i].innerText = rankHintsBoxes[i].innerText.replace('&amp;', '&');
            rankHintsBoxes[i].innerText = rankHintsBoxes[i].innerText.replace('&', '&amp;');
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
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
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
        }
        else {
            delete window.hintsObjectsArray;
            countHintsTotalAndSelected();
            document.querySelector("#hints-area").innerHTML = "Список подсказок пуст.";
        }
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего очищать.";
    }
}

function sortAz() {
    clearErrors();
    if (typeof window.hintsObjectsArray !== "undefined") {
        function compareObjectHints(a, b) {
            if (a.hint > b.hint) return 1;
            if (a.hint < b.hint) return -1;
        }
        window.hintsObjectsArray.sort(compareObjectHints);
        createHTMLHintsList(window.hintsObjectsArray);
    } else {
        document.querySelector("#hints-area").innerHTML = "Нечего сортировать.";
    }
}

function keywordwPatternToQuery() {
    let lastKws = document.querySelector("#basic-keywords-string").value;

    if (lastKws !== "" || lastKws.trim() !== "") {
        document.querySelector("#basic-keywords-string").value = lastKws.trim() + "\n" + this.innerHTML.replace('&amp;', '&');
    } else {
        document.querySelector("#basic-keywords-string").value = this.innerHTML.replace('&amp;', '&');
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

    getBasicKeywordsButtonBigstockphoto.disabled = true;
    getBasicKeywordsButtonBigstockphoto.value = "…";
    getBasicKeywordsButtonBigstockphoto.style.background = "#dddddd";
    getBasicKeywordsButtonBigstockphoto.style.cursor = "default";

    getBasicKeywordsButtonDepositphotos.disabled = true;
    getBasicKeywordsButtonDepositphotos.value = "…";
    getBasicKeywordsButtonDepositphotos.style.background = "#dddddd";
    getBasicKeywordsButtonDepositphotos.style.cursor = "default";

    getBasicKeywordsButton123rf.disabled = true;
    getBasicKeywordsButton123rf.value = "…";
    getBasicKeywordsButton123rf.style.background = "#dddddd";
    getBasicKeywordsButton123rf.style.cursor = "default";
}

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

function clearErrors() {
    document.querySelector("#error-hints").innerHTML = "";
    document.querySelector("#error-translations").innerHTML = "";
}
