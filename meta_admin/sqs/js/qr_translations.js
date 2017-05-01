var getTranslationButton = document.querySelector("#get-translation-button");
var clearTranslationButton = document.querySelector("#clear-translation-button");


getTranslationButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetTranslationsCreateHTMLTranslationsList("php/ex_translations.php");
}, false);
clearTranslationButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearTranslationArea();
}, false);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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