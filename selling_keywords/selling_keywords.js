let getSellingKeywordsButton = document.querySelector('#get-selling-keywords-button');
let resultNode = document.querySelector("#selling-keywords-string");
let upButtonBlock = document.querySelector("#up-button-block");
let deleteKeywordsObjectsArrayButton = document.querySelector("#delete-keywords-objects-array-button");
let authors = document.querySelectorAll(".hover-invert");
let deleteAuthorButton = document.querySelector("#delete-author-button");
let clearKeywordButton = document.querySelector("#clear-keyword-button");
let createVariantsQueriesButton = document.querySelector("#create-variants-queries-button");
let deleteVariantsQueriesButton = document.querySelector("#delete-variants-queries-button");

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
for (let i = 0; i < authors.length; i++) {
    authors[i].addEventListener("click", function (e) {
        e.stopPropagation();
    }, false);
    authors[i].addEventListener("click", authorsToQuery);
}
deleteAuthorButton.addEventListener("click", function (e) {
    e.preventDefault();
    deleteAuthor();
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

/**
 * Functions.
 */

function createArrayKeywordsFromVariants() {
    let arrayKeywordsFromVariants = [];
    let arrayCheckedFromVariants = document.querySelectorAll(".variant-checkbox:checked");
    for (let i = 0; i < arrayCheckedFromVariants.length; i++) {
        arrayKeywordsFromVariants[i] = arrayCheckedFromVariants[i].value;
    }
    return arrayKeywordsFromVariants;
}

function getSellingKeywordsData() {
    let keyword;
    let imageType = "imageType=" + document.querySelector("input[name='image_type']:checked").value;
    let author = "author=" + encodeURIComponent(document.querySelector('#author').value);
    let sellingKeywordsRequest;
    if (document.querySelector('input[name="use-variant-queries"]').checked === true && typeof window.variantsQueriesArray !== 'undefined') {
        let arrayKeywordsFromVariants = createArrayKeywordsFromVariants();
        let i = 0;
        function getWithTimeout() {
            keyword = "keyword=" + encodeURIComponent(arrayKeywordsFromVariants[i]);
            sellingKeywordsRequest = keyword + '&' + imageType + '&' + author;
            sendPapamsGetSellingKeywords("create_array_works_data.php", sellingKeywordsRequest, 1, arrayKeywordsFromVariants[i]);
            i++;
            if (i < arrayKeywordsFromVariants.length) setTimeout(getWithTimeout, 4000);
        }

        getWithTimeout();
    } else {
        keyword = "keyword=" + encodeURIComponent(document.querySelector('#keyword').value);
        sellingKeywordsRequest = keyword + '&' + imageType + '&' + author;
        sendPapamsGetSellingKeywords("create_array_works_data.php", sellingKeywordsRequest, 0, document.querySelector('#keyword').value);
    }
}

function sendPapamsGetSellingKeywords(PARAM_url, PARAM_sellingKeywordsRequest, PARAM_useVariants, PARAM_sellingKeyword) {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === '-1') {
                if (typeof window.worksDataObjects === "undefined") {
                    document.querySelector("#selling-keywords-string").innerHTML = 'Шаттерсток ничего не выдал.';
                }
                if (PARAM_useVariants === 1) {
                    document.querySelector('#status').innerHTML = PARAM_sellingKeyword;
                }
            } else {
                window.worksDataObjectsNew = JSON.parse(request.responseText);
                if (typeof window.worksDataObjects !== "undefined") {
                    window.worksDataObjects = window.worksDataObjects.concat(window.worksDataObjectsNew);
                } else {
                    window.worksDataObjects = window.worksDataObjectsNew;
                }
                document.querySelector("#selling-keywords-string").innerHTML = createSellingKeywordsString();
                if (PARAM_useVariants === 0) {
                    document.querySelector("#works-list").innerHTML = createWorksList();
                } else {
                    document.querySelector('#status').innerHTML = PARAM_sellingKeyword;
                }
            }
            enableGetBasicKeywordsButton();
            // console.dir(request.responseText);
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(PARAM_sellingKeywordsRequest);
    disableGetBasicKeywordsButton();
}

function createSellingKeywordsString() {
    let arrayAllSellingKeywords = [];
    let tempCount = 0;
    for (let i = 0; i < window.worksDataObjects.length; i++) {
        if (undefined !== window.worksDataObjects[i].keywords) {
            for (let j = 0; j < window.worksDataObjects[i].keywords.length; j++) {
                arrayAllSellingKeywords[tempCount] = [];
                arrayAllSellingKeywords[tempCount]['keyword'] = window.worksDataObjects[i].keywords[j].keyword;
                arrayAllSellingKeywords[tempCount]['order'] = j;
                tempCount++;
            }
        }
    }
    let arrayUnicSellingKeywords = [];
    for (let i = 0; i < arrayAllSellingKeywords.length; i++) {
        arrayUnicSellingKeywords[i] = arrayAllSellingKeywords[i]['keyword'];
    }
    arrayUnicSellingKeywords = _.uniq(arrayUnicSellingKeywords);
    let arraySortUnicSellingKeywords = [];
    for (let i = 0; i < arrayUnicSellingKeywords.length; i++) {
        arraySortUnicSellingKeywords[i] = [];
        arraySortUnicSellingKeywords[i]['keyword'] = arrayUnicSellingKeywords[i];
        // arraySortUnicSellingKeywords[i]['sumOrders'] = 0;
        arraySortUnicSellingKeywords[i]['count'] = 0;
        for (let j = 0; j < arrayAllSellingKeywords.length; j++) {
            if (arrayUnicSellingKeywords[i] === arrayAllSellingKeywords[j]['keyword']) {
                // arraySortUnicSellingKeywords[i]['sumOrders'] = arraySortUnicSellingKeywords[i]['sumOrders'] + arrayAllSellingKeywords[j]['order'];
                arraySortUnicSellingKeywords[i]['count'] = arraySortUnicSellingKeywords[i]['count'] + 1;
            }
        }
        // arraySortUnicSellingKeywords[i]['weght'] = arraySortUnicSellingKeywords[i]['sumOrders'] / arraySortUnicSellingKeywords[i]['count'];
    }
    arraySortUnicSellingKeywords = _.sortBy(arraySortUnicSellingKeywords, ['count', 'keyword']);
    arraySortUnicSellingKeywords = _.map(arraySortUnicSellingKeywords, 'keyword');
    arraySortUnicSellingKeywords = _.reverse(arraySortUnicSellingKeywords);
    window.arraySortUnicSellingKeywords = arraySortUnicSellingKeywords;
    countKeywords();
    return '<span>' + arraySortUnicSellingKeywords.join(', ') + '</span>';
}

function createWorksList() {
    let worksData = window.worksDataObjectsNew;
    let worksList = [];
    for (let i = 0; i < worksData.length; i++) {
        let kws = [];
        if (undefined !== worksData[i].keywords) {
            for (let j = 0; j < worksData[i].keywords.length; j++) {
                kws[j] = '<tr><td><span>' +
                    worksData[i].keywords[j].keyword +
                    '</span></td><td class="right">' +
                    (Math.round((parseFloat(worksData[i].keywords[j].percentage) * 100) * 100) / 100).toFixed(2) +
                    '%</td></tr>';
            }
        }
        worksList[i] = '<span class="bold">' +
            worksData[i].title +
            '</span><br><br>' +
            worksData[i].img +
            '<div>' +
            '<a href="https://www.shutterstock.com/pic-' +
            worksData[i].id +
            '" target="_blank">'
            + worksData[i].id +
            '</a><br><br><table class="table-kws">' +
            kws.join("") +
            '</table></div>';
    }
    return worksList.join("<hr><br><br><br>") + '<hr>';
}

function authorsToQuery() {
    document.querySelector("#author").value = this.innerHTML;
}

function deleteAuthor() {
    document.querySelector("#author").value = '';
}

function clearKeyword() {
    document.querySelector("#keyword").value = '';
}

function createVariantsQueries(PARAM_url) {
    let request = new XMLHttpRequest();
    let fullStringQuery = 'level=' + document.querySelector('#level').value + '&fullStringQuery=' + document.querySelector('#keyword').value.trim();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText === '-1') {
                document.querySelector("#variants-queries-list").innerHTML = 'Не из чего создавать варианты.';
            } else {
                window.variantsQueriesArray = JSON.parse(request.responseText);
                displayVariantsQueries();
            }
        }
    }
    request.open("POST", PARAM_url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(fullStringQuery);
}

