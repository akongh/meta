let maxLength = 240;//Установка [maxLength] продублирована в [step_6.html (textarea id="messageForm")].
let messageForm = document.querySelector("#messageForm"); // Используется далее в скрипте sendMessage.js.
let countInformer = document.querySelector("#countInformer");
let clearButton = document.querySelector("#clearButton");

messageForm.maxLength = maxLength;
countInformer.innerHTML = maxLength;

messageForm.addEventListener("input", checkMesageLength);

clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearMessage();
}, false);

function checkMesageLength() {
    countInformer.innerHTML = maxLength - messageForm.value.length;
}

function clearMessage() {
    messageForm.value = "";
    countInformer.innerHTML = maxLength;
}
