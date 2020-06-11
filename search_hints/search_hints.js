let getBasicKeywordsButtonShutterstock = document.querySelector("#get-basic-keywords-button-shutterstock");
// let getBasicKeywordsButtonIstockphoto = document.querySelector("#get-basic-keywords-button-istockphoto");
// let getBasicKeywordsButtonGetty = document.querySelector("#get-basic-keywords-button-getty");
// let getBasicKeywordsButtonFotolia = document.querySelector("#get-basic-keywords-button-fotolia");
// let getBasicKeywordsButtonBigstockphoto = document.querySelector("#get-basic-keywords-button-bigstockphoto");
// let getBasicKeywordsButtonDepositphotos = document.querySelector("#get-basic-keywords-button-depositphotos");
// let getBasicKeywordsButton123rf = document.querySelector("#get-basic-keywords-button-123rf");
let clearButton = document.querySelector("#clear-button");


getBasicKeywordsButtonShutterstock.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetHintsCreateHTMLHintsListShutterstock("php/ex_hints_shutterstock.php");
}, false);
// getBasicKeywordsButtonIstockphoto.addEventListener("click", function (e) {
//     e.preventDefault();
//     sendQueryGetHintsCreateHTMLHintsListIstockphoto("php/ex_hints_istockphoto.php");
// }, false);
// getBasicKeywordsButtonGetty.addEventListener("click", function (e) {
//     e.preventDefault();
//     sendQueryGetHintsCreateHTMLHintsListGetty("php/ex_hints_gettyimages.php");
// }, false);
// getBasicKeywordsButtonFotolia.addEventListener("click", function (e) {
//     e.preventDefault();
//     sendQueryGetHintsCreateHTMLHintsListFotolia("php/ex_hints_fotolia.php");
// }, false);
// getBasicKeywordsButtonBigstockphoto.addEventListener("click", function (e) {
//     e.preventDefault();
//     sendQueryGetHintsCreateHTMLHintsListBigstockphoto("php/ex_hints_bigstockphoto.php");
// }, false);
// getBasicKeywordsButtonDepositphotos.addEventListener("click", function (e) {
//     e.preventDefault();
//     sendQueryGetHintsCreateHTMLHintsListDepositphotos("php/ex_hints_depositphotos.php");
// }, false);
// getBasicKeywordsButton123rf.addEventListener("click", function (e) {
//     e.preventDefault();
//     sendQueryGetHintsCreateHTMLHintsList123rf("php/ex_hints_123rf.php");
// }, false);
clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearQuery();
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

                window.hintsObjectsArray = JSON.parse(request.responseText);

                createHTMLHintsList(window.hintsObjectsArray);
                setTimeout("enableGetBasicKeywordsButton()", 200);
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
}

