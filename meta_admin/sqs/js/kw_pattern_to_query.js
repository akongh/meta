var arrPatterns = document.querySelectorAll("#pattern-kw");

for (var i = 0; i < arrPatterns.length; i++) {
    arrPatterns[i].addEventListener("click", kwPatternToQuery);
}

var inputKws = document.querySelector("textarea[name='kw']");
inputKws.focus();
inputKws.selectionStart = inputKws.value.length;

function kwPatternToQuery() {
    // var inputKws = document.querySelector("textarea[name='kw']");
    var lastKws = inputKws.value;

    if (lastKws !== "" || lastKws.trim() !== "") {
        inputKws.value = lastKws.trim() + " " + this.innerHTML;
    } else {
        inputKws.value = this.innerHTML;
    }

    inputKws.focus();
    inputKws.selectionStart = inputKws.value.length;
}