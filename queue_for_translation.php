<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

require($_SERVER["DOCUMENT_ROOT"] . "/_privacy_path.php");
require($_SERVER["DOCUMENT_ROOT"] . "/sql_prepared_statements.php");

$mysqli_result = $mysqli->query(SQL_SELECT_KWS_FOR_TRANSLATION);
$raw_kws_for_translation = $mysqli_result->fetch_all(MYSQLI_ASSOC);
$amount_kws_for_translation = $mysqli_result->num_rows;
$mysqli_result->free();

$mysqli->close();

if (0 < $amount_kws_for_translation) {
    $arr_kws_for_translation = array();
    foreach ($raw_kws_for_translation as $el) {
        $arr_kws_for_translation[] = htmlspecialchars($el["s"], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    }
    $html_kws_for_translation = implode("<br>", $arr_kws_for_translation);
} else {
    $html_kws_for_translation = "Заявок на перевод пока нет.";
}

//var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Очередь заявок на перевод</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/analytics_code.php"); ?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_to_index.php"); ?>
    <br>
    <a href="/step_1.php" title="Начать подбирать ключевые слова">К подбору</a>
    <br>
    <br>
    <h1 class="bold">Очередь заявок на перевод</h1>
    <br>
    <br>
    <br>
    <?php echo $html_kws_for_translation; ?>
    <br>
    <br>
    <?php echo "<span class='counter'>{$amount_kws_for_translation}</span>"; ?>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"); ?>
</div>
</body>
</html>