// function sendQueryGetHintsCreateHTMLHintsListIstockphoto(PARAM_url) {
//     disableGetBasicKeywordsButton();
//
//     let request = new XMLHttpRequest();
//     let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
//
//     request.onreadystatechange = function () {
//         if (request.readyState === 4 && request.status === 200) {
//             if (request.responseText === "-1") {
//                 document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-2") {
//                 document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-3") {
//                 document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
//                 enableGetBasicKeywordsButton();
//             } else {
//
//                 let resultArray = JSON.parse(request.responseText);
//
//                 if (typeof window.hintsObjectsArray !== "undefined") {
//                     for (let i = 0; i < resultArray.length; i++) {
//                         for (let j = 0; j < window.hintsObjectsArray.length; j++) {
//                             if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
//                                 resultArray.splice(i, 1);
//                                 i--;
//                                 break;
//                             }
//                         }
//                     }
//                     // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
//                     window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
//                 } else {
//                     window.hintsObjectsArray = resultArray;
//                 }
//
//                 createHTMLHintsList(window.hintsObjectsArray);
//                 setTimeout("enableGetBasicKeywordsButton()", 200);
//             }
//         }
//     }
//     request.open("POST", PARAM_url, true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send(basicKeywordsString);
// }
//
// function sendQueryGetHintsCreateHTMLHintsListGetty(PARAM_url) {
//     disableGetBasicKeywordsButton();
//
//     let request = new XMLHttpRequest();
//     let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
//
//     request.onreadystatechange = function () {
//         if (request.readyState === 4 && request.status === 200) {
//             if (request.responseText === "-1") {
//                 document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-2") {
//                 document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-3") {
//                 document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
//                 enableGetBasicKeywordsButton();
//             } else {
//
//                 let resultArray = JSON.parse(request.responseText);
//
//                 if (typeof window.hintsObjectsArray !== "undefined") {
//                     for (let i = 0; i < resultArray.length; i++) {
//                         for (let j = 0; j < window.hintsObjectsArray.length; j++) {
//                             if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
//                                 resultArray.splice(i, 1);
//                                 i--;
//                                 break;
//                             }
//                         }
//                     }
//                     // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
//                     window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
//                 } else {
//                     window.hintsObjectsArray = resultArray;
//                 }
//
//                 createHTMLHintsList(window.hintsObjectsArray);
//                 setTimeout("enableGetBasicKeywordsButton()", 200);
//             }
//         }
//     }
//     request.open("POST", PARAM_url, true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send(basicKeywordsString);
// }
//
// function sendQueryGetHintsCreateHTMLHintsListFotolia(PARAM_url) {
//     disableGetBasicKeywordsButton();
//
//     let request = new XMLHttpRequest();
//     let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
//
//     request.onreadystatechange = function () {
//         if (request.readyState === 4 && request.status === 200) {
//             if (request.responseText === "-1") {
//                 document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-2") {
//                 document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-3") {
//                 document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
//                 enableGetBasicKeywordsButton();
//             } else {
//                 let resultArray = JSON.parse(request.responseText);
//
//                 if (typeof window.hintsObjectsArray !== "undefined") {
//                     for (let i = 0; i < resultArray.length; i++) {
//                         for (let j = 0; j < window.hintsObjectsArray.length; j++) {
//                             if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
//                                 resultArray.splice(i, 1);
//                                 i--;
//                                 break;
//                             }
//                         }
//                     }
//                     // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
//                     window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
//                 } else {
//                     window.hintsObjectsArray = resultArray;
//                 }
//
//                 createHTMLHintsList(window.hintsObjectsArray);
//                 setTimeout("enableGetBasicKeywordsButton()", 200);
//             }
//         }
//     }
//     request.open("POST", PARAM_url, true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send(basicKeywordsString);
// }
//
// function sendQueryGetHintsCreateHTMLHintsListBigstockphoto(PARAM_url) {
//     disableGetBasicKeywordsButton();
//
//     let request = new XMLHttpRequest();
//     let type = "type=" + document.querySelector("input[name='type']:checked").value;
//     let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
//     let requestSet = basicKeywordsString + "&" + type;
//
//     request.onreadystatechange = function () {
//         if (request.readyState === 4 && request.status === 200) {
//             if (request.responseText === "-1") {
//                 document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-2") {
//                 document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-3") {
//                 document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
//                 enableGetBasicKeywordsButton();
//             } else {
//
//                 let resultArray = JSON.parse(request.responseText);
//
//                 if (typeof window.hintsObjectsArray !== "undefined") {
//                     for (let i = 0; i < resultArray.length; i++) {
//                         for (let j = 0; j < window.hintsObjectsArray.length; j++) {
//                             if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
//                                 resultArray.splice(i, 1);
//                                 i--;
//                                 break;
//                             }
//                         }
//                     }
//                     // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
//                     window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
//                 } else {
//                     window.hintsObjectsArray = resultArray;
//                 }
//
//                 createHTMLHintsList(window.hintsObjectsArray);
//                 setTimeout("enableGetBasicKeywordsButton()", 200);
//             }
//         }
//     }
//     request.open("POST", PARAM_url, true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send(requestSet);
// }
//
// function sendQueryGetHintsCreateHTMLHintsListDepositphotos(PARAM_url) {
//     disableGetBasicKeywordsButton();
//
//     let request = new XMLHttpRequest();
//     let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
//
//     request.onreadystatechange = function () {
//         if (request.readyState === 4 && request.status === 200) {
//             if (request.responseText === "-1") {
//                 document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-2") {
//                 document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
//                 enableGetBasicKeywordsButton();
//             } else {
//
//                 let resultArray = JSON.parse(request.responseText);
//
//                 if (typeof window.hintsObjectsArray !== "undefined") {
//                     for (let i = 0; i < resultArray.length; i++) {
//                         for (let j = 0; j < window.hintsObjectsArray.length; j++) {
//                             if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
//                                 resultArray.splice(i, 1);
//                                 i--;
//                                 break;
//                             }
//                         }
//                     }
//                     // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
//                     window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
//                 } else {
//                     window.hintsObjectsArray = resultArray;
//                 }
//
//                 createHTMLHintsList(window.hintsObjectsArray);
//                 setTimeout("enableGetBasicKeywordsButton()", 200);
//             }
//         }
//     }
//     request.open("POST", PARAM_url, true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send(basicKeywordsString);
// }
//
// function sendQueryGetHintsCreateHTMLHintsList123rf(PARAM_url) {
//     disableGetBasicKeywordsButton();
//
//     let request = new XMLHttpRequest();
//     let basicKeywordsString = "basicKeywordsString=" + encodeURIComponent(document.querySelector("#basic_keywords_string").value);
//
//     request.onreadystatechange = function () {
//         if (request.readyState === 4 && request.status === 200) {
//             if (request.responseText === "-1") {
//                 document.querySelector("#error-hints").innerHTML = "Не более 16-ти опорных ключевых слов.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-2") {
//                 document.querySelector("#error-hints").innerHTML = "Только латиница, цифры, пробел, дефис, апостроф и амперсанд.";
//                 enableGetBasicKeywordsButton();
//             } else if (request.responseText === "-3") {
//                 document.querySelector("#error-hints").innerHTML = "Необходимо хоть одно опорное ключевое слово.";
//                 enableGetBasicKeywordsButton();
//             } else {
//
//                 let resultArray = JSON.parse(request.responseText);
//
//                 if (typeof window.hintsObjectsArray !== "undefined") {
//                     for (let i = 0; i < resultArray.length; i++) {
//                         for (let j = 0; j < window.hintsObjectsArray.length; j++) {
//                             if (window.hintsObjectsArray[j].hint === resultArray[i].hint) {
//                                 resultArray.splice(i, 1);
//                                 i--;
//                                 break;
//                             }
//                         }
//                     }
//                     // window.hintsObjectsArray = resultArray.concat(window.hintsObjectsArray);
//                     window.hintsObjectsArray = window.hintsObjectsArray.concat(resultArray);
//                 } else {
//                     window.hintsObjectsArray = resultArray;
//                 }
//
//                 createHTMLHintsList(window.hintsObjectsArray);
//                 setTimeout("enableGetBasicKeywordsButton()", 200);
//             }
//         }
//     }
//     request.open("POST", PARAM_url, true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send(basicKeywordsString);
// }

