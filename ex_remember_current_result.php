<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

$_SESSION["arr_kws_state"] = $_SESSION["arr_kws_assembled"];

unset(
    $_SESSION["err_msg_of_kws_amount"]
);

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
