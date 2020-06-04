let title = document.getElementsByTagName("h1");

title[0].addEventListener("click", selectAll);

function selectAll() {
    let keywordCheckbox = document.getElementsByName("arr_kws_marked[]");
    for (let i = 0; i < keywordCheckbox.length; i++) {
        keywordCheckbox[i].checked = true;
    }
}
