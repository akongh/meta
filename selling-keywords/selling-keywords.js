var getSellingKeywordsButton = document.querySelector('#get-selling-keywords-button');
var resultNode = document.querySelector("#selling-keywords-string");
var upButtonBlock = document.querySelector("#up-button-block");
var deleteKeywordsObjectsArrayButton = document.querySelector("#delete-keywords-objects-array-button");
var autors = document.querySelectorAll(".hover-invert");
var deleteAutorButton = document.querySelector("#delete-autor-button");
var clearKeywordButton = document.querySelector("#clear-keyword-button");
var createVariantsQueriesButton = document.querySelector("#create-variants-queries-button");
var deleteVariantsQueriesButton = document.querySelector("#delete-variants-queries-button");


window.onload = viewHideUpButton();
getSellingKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    getSellingKeywordsData();
}, false);
resultNode.addEventListener('click', selectResult);
deleteKeywordsObjectsArrayButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteKeywordsObjectsArray();
}, false);
for (var i = 0; i < autors.length; i++) {
    autors[i].addEventListener("click", function (e) {
        e.stopPropagation();
    }, false);
    autors[i].addEventListener("click", autorsToQuery);
}
;
deleteAutorButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteAutor();
}, false);
clearKeywordButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearKeyword();
}, false);
createVariantsQueriesButton.addEventListener("click", function (e) {
    e.preventDefault();
    createVariantsQueries('create_variants_queries_list.php');
}, false);
deleteVariantsQueriesButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteVariantsQueries();
}, false);
window.addEventListener("scroll", viewHideUpButton);


function createArrayKeywordsFromVariants() {
    var arrayKeywordsFromVariants = [];
    var arrayCheckedFromVariants = document.querySelectorAll(".variant-checkbox:checked");
    for (i = 0; i < arrayCheckedFromVariants.length; i++) {
        arrayKeywordsFromVariants[i] = arrayCheckedFromVariants[i].value;
    }
    ;
    return arrayKeywordsFromVariants;
};


function getSellingKeywordsData() {
    var keyword;
    var imageType = "imageType=" + document.querySelector("input[name='image_type']:checked").value;
    var autor = "autor=" + encodeURIComponent(document.querySelector('#autor').value);
    var sellingKeywordsRequest;

    if (document.querySelector('input[name="use-variant-queries"]').checked === true && typeof window.variantsQueriesArray !== 'undefined') {
        var arrayKeywordsFromVariants = createArrayKeywordsFromVariants();
        // console.log(arrayKeywordsFromVariants);
        var i = 0;

        function getWitsTimeout() {
            keyword = "keyword=" + encodeURIComponent(arrayKeywordsFromVariants[i]);
            sellingKeywordsRequest = keyword + '&' + imageType + '&' + autor;
            sendPapamsGetSellingKeywords("selling_keywords.php", sellingKeywordsRequest, 1, arrayKeywordsFromVariants[i]);
            i++;
            if (i < arrayKeywordsFromVariants.length) setTimeout(getWitsTimeout, 4000);
        };
        getWitsTimeout();
    } else {
        keyword = "keyword=" + encodeURIComponent(document.querySelector('#keyword').value);
        sellingKeywordsRequest = keyword + '&' + imageType + '&' + autor;
        sendPapamsGetSellingKeywords("selling_keywords.php", sellingKeywordsRequest, 0, document.querySelector('#keyword').value);
    }
    ;
};


