/**
 * Created by Andrei on 20.04.2017.
 */

var clearButton = document.querySelector("#clearButton");

clearButton.addEventListener("click", clearQuery);

function clearQuery() {
    document.querySelector("textarea[name='kw']").value = "";
}