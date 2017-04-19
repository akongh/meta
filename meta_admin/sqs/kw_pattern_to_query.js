/**
 * Created by Andrei on 19.04.2017.
 */

var arrPatterns = document.querySelectorAll("span[name='pattern-kw']");

for (var i = 0; i <= arrPatterns.length; i++) {
    arrPatterns[i].addEventListener("click", kwPatternToQuery);
}

function kwPatternToQuery() {
    document.querySelector("textarea[name='kw']").innerHTML = this.innerHTML;
}