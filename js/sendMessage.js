let textMessageMaxLength = 240; // Установка [maxLength] продублирована в [step_6.html (textarea id="textMessageForm")].
let textMessageForm = document.querySelector("#textMessageForm");
let countInformer = document.querySelector("#countInformer");
let clearButton = document.querySelector("#clearButton");
let sendMessageButton = document.querySelector("#sendMessageButton");

textMessageForm.maxLength = textMessageMaxLength;
countInformer.innerHTML = textMessageMaxLength;

textMessageForm.addEventListener("input", checkMesageLength);

clearButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearMessage();
}, false);

sendMessageButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendMessage("get_message.php");
}, false);

function checkMesageLength() {
    countInformer.innerHTML = textMessageMaxLength - textMessageForm.value.length;
}

function clearMessage() {
    textMessageForm.value = "";
    countInformer.innerHTML = textMessageMaxLength;
}

function sendMessage(url) {
    let messageText = textMessageForm.value;
    messageText = 'messageText=' + messageText;
    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#messageBlock").style.display = "none";
            document.querySelector("#responseMessage").innerHTML = request.responseText;
        }
    };

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(messageText);
}
