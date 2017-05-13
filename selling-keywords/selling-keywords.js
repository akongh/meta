var jsonSellingKeywords = document.querySelector('#json-selling-keywords');
var parceJsonSellingKeywordsButton = document.querySelector('#parce-json-selling-keywords-button');

parceJsonSellingKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    parceJsonSellingKeywords("parce_json_selling_keywords.php");
}, false);

function parceJsonSellingKeywords(PARAM_url) {
    var request = new XMLHttpRequest();
    var jsonSellingKeywordsRequest = "jsonSellingKeywords=" + encodeURIComponent(jsonSellingKeywords.value);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#selling-keywords-list").innerHTML = request.responseText;
        }
        ;
    }
    ;
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(jsonSellingKeywordsRequest);
};