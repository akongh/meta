let resultNode = document.querySelectorAll("span[name='select-result']");

for (let i = 0; i < resultNode.length; i++) {
    resultNode[i].addEventListener('click', selectResult);
    // resultNode[i].addEventListener("copy", function (e) {
    //     e.preventDefault();
    //     e.clipboardData.setData('text/plain', e.target.textContent);
    // });
}

let resultNodeNotTransl = document.querySelectorAll("span[name='result-no-transl']");

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
