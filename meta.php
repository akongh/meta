<?php error_reporting( - 1 );
session_start();
session_unset();
unset( $_POST );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include($_SERVER['DOCUMENT_ROOT'] . '/php/sql_prepared_statements.php');

$SQL_count_translated_words_query = $db_connect->query( SQL_COUNT_TRANSLATED_WORDS_QUERY );
$data                             = $SQL_count_translated_words_query->fetch_array();
$SQL_count_translated_words       = number_format( $data[0], 0, '', '&nbsp;' );

$SQL_count_translation_request_query = $db_connect->query( SQL_COUNT_TRANSLATION_REQUEST_QUERY );
$data                                = $SQL_count_translation_request_query->fetch_array();
$SQL_count_translation_request       = number_format( $data[0], 0, '', '&nbsp;' );

$db_connect->close();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Русско-английский сервис подбора ключевых слов для&nbsp;стоков</title>
    <meta name="Description" content="Подбирайте ключевые слова на русском, результат получайте на английском.
    Для фото, видео, иллюстраций, вектора и других произведений."/>
    <meta name="Keywords" content="ключевые слова фото, ключевые слова перевод, ключевые слова для стоков,
    подбор слов для стоков, подбор ключевых слов для стоков, ключевые слова для фотостока, ключевалка,
    микростоки подбор ключевых"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php');?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <h1 class="bold">
        <span class="meta">МЕТА</span>
        <br>
        <br>
        Русско-английский сервис подбора ключевых слов для&nbsp;стоков
    </h1>
    <br>
    <h2>
        Для тех, кто не знает английского,<br>
        и для тех, кто хочет думать сам.
    </h2>
    <br>
    <br>
    <br>
    <br>
    <h2>
        Думайте и подбирайте ключевые слова к&nbsp;своим произведениям для&nbsp;стоков на&nbsp;русском языке и&nbsp;получайте
        результат с&nbsp;переводом на&nbsp;английский.
    </h2>
    <br>
    <h2>
        Никакой кривой автоматики, каждое ключевое слово проверено и&nbsp;переведено вручную с&nbsp;учётом языковых
        особенностей.
    </h2>
    <br>
    Ключевых слов переведено
    <span class="counter">
        <?php if (isset($SQL_count_translated_words)){echo $SQL_count_translated_words;}; ?></span>,
    в <a href="/translation_request.php" title="Список ключевых слов, добавленных пользователями в очередь на перевод">очереди на перевод</a>
    <span class="counter">
        <?php if (isset($SQL_count_translation_request)){echo $SQL_count_translation_request;}; ?></span>.
    <br>
    <br>
    <br>
    <br>
    <div class="content-right">
        <a class="link-button" href="/step_1.php" title="Начать подбирать ключевые слова">[Русско-английский подбор]</a>
    </div>
    <br>
    <br>
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/socialIcons.php' );?>
    <br>
    <br>
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php' );?>
</div>
</body>
</html>
