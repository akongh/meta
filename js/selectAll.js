var title = document.getElementsByTagName("h1");
title[0].addEventListener("click", selectAll);


function selectAll() {
    var keywordCheckbox = document.getElementsByName("slova_s_flagom[]");
    for (var i = 0; i <= keywordCheckbox.length; i++) {
        keywordCheckbox[i].checked = true;
    }
    ;
};