function createHTMLHintsList(PARAM_hintsObjectsArray) {
    let listResultArray = [];

    for (let i = 0; i < PARAM_hintsObjectsArray.length; i++) {
        listResultArray[i] = "<div id='hint-box'>" +
            PARAM_hintsObjectsArray[i] +
            "</div>";
    }
    document.querySelector("#hints-area").innerHTML = listResultArray.join("");
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

function disableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = true;
    getBasicKeywordsButtonShutterstock.value = "";
    getBasicKeywordsButtonShutterstock.style.background = "#dddddd";
    getBasicKeywordsButtonShutterstock.style.cursor = "default";

    // getBasicKeywordsButtonIstockphoto.disabled = true;
    // getBasicKeywordsButtonIstockphoto.value = "";
    // getBasicKeywordsButtonIstockphoto.style.background = "#dddddd";
    // getBasicKeywordsButtonIstockphoto.style.cursor = "default";
    //
    // getBasicKeywordsButtonGetty.disabled = true;
    // getBasicKeywordsButtonGetty.value = "";
    // getBasicKeywordsButtonGetty.style.background = "#dddddd";
    // getBasicKeywordsButtonGetty.style.cursor = "default";
    //
    // getBasicKeywordsButtonFotolia.disabled = true;
    // getBasicKeywordsButtonFotolia.value = "";
    // getBasicKeywordsButtonFotolia.style.background = "#dddddd";
    // getBasicKeywordsButtonFotolia.style.cursor = "default";
    //
    // getBasicKeywordsButtonBigstockphoto.disabled = true;
    // getBasicKeywordsButtonBigstockphoto.value = "";
    // getBasicKeywordsButtonBigstockphoto.style.background = "#dddddd";
    // getBasicKeywordsButtonBigstockphoto.style.cursor = "default";
    //
    // getBasicKeywordsButtonDepositphotos.disabled = true;
    // getBasicKeywordsButtonDepositphotos.value = "";
    // getBasicKeywordsButtonDepositphotos.style.background = "#dddddd";
    // getBasicKeywordsButtonDepositphotos.style.cursor = "default";
    //
    // getBasicKeywordsButton123rf.disabled = true;
    // getBasicKeywordsButton123rf.value = "";
    // getBasicKeywordsButton123rf.style.background = "#dddddd";
    // getBasicKeywordsButton123rf.style.cursor = "default";
}

