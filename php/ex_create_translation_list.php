<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

$_SESSION["arr_kws_ordered"] = $_POST["arr_kws_marked"];

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_5.php");
