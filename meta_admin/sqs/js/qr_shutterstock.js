var getBasicKeywordsButton = document.querySelector("#get-basic-keywords-button");
var stub = document.querySelector("#stub");

getBasicKeywordsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQuery("php/sqs_shutterstock.php");
}, false);

function sendQuery(url) {
    getBasicKeywordsButton.hidden = true;
    stub.hidden = false;
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

function visibleGetBasicKeywordsButton() {
    getBasicKeywordsButton.hidden = false;
    stub.hidden = true;
}


// for ( $i = 0; $i < count( $format_data ); $i ++ ) {
//     $format_data_arr[ $i ] = "<tr><td class='table-sqs-patterns'><span id='pattern-kw' class='bold kw-pattern'>" . trim( str_replace( trim( $kw ) . " ", "", $format_data[ $i ]["pattern"] ) ) . "</span></td><td>" . $format_data[ $i ]["probability"] . "</td></tr>\n";
// }
// if ( isset( $format_data_arr ) ) {
//     $format_data_string = "<table class='table-sqs'>\n" . implode( "", $format_data_arr ) . "</table>";
// }