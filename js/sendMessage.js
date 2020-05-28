let sendMessageButton = document.querySelector("#sendMessageButton");
// let messageForm = document.querySelector("#messageForm"); — уже объявлена в первее загруженном скрипте controlMessage.js.

sendMessageButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendMessage("get_message.php");
}, false);

function sendMessage(url) {
    let messageText = messageForm.value;
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
