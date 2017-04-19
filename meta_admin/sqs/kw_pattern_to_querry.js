/**
 * Created by Andrei on 19.04.2017.
 */

var arrPatterns = document.querySelectorAll("span[name='pattern-kw']");

for (var i = 0; i <= arrPatterns.length; i++) {
    // arrPatterns[i].style.backgroundColor = "red";
    arrPatterns[i].addEventListener("click", kwPatternToQuerry);
}

function kwPatternToQuerry() {
    document.querySelector("textarea[name='kw']").innerHTML = this.innerHTML;
}