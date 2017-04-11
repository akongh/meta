var separateViewButton = document.querySelector("#separate-view-button");
var singleViewButton = document.querySelector("#single-view-button");
var separateResultView = document.querySelector("#separate-result-view");
var singleResultView = document.querySelector("#single-result-view");

separateViewButton.addEventListener("click", function (e) {
    e.preventDefault();
    separateView();
}, false);
singleViewButton.addEventListener("click", function (e) {
    e.preventDefault();
    singleView();
}, false);

function separateView() {
    singleResultView.style.display = "none";
    separateResultView.style.display = "inline-block";
};

function singleView() {
    separateResultView.style.display = "none";
    singleResultView.style.display = "inline-block";
};