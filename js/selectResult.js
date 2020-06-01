let resultNode = document.querySelectorAll("p[class='result']");
console.log(resultNode);
for (let i = 0; i < resultNode.length; i++) {
    resultNode[i].addEventListener('click', selectResult);
    // resultNode[i].addEventListener("copy", function (e) {
    //     e.preventDefault();
    //     e.clipboardData.setData('text/plain', e.target.textContent);
    // });
}

let resultNodeNotTransl = document.querySelectorAll("p[id='result_no_transl']");
console.log(resultNodeNotTransl);
for (let i = 0; i < resultNodeNotTransl.length; i++) {
    resultNodeNotTransl[i].addEventListener('click', selectResult);
    // resultNodeNotTransl[i].addEventListener("copy", function (e) {
    //     e.preventDefault();
    //     e.clipboardData.setData('text/plain', e.target.textContent);
    // });
}

function selectResult() {
    let selectRange = document.createRange();
    selectRange.selectNodeContents(this);
    let select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
}
