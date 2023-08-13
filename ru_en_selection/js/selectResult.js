let resultNode = document.querySelectorAll("div[class='result']");

for (let i = 0; i < resultNode.length; i++) {
    resultNode[i].addEventListener('click', selectResult);
}

let resultNodeNotTransl = document.querySelectorAll("div[id='result_no_transl']");

for (let i = 0; i < resultNodeNotTransl.length; i++) {
    resultNodeNotTransl[i].addEventListener('click', selectResult);
}

function selectResult() {
    let selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    let select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
}
