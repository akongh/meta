var getSqsButton = document.querySelector("#get_sqs");

getSqsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQuery("php/sqs_shutterstock.php");
}, false);

function sendQuery(url) {
    var request = new XMLHttpRequest();
    var kwString = "kwString=" + document.querySelector("#kw").value;
    var mtRadio = "mtRadio=" + document.querySelector("input[name='mt']:checked").value;
    var requestSet = kwString + "&" + mtRadio;
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#kw-list").innerHTML = request.responseText;
        }
        ;
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
};