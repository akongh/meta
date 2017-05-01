var getTranslationButton = document.querySelector("#get-translation-button");


getTranslationButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQueryGetTranslationsCreateHTMLTranslationsList("php/ex_translations.php");
}, false);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function sendQueryGetTranslationsCreateHTMLTranslationsList(PARAM_url) {
    document.querySelector("#error").innerHTML = "";

    var request = new XMLHttpRequest();
    var keywordInRussian = "keywordInRussian=" + document.querySelector("#in-russian").value;

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === "-1") {
                document.querySelector("#translations-area").innerHTML = "Перевода нет.";
            } else if (request.responseText === "-2") {
                document.querySelector("#translations-area").innerHTML = "Нечего переводить.";
            } else if (request.responseText === "-3") {
                document.querySelector("#translations-area").innerHTML = "Используйте только кирилицу и цифры.";
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