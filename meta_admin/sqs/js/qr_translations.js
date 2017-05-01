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
            } else {

                var resultArray = JSON.parse(request.responseText);

                document.querySelector("#translations-area").innerHTML = createHTMLTranslationsList(resultArray);


            }
            ;
        }
        ;
    };
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(keywordInRussian);
};


function createHTMLTranslationsList(PARAM_translationsAray) {
    return PARAM_translationsAray;
};