<?php
declare(strict_types=1);
error_reporting(-1);

//var_dump($_POST);

unset($_SESSION["error_messages"]);

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

if (!isset($_POST["arr_kws_marked"]) || count($_POST["arr_kws_marked"]) < 8) {
    $_SESSION["error_messages"][] = meta_error_mesage(4);
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php");
    exit;
} else {
    $_SESSION["arr_kws_assembled_marked"] = $_POST["arr_kws_marked"];
    $_SESSION["arr_kws_ordered"] = $_SESSION["arr_kws_assembled_marked"];
}

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_4.php");