function displayVariantsQueries() {
    let variantsQueriesArrayHTML = [];
    let a = window.variantsQueriesArray.length - 1;
    for (let i = 0; i < window.variantsQueriesArray.length; i++) {
        variantsQueriesArrayHTML[i] = '<tr><td><label class="variant-checkbox-label"><input class="variant-checkbox" name="variant-checkbox" type="checkbox" checked value="' +
            window.variantsQueriesArray[i] +
            '"></label></td><td class="variant-query-td"><div class="variant-query" name="variant-query">' +
            window.variantsQueriesArray[i] +
            '</div></td></tr>';
    }
    document.querySelector("#variants-queries-list").innerHTML = '<table class="variant-query-table">' + _.join(variantsQueriesArrayHTML, '\n') + '</table>';
    let variantsQueries = document.querySelectorAll("div[name='variant-query']");
    for (let i = 0; i < variantsQueries.length; i++) {
        variantsQueries[i].addEventListener("click", variantQueryToQuery);
    }
}

function variantQueryToQuery() {
    document.querySelector("#keyword").value = this.innerText;
}

function deleteVariantsQueries() {
    if (document.querySelector("#variants-queries-list").innerHTML === 'Без вариантов.' ||
        document.querySelector("#variants-queries-list").innerHTML === 'Варианты удалены.' ||
        document.querySelector("#variants-queries-list").innerHTML === 'Не из чего создавать варианты.' ||
        document.querySelector("#variants-queries-list").innerHTML === 'Нечего удалять.') {
        document.querySelector("#variants-queries-list").innerHTML = 'Нечего удалять.';
    } else {
        document.querySelector("#variants-queries-list").innerHTML = 'Варианты удалены.';
    }
}

function countKeywords() {
    let countKeywords = 0;
    if (typeof window.arraySortUnicSellingKeywords !== "undefined") {
        countKeywords = window.arraySortUnicSellingKeywords.length;
    }
    document.querySelector("#count-keywords").innerHTML = countKeywords.toString();
}

function selectResult() {
    let selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    let select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
}

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
}

function viewHideUpButton() {
    if (resultNode.getBoundingClientRect().top < 0) {
        upButtonBlock.style.display = "inline-block";
    } else {
        upButtonBlock.style.display = "none";
    }
}

function disableGetBasicKeywordsButton() {
    getSellingKeywordsButton.disabled = true;
    getSellingKeywordsButton.value = "";
    getSellingKeywordsButton.style.background = "#dddddd";
    getSellingKeywordsButton.style.cursor = "default";
}

function enableGetBasicKeywordsButton() {
    getSellingKeywordsButton.disabled = false;
    getSellingKeywordsButton.value = "Получить продавшие ключевые слова";
    getSellingKeywordsButton.style.background = "";
    getSellingKeywordsButton.style.cursor = "";
}
