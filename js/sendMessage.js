var sendMessageButton = document.querySelector("#sendMessageButton");
var messageForm = document.querySelector("#messageForm");

sendMessageButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendMessage("php/get_message.php");
}, false);

function sendMessage(url) {
    var messageText = messageForm.value;
    var messageText = 'messageText=' + messageText;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#messageBlock").style.display = "none";
            document.querySelector("#responseMessage").innerHTML = request.responseText;
        }
        ;
    };

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(messageText);
};