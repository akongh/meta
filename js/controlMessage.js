var maxLength = 240;//Установка [maxLength] продублирована в [step_6.html (textarea id="messageForm")].
var messageForm = document.querySelector("#messageForm");
var countInformer = document.querySelector("#countInformer");
var clearButton = document.querySelector("#clearButton");

messageForm.maxLength = maxLength;
countInformer.innerHTML = maxLength;

messageForm.addEventListener("input", checkMesageLength);
clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearMessage();
}, false);

function checkMesageLength() {
    countInformer.innerHTML = maxLength - messageForm.value.length;
};
function clearMessage() {
    messageForm.value = "";
    countInformer.innerHTML = maxLength;
};