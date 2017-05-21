var getSellingKeywordsButton = document.querySelector('#get-selling-keywords-button');

getSellingKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    getSellingKeywordsData("selling_keywords.php");
}, false);


function getSellingKeywordsData(PARAM_url) {

    var keyword = "keyword=" + encodeURIComponent(document.querySelector('#keyword').value);
    var imageType = "imageType=" + document.querySelector("input[name='image_type']:checked").value;
    var sellingKeywordsRequest = keyword + '&' + imageType;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {

        if (request.readyState === 4 && request.status === 200) {

            window.worksDataObjects = JSON.parse(request.responseText);
            document.querySelector("#selling-keywords-data").innerHTML = createWorksLict();

            enableGetBasicKeywordsButton();
        }
        ;
    }
    ;
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(sellingKeywordsRequest);

    disableGetBasicKeywordsButton();
};


function createWorksLict() {
    var worksData = window.worksDataObjects;
    var worksDataList = [];
    for (var i = 0; i < worksData.length; i++) {
        var kws = [];
        for (var j = 0; j < worksData[i].keywords.length; j++) {
            kws[j] = worksData[i].keywords[j].keyword +
                ' - ' +
                Math.round((parseFloat(worksData[i].keywords[j].percentage) * 100) * 100) / 100 +
                '%';
        }
        ;
        worksDataList[i] = worksData[i].title + '<br>' + worksData[i].img + '<br>' + kws.join("<br>");
    }
    ;


    return worksDataList.join("<br>");
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