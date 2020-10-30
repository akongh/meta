<?php

declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

require($_SERVER["DOCUMENT_ROOT"] . "/_meta_privacy_db_connection.php");
require($_SERVER["DOCUMENT_ROOT"] . "/sql_prepared_statements.php");

$mysqli_result = $mysqli->query(SQL_SELECT_KWS_FOR_TRANSLATION);
$raw_kws_for_translation = $mysqli_result->fetch_all(MYSQLI_ASSOC);
$amount_kws_for_translation = $mysqli_result->num_rows;
$mysqli_result->free();

$mysqli->close();

if (0 < $amount_kws_for_translation) {
    $arr_kws_for_translation = array();
    foreach ($raw_kws_for_translation as $el) {
        $arr_kws_for_translation[] = htmlspecialchars($el["s"], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
    }
    $html_kws_for_translation = implode("<br>", $arr_kws_for_translation);
} else {
    $html_kws_for_translation = "Заявок на перевод пока нет.";
}

//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Очередь заявок на перевод</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.ru/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
    <?php
    echo file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/../_meta_privacy/analytics_code'); ?>
</head>
<body>
<div class="wrap">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Очередь заявок на перевод</h1>
    <div class="wrap_list_kws">
        <?= $html_kws_for_translation; ?>
    </div>
    <div class="amount_kws">
        <?= "<span class='amount'>{$amount_kws_for_translation}</span>"; ?>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
</body>
</html>
