<?php

declare(strict_types=1);
error_reporting(-1);

//var_dump($_POST);

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

if (!isset($_POST["arr_kws_marked"]) || count($_POST["arr_kws_marked"]) < 8) {
    if (isset($_POST["arr_kws_marked"])) {
        $_SESSION["arr_kws_assembled_marked"] = $_POST["arr_kws_marked"];
    }
    $_SESSION["error_messages"][] = meta_error_mesage(4);
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/keyword_selection/step_3.php");
    exit;
} else {
    $_SESSION["arr_kws_assembled_marked"] = $_POST["arr_kws_marked"];
    $_SESSION["arr_kws_ordered"] = $_SESSION["arr_kws_assembled_marked"];
}

header("Location: //" . $_SERVER["HTTP_HOST"] . "/keyword_selection/step_4.php");
