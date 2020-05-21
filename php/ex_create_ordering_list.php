<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');

if (!isset($_POST["arr_kws_marked"]) || count($_POST["arr_kws_marked"]) < 8) {
    $_SESSION["err_msg_of_kws_amount"] = "В наборе менее 8-ми уникальных ключевых слов.";
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php");
    exit;
} else {
    $_SESSION["arr_kws_marked"] = $_POST["arr_kws_marked"];
}

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_4.php");
