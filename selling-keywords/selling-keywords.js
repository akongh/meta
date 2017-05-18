var getSellingKeywordsButton = document.querySelector('#get-selling-keywords-button');

getSellingKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    getSellingKeywordsData("selling_keywords.php");
}, false);


function getSellingKeywordsData(PARAM_url) {

    var keyword = "keyword=" + encodeURIComponent(document.querySelector('#keyword').value);
    var imageType = "imageType=" + document.querySelector("input[name='image_type']:checked").value;
    var SellingKeywordsRequest = keyword + '&' + imageType;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {

        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#selling-keywords-data").innerHTML = request.responseText;

            enableGetBasicKeywordsButton();
        }
        ;
    }
    ;
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(SellingKeywordsRequest);

    disableGetBasicKeywordsButton();
};


function disableGetBasicKeywordsButton() {
    getSellingKeywordsButton.disabled = true;
    getSellingKeywordsButton.value = "…";
    getSellingKeywordsButton.style.background = "#dddddd";
    getSellingKeywordsButton.style.cursor = "default";
};


function enableGetBasicKeywordsButton() {
    getSellingKeywordsButton.disabled = false;
    getSellingKeywordsButton.value = "Получить продавшие ключевые слова";
    getSellingKeywordsButton.style.background = "";
    getSellingKeywordsButton.style.cursor = "";
};