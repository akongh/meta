let separateViewButton = document.querySelector("#separate_view_button");
let singleViewButton = document.querySelector("#single_view_button");
let separateResultView = document.querySelector("#separate_result_view");
let singleResultView = document.querySelector("#single_result_view");

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
    separateResultView.style.display = "block";
}

function singleView() {
    separateResultView.style.display = "none";
    singleResultView.style.display = "block";
}