function enableGetBasicKeywordsButton() {
    getBasicKeywordsButtonShutterstock.disabled = false;
    getBasicKeywordsButtonShutterstock.value = "От Шаттерстока";
    getBasicKeywordsButtonShutterstock.style.background = "";
    getBasicKeywordsButtonShutterstock.style.cursor = "";

    // getBasicKeywordsButtonIstockphoto.disabled = false;
    // getBasicKeywordsButtonIstockphoto.value = "От Айстокфото";
    // getBasicKeywordsButtonIstockphoto.style.background = "";
    // getBasicKeywordsButtonIstockphoto.style.cursor = "";
    //
    // getBasicKeywordsButtonGetty.disabled = false;
    // getBasicKeywordsButtonGetty.value = "От Геттиимаджес";
    // getBasicKeywordsButtonGetty.style.background = "";
    // getBasicKeywordsButtonGetty.style.cursor = "";
    //
    // getBasicKeywordsButtonFotolia.disabled = false;
    // getBasicKeywordsButtonFotolia.value = "От Фотолии";
    // getBasicKeywordsButtonFotolia.style.background = "";
    // getBasicKeywordsButtonFotolia.style.cursor = "";
    //
    // getBasicKeywordsButtonBigstockphoto.disabled = false;
    // getBasicKeywordsButtonBigstockphoto.value = "От Бигстокфото";
    // getBasicKeywordsButtonBigstockphoto.style.background = "";
    // getBasicKeywordsButtonBigstockphoto.style.cursor = "";
    //
    // getBasicKeywordsButtonDepositphotos.disabled = false;
    // getBasicKeywordsButtonDepositphotos.value = "От Депозитфотос";
    // getBasicKeywordsButtonDepositphotos.style.background = "";
    // getBasicKeywordsButtonDepositphotos.style.cursor = "";
    //
    // getBasicKeywordsButton123rf.disabled = false;
    // getBasicKeywordsButton123rf.value = "От 123РФ";
    // getBasicKeywordsButton123rf.style.background = "";
    // getBasicKeywordsButton123rf.style.cursor = "";
}
