var getSqsButton = document.querySelector("#get_sqs");
var stubButton = document.querySelector("#stub");

getSqsButton.addEventListener("click", function (e) {
    e.preventDefault();
    sendQuery("php/sqs_shutterstock.php");
}, false);

function sendQuery(url) {
    getSqsButton.hidden=true;
    stubButton.hidden=false;
    var request = new XMLHttpRequest();
    var kwString = "kwString=" + document.querySelector("#kw").value;
    var mtRadio = "mtRadio=" + document.querySelector("input[name='mt']:checked").value;
    var requestSet = kwString + "&" + mtRadio;
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector("#kw-list").innerHTML = request.responseText;
            setTimeout("getSqsButton.hidden=false; stubButton.hidden=true;", 2000);
        }
        ;
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(requestSet);
};





//Форматирование json-ответа
//$format_data = json_decode( $data, true );
//$format_data = $format_data["data"]["autocompletions"];


//for ( $i = 0; $i < count( $format_data ); $i ++ ) {
//    $format_data_arr[ $i ] = str_replace( $kw . " ", "", $format_data[ $i ]["pattern"] ) . " - " . $format_data[ $i ]["probability"];//TODO: А если вырежет в середине ответа?
//}
//if ( isset( $format_data_arr ) ) {
//    $format_data_str = implode( ", ", $format_data_arr );
//} else {
//    $format_data_str = "Нет подсказок.";
//}


//Создание массива строк «ключ-значение»
//for ( $i = 0; $i < count( $format_data ); $i ++ ) {
//    $format_data_arr[ $i ] = "<tr><td class='table-sqs-patterns'><span id='pattern-kw' class='bold kw-pattern'>" . trim( str_replace( trim($kw) . " ", "", $format_data[ $i ]["pattern"] ) ) . "</span></td><td>" . $format_data[ $i ]["probability"] . "</td></tr>\n";
//}
////Создание строки «ключ-значение»
//if ( isset( $format_data_arr ) ) {
//    $format_data_string = "<table class='table-sqs'>\n" . implode( "", $format_data_arr ) . "</table>";
//}