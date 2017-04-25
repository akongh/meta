var clearButton = document.querySelector("#clearButton");

clearButton.addEventListener("click", clearQuery);

function clearQuery() {
    document.querySelector("textarea[name='basic-keywords-string']").value = "";
}