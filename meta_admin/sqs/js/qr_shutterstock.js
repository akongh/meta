var getBasicKeywordsButton = document.querySelector("#get-basic-keywords-button");

getBasicKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQuery("php/ex_sqs_shutterstock.php");
}, false);

function sendQuery(url) {
    hideGetBasicKeywordsButton();

    var request = new XMLHttpRequest();
    var mediaType = "mediaType=" + document.querySelector("input[name='media-type']:checked").value;
    var basicKeywordsString = "basicKeywordsString=" + document.querySelector("#basic-keywords-string").value;
    var requestSet = basicKeywordsString + "&" + mediaType;
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#hints-list").innerHTML = request.responseText;
            setTimeout("visibleGetBasicKeywordsButton()", 1000);
        }
        ;
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
};

function hideGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = true;
    getBasicKeywordsButton.value = "Ждём…";
    getBasicKeywordsButton.style.background = "#dddddd";
    getBasicKeywordsButton.style.cursor = "default";
}

function visibleGetBasicKeywordsButton() {
    getBasicKeywordsButton.disabled = false;
    getBasicKeywordsButton.value = "Глянуть";
    getBasicKeywordsButton.style.background = "#ffffff";
    getBasicKeywordsButton.style.cursor = "pointer";
}

// for ( $i = 0; $i < count( $format_data ); $i ++ ) {
//     $format_data_arr[ $i ] = "<tr><td class='table-sqs-patterns'><span id='pattern-kw' class='bold kw-pattern'>" . trim( str_replace( trim( $kw ) . " ", "", $format_data[ $i ]["pattern"] ) ) . "</span></td><td>" . $format_data[ $i ]["probability"] . "</td></tr>\n";
// }
// if ( isset( $format_data_arr ) ) {
//     $format_data_string = "<table class='table-sqs'>\n" . implode( "", $format_data_arr ) . "</table>";
// }