function sendPapamsGetSellingKeywords(PARAM_url, PARAM_sellingKeywordsRequest, PARAM_useVariants, PARAM_sellingKeyword) {
    // console.log(PARAM_sellingKeywordsRequest);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {

        if (request.readyState === 4 && request.status === 200) {
            //console.log(request.responseText);
            if (request.responseText === '-1') {
                if (typeof window.worksDataObjects === "undefined") {
                    document.querySelector("#selling-keywords-string").innerHTML = 'Шаттерсток ничего не выдал.';
                }
                ;
                document.querySelector('#status').innerHTML = PARAM_sellingKeyword;
            } else {
                window.worksDataObjectsNew = JSON.parse(request.responseText);
                if (typeof window.worksDataObjects !== "undefined") {
                    window.worksDataObjects = window.worksDataObjects.concat(window.worksDataObjectsNew);
                } else {
                    window.worksDataObjects = window.worksDataObjectsNew;
                }
                ;
                document.querySelector("#selling-keywords-string").innerHTML = createSellingKeywordsString();
                if (PARAM_useVariants === 0) {
                    document.querySelector("#works-list").innerHTML = createWorksList();
                } else {
                    document.querySelector('#status').innerHTML = PARAM_sellingKeyword;
                }
                ;
            }
            ;

            enableGetBasicKeywordsButton();
            // console.dir(request.responseText);
        }
        ;
    }
    ;
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(PARAM_sellingKeywordsRequest);

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
    window.arraySortUnicSellingKeywords = arraySortUnicSellingKeywords;
    countKeywords();


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
            '<div>' +
            worksData[i].id +
            '<br><br><table class="table-kws">' +
            kws.join("") +
            '</table></div>';
    }
    ;


    return worksList.join("<hr><br><br><br>") + '<hr>';
};


function autorsToQuery() {
    document.querySelector("#autor").value = this.innerHTML;
};


function deleteAutor() {
    document.querySelector("#autor").value = '';
};

function clearKeyword() {
    document.querySelector("#keyword").value = '';
};


function createVariantsQueries(PARAM_url) {
    var request = new XMLHttpRequest();
    var fullStringQuery = 'level=' + document.querySelector('#level').value + '&fullStringQuery=' + document.querySelector('#keyword').value.trim();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            // console.log(request.responseText);
            if (request.responseText === '-1') {
                document.querySelector("#variants-queries-list").innerHTML = 'Не из чего создавать варианты.';
            } else {
                window.variantsQueriesArray = JSON.parse(request.responseText);//console.log(window.variantsQueries);
                displayVariantsQueries();
            }
            ;
        }
        ;
    }
    ;
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(fullStringQuery);
};


function displayVariantsQueries() {
    var variantsQueriesArrayHTML = [];

    for (i = 0; i < window.variantsQueriesArray.length; i++) {
        variantsQueriesArrayHTML[i] = '<tr><td><label class="variant-checkbox-label"><input class="variant-checkbox" name="variant-checkbox" type="checkbox" checked value="' +
            window.variantsQueriesArray[i] +
            '"></label></td><td class="variant-query-td"><div class="variant-query" name="variant-query">' +
            window.variantsQueriesArray[i] +
            '</div></td></tr>';
    }
    ;
    // console.log(variantsQueriesArrayHTML);
    document.querySelector("#variants-queries-list").innerHTML = '<table class="variant-query-table">' + _.join(variantsQueriesArrayHTML, '\n') + '</table>';
    var variantsQueries = document.querySelectorAll("div[name='variant-query']");
    for (i = 0; i < variantsQueries.length; i++) {
        variantsQueries[i].addEventListener("click", variantQueryToQuery);
    }
    ;
};


function variantQueryToQuery() {
    document.querySelector("#keyword").value = this.innerText;
};


function deleteVariantsQueries() {
    if (document.querySelector("#variants-queries-list").innerHTML === 'Без вариантов.' ||
        document.querySelector("#variants-queries-list").innerHTML === 'Варианты удалены.' ||
        document.querySelector("#variants-queries-list").innerHTML === 'Не из чего создавать варианты.' ||
        document.querySelector("#variants-queries-list").innerHTML === 'Нечего удалять.') {
        document.querySelector("#variants-queries-list").innerHTML = 'Нечего удалять.';
    } else {
        document.querySelector("#variants-queries-list").innerHTML = 'Варианты удалены.';
    }
    ;
};


function countKeywords() {
    var countKeywords = 0;
    if (typeof window.arraySortUnicSellingKeywords !== "undefined") {
        countKeywords = window.arraySortUnicSellingKeywords.length;
    }
    ;
    document.querySelector("#count-keywords").innerHTML = countKeywords.toString();
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
        delete window.worksDataObjectsNew;
        delete window.arraySortUnicSellingKeywords;
        countKeywords();
        document.querySelector('#status').innerHTML = '';
        document.querySelector("#selling-keywords-string").innerHTML = "Строка результата пуста.";
        document.querySelector('#works-list').innerHTML = 'Список произведений пуст.';
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