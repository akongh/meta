/**
 * Created by Andrei on 11.03.2017.
 */

var resultNode = document.querySelectorAll("span[name='select-result']");
for (var i = 0; i < resultNode.length; i++) {
    resultNode[i].addEventListener('click', selectResult);
    resultNode[i].addEventListener("copy", function (e) {
        e.preventDefault();
        e.clipboardData.setData('text/plain', e.target.textContent);
    });
}
;

var resultNodeNotTransl = document.querySelectorAll("span[name='result-no-transl']");
for (var i = 0; i < resultNodeNotTransl.length; i++) {
    resultNodeNotTransl[i].addEventListener('click', selectResult);
    resultNodeNotTransl[i].addEventListener("copy", function (e) {
        e.preventDefault();
        e.clipboardData.setData('text/plain', e.target.textContent);
    });
}
;

function selectResult() {
    var selectRange = document.createRange();
    selectRange.selectNode(this);
    var select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
};