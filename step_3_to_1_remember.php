<?php

declare(strict_types=1);
error_reporting(-1);

//var_dump($_POST);

if (isset($_POST["arr_kws_marked"]) and count($_POST["arr_kws_marked"]) > 0) {
    if (isset($_SESSION["arr_kws_state"]) and count($_SESSION["arr_kws_state"]) > 0) {
        $_SESSION["arr_kws_state"] = array_values(array_unique(array_merge($_SESSION["arr_kws_state"], $_POST["arr_kws_marked"])));
    } else {
        $_SESSION["arr_kws_state"] = $_POST["arr_kws_marked"];
    }
}

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
