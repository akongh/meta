<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

require($_SERVER["DOCUMENT_ROOT"] . "/_privacy_path.php");
require($_SERVER["DOCUMENT_ROOT"] . "/sql_prepared_statements.php");

$mysqli_result = $mysqli->query(SQL_SELECT_COUNT_TRANSLATED_KWS);
$arr_result = $mysqli_result->fetch_array();
$mysqli_result->free();
$count_translated = number_format((float)$arr_result[0], 0, "", "&nbsp;");

$mysqli_result = $mysqli->query(SQL_SELECT_COUNT_KWS_FOR_TRANSLATION);
$arr_result = $mysqli_result->fetch_array();
$mysqli_result->free();
$count_request = number_format((float)$arr_result[0], 0, "", "&nbsp;");

$mysqli->close();

//var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Русско-английский сервис подбора ключевых слов для&nbsp;стоков</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="css/style.css"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/analytics_code.php"); ?>
</head>
<body>
<div class="wrap">
    <h1>МЕТА</h1>
    <h2>Русско-английский сервис подбора ключевых слов для&nbsp;стоков</h2>
    <div class="meta_info">
        <p>
            Ключевых слов переведено
            <span class="amount"><?php if (isset($count_translated)) {
                    echo "{$count_translated}";
                }; ?></span>
        </p>
        <p>
            В <a href="/queue_for_translation.php"
                 title="Список ключевых слов, добавленных пользователями в очередь на перевод">очереди на перевод</a>
            <span class="amount"><?php if (isset($count_request)) {
                    echo $count_request;
                }; ?></span>
        </p>
    </div>
    <div class="content_right">
        <a href="/step_1.php"
           title="Начать подбирать ключевые слова">[Русско-английский подбор]</a>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"); ?>
</div>
</body>
</html>
