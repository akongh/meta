<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

var_dump($_POST);

unset($_SESSION["error_messages"]);

$_SESSION["arr_kws_state"] = $_SESSION["arr_kws_assembled"];

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
