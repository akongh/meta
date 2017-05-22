var getSellingKeywordsButton = document.querySelector('#get-selling-keywords-button');
var resultNode = document.querySelector("#selling-keywords-string");

getSellingKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    getSellingKeywordsData("selling_keywords.php");
}, false);
resultNode.addEventListener('click', selectResult);


function getSellingKeywordsData(PARAM_url) {

    var keyword = "keyword=" + encodeURIComponent(document.querySelector('#keyword').value);
    var imageType = "imageType=" + document.querySelector("input[name='image_type']:checked").value;
    var sellingKeywordsRequest = keyword + '&' + imageType;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {

        if (request.readyState === 4 && request.status === 200) {
            //console.log(request.responseText);
            if (request.responseText === '-1') {
                document.querySelector("#selling-keywords-string").innerHTML = 'Шаттерсток ничего не выдал.';
            } else {
                window.worksDataObjects = JSON.parse(request.responseText);
                document.querySelector("#selling-keywords-string").innerHTML = createSellingKeywordsString();
                document.querySelector("#works-list").innerHTML = createWorksList();
            }
            ;

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


function createSellingKeywordsString() {

    var arrayAllSellingKeywords = [];
    var tempCount = 0;

    for (var i = 0; i < window.worksDataObjects.length; i++) {
        for (var j = 0; j < window.worksDataObjects[i].keywords.length; j++) {
            arrayAllSellingKeywords[tempCount] = [];
            arrayAllSellingKeywords[tempCount]['keyword'] = window.worksDataObjects[i].keywords[j].keyword;
            arrayAllSellingKeywords[tempCount]['order'] = j;
            tempCount++;
        }
        ;
    }
    ;

    var arrayUnicSellingKeywords = [];

    for (i = 0; i < arrayAllSellingKeywords.length; i++) {
        arrayUnicSellingKeywords[i] = arrayAllSellingKeywords[i]['keyword'];
    }
    ;

    arrayUnicSellingKeywords = _.uniq(arrayUnicSellingKeywords);
    var arraySortUnicSellingKeywords = [];

    for (i = 0; i < arrayUnicSellingKeywords.length; i++) {
        arraySortUnicSellingKeywords[i] = [];
        arraySortUnicSellingKeywords[i]['sumOrders'] = 0;
        arraySortUnicSellingKeywords[i]['count'] = 0;
        for (j = 0; j < arrayAllSellingKeywords.length; j++) {
            if (arrayUnicSellingKeywords[i] === arrayAllSellingKeywords[j]['keyword']) {
                arraySortUnicSellingKeywords[i]['keyword'] = arrayUnicSellingKeywords[i];
                arraySortUnicSellingKeywords[i]['sumOrders'] = arraySortUnicSellingKeywords[i]['sumOrders'] + arrayAllSellingKeywords[j]['order'];
                arraySortUnicSellingKeywords[i]['count'] = arraySortUnicSellingKeywords[i]['count'] + 1;
                arraySortUnicSellingKeywords[i]['weght'] = arraySortUnicSellingKeywords[i]['sumOrders'] / arraySortUnicSellingKeywords[i]['count'];
            }
            ;
        }
        ;
    }
    ;

    arraySortUnicSellingKeywords = _.sortBy(arraySortUnicSellingKeywords, ['count', 'weght']);
    arraySortUnicSellingKeywords = _.map(arraySortUnicSellingKeywords, 'keyword');
    arraySortUnicSellingKeywords = _.reverse(arraySortUnicSellingKeywords);
    document.querySelector("#count-keywords").innerHTML = arraySortUnicSellingKeywords.length.toString();


    return '<span class="result">' + arraySortUnicSellingKeywords.join(', ') + '</span>';
    ;
};


function createWorksList() {
    var worksData = window.worksDataObjects;
    var worksList = [];
    for (var i = 0; i < worksData.length; i++) {
        var kws = [];
        for (var j = 0; j < worksData[i].keywords.length; j++) {
            kws[j] = '<tr><td><span>' +
                worksData[i].keywords[j].keyword +
                '</span></td><td class="right">' +
                (Math.round((parseFloat(worksData[i].keywords[j].percentage) * 100) * 100) / 100).toFixed(2) +
                '%</td></tr>';
        }
        ;
        worksList[i] = '<span class="bold">' +
            worksData[i].title +
            '</span><br><br>' +
            worksData[i].img +
            '<table class="table-kws">' +
            kws.join("") +
            '</table><br><br><br><br>';
    }
    ;


    return worksList.join("<hr><br><br>");
};


function selectResult() {
    var selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    var select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
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