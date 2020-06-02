let textMessageMaxLength = 240; // Установка [maxLength] продублирована в [step_6.html (textarea id="textMessageForm")].
let textMessageForm = document.querySelector("#textMessageForm");
let lengthMessageInformer = document.querySelector("#lengthMessageInformer");
let clearMessageButton = document.querySelector("#clearMessageButton");
let sendMessageButton = document.querySelector("#sendMessageButton");

textMessageForm.maxLength = textMessageMaxLength;
lengthMessageInformer.innerHTML = textMessageMaxLength;

textMessageForm.addEventListener("input", checkMesageLength);

clearMessageButton.addEventListener("click", function (e) {
    e.preventDefault();
    clearMessage();
}, false);

sendMessageButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendMessage("get_message.php");
}, false);

function checkMesageLength() {
    lengthMessageInformer.innerHTML = textMessageMaxLength - textMessageForm.value.length;
}

function clearMessage() {
    textMessageForm.value = "";
    lengthMessageInformer.innerHTML = textMessageMaxLength;
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
