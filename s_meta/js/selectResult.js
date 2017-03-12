/**
 * Created by Andrei on 11.03.2017.
 */

var resultNode = document.querySelectorAll(".select_result");
for (var i = 0; i < resultNode.length; i++){
    resultNode[i].addEventListener('click', selectResult);
};

function selectResult() {
    var selectRange = document.createRange();
    selectRange.selectNode(this);
    var select = window.getSelection();
    select.removeAllRanges();
    select.addRange(selectRange);
};