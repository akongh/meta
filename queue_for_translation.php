<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();

require($_SERVER["DOCUMENT_ROOT"] . "/_privacy_path.php");
require($_SERVER["DOCUMENT_ROOT"] . "/php/sql_prepared_statements.php");

unset($_POST);

$mysqli_result = $mysqli->query(SQL_SELECT_KWS_FOR_TRANSLATION);
$raw_kws_for_translation = $mysqli_result->fetch_all(MYSQLI_ASSOC);
$amount_kws_for_translation = $mysqli_result->num_rows;
$mysqli_result->free();

$mysqli->close();

foreach ($raw_kws_for_translation as $key => $val) {
    $arr_kws_for_translation[$key] = $val["s"];
}

if (isset($arr_kws_for_translation) && $arr_kws_for_translation != null) {
    $html_kws_for_translation = implode("<br>", $arr_kws_for_translation);
} else {
    $html_kws_for_translation = "Заявок на перевод пока нет.";
}

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Очередь заявок на перевод</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <span class="counter"><?php echo $amount_kws_for_translation; ?></span>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h2>
        <!--Перевод прекращён на неопределённое время.-->
        Мы&nbsp;переводим ключевые слова в&nbsp;порядке убывания по&nbsp;их&nbsp;популярности. Переводим вручную, чтобы
        избежать неполноценности автоматического перевода. Ключевых слов не&nbsp;одна тысяча, и&nbsp;поэтому это&nbsp;долгий
        и&nbsp;кропотливый процесс. И&nbsp;хоть уже&nbsp;переведено достаточно ключевых слов, чтобы охватить наиболее
        популярные тематики среди авторов, всё&nbsp;равно встречаются менее используемые и&nbsp;поэтому пока
        непереведённые
        ключевые слова, которые автоматически попадают в&nbsp;список первоочерёдных на&nbsp;перевод при переходе к&nbsp;получению
        результата строками.
        <br>
        <br>
        Данные ключевые слова к&nbsp;таковым и&nbsp;относятся и&nbsp;мы&nbsp;их&nbsp;переведём в&nbsp;течение двух или&nbsp;более
        дней, в&nbsp;зависимости от&nbsp;нашей загрузки.
    </h2>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"); ?>
</div>
</body>
</html>
