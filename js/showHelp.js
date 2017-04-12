var helpButton = document.querySelector("#help-button");
var help = document.querySelector("#help");

helpButton.addEventListener("click", function (e) {
    e.preventDefault();
    showHideHelp();
});

function showHideHelp() {
    help.classList.toggle("hidden");
};