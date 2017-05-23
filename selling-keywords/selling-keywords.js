var getSellingKeywordsButton = document.querySelector('#get-selling-keywords-button');
var resultNode = document.querySelector("#selling-keywords-string");
var upButtonBlock = document.querySelector("#up-button-block");
var deleteKeywordsObjectsArrayButton = document.querySelector("#delete-keywords-objects-array-button");


window.onload = viewHideUpButton();
getSellingKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    getSellingKeywordsData("selling_keywords.php");
}, false);
resultNode.addEventListener('click', selectResult);
deleteKeywordsObjectsArrayButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteKeywordsObjectsArray();
}, false);
window.addEventListener("scroll", viewHideUpButton);


function getSellingKeywordsData(PARAM_url) {

    var autor = "autor=" + encodeURIComponent(document.querySelector('#autor').value);
    var keyword = "keyword=" + encodeURIComponent(document.querySelector('#keyword').value);
    var imageType = "imageType=" + document.querySelector("input[name='image_type']:checked").value;
    var sellingKeywordsRequest = keyword + '&' + imageType + '&' + autor;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {

        if (request.readyState === 4 && request.status === 200) {
            //console.log(request.responseText);
            if (request.responseText === '-1') {
                document.querySelector("#selling-keywords-string").innerHTML = 'Шаттерсток ничего не выдал.';
            } else {
                window.worksDataObjectsNew = JSON.parse(request.responseText);
                if (typeof window.worksDataObjects !== "undefined") {
                    window.worksDataObjects = window.worksDataObjects.concat(window.worksDataObjectsNew);
                } else {
                    window.worksDataObjects = window.worksDataObjectsNew;
                }
                ;
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
        arraySortUnicSellingKeywords[i]['keyword'] = arrayUnicSellingKeywords[i];
        // arraySortUnicSellingKeywords[i]['sumOrders'] = 0;
        arraySortUnicSellingKeywords[i]['count'] = 0;
        for (j = 0; j < arrayAllSellingKeywords.length; j++) {
            if (arrayUnicSellingKeywords[i] === arrayAllSellingKeywords[j]['keyword']) {
                // arraySortUnicSellingKeywords[i]['sumOrders'] = arraySortUnicSellingKeywords[i]['sumOrders'] + arrayAllSellingKeywords[j]['order'];
                arraySortUnicSellingKeywords[i]['count'] = arraySortUnicSellingKeywords[i]['count'] + 1;
            }
            ;
        }
        ;
        // arraySortUnicSellingKeywords[i]['weght'] = arraySortUnicSellingKeywords[i]['sumOrders'] / arraySortUnicSellingKeywords[i]['count'];
    }
    ;

    arraySortUnicSellingKeywords = _.sortBy(arraySortUnicSellingKeywords, ['count', 'keyword']);//console.log(arraySortUnicSellingKeywords);
    arraySortUnicSellingKeywords = _.map(arraySortUnicSellingKeywords, 'keyword');
    arraySortUnicSellingKeywords = _.reverse(arraySortUnicSellingKeywords);
    document.querySelector("#count-keywords").innerHTML = arraySortUnicSellingKeywords.length.toString();


    return '<span class="result">' + arraySortUnicSellingKeywords.join(', ') + '</span>';
    ;
};


function createWorksList() {
    var worksData = window.worksDataObjectsNew;
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
            '</table>';
    }
    ;


    return worksList.join("<hr><br><br><br>") + '<hr>';
};


function countKeywords() {
    var countKeywords = 0;
    if (typeof window.worksDataObjects !== "undefined") {
        countKeywords = window.worksDataObjects.length;
    }
    ;
    document.querySelector("#count-keywords").innerHTML = countKeywords;
};


function selectResult() {
    var selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    var select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
};


function deleteKeywordsObjectsArray() {
    if (typeof window.worksDataObjects !== "undefined") {
        delete window.worksDataObjects;
        countKeywords();
        document.querySelector("#selling-keywords-string").innerHTML = "Строка результата пуста.";
    } else {
        document.querySelector("#selling-keywords-string").innerHTML = "Нечего удалять.";
    }
    ;
};


function viewHideUpButton() {
    if (resultNode.getBoundingClientRect().top < 0) {
        upButtonBlock.style.display = "inline-block";
    } else {
        upButtonBlock.style.display = "none";
    }
    ;
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