<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include($_SERVER['DOCUMENT_ROOT'] . '/php/sql_prepared_statements.php');

unset( $_POST );

$_SQL_rezultat_priority_kws = $mysqli->query( SQL_ZAPROS_priority_kws );
$data                  = $_SQL_rezultat_priority_kws->fetch_all(MYSQLI_ASSOC);

foreach ( $data as $key => $val ) {
    $_MASSIV_priority_kws[ $key ] = $val['s'];
}

if ( isset($_MASSIV_priority_kws) && $_MASSIV_priority_kws != null ) {
    $_MASSIV_spisok_priority_kws       = implode( "<br>", $_MASSIV_priority_kws );
    $_SESSION["queue_kws_for_translation"] = "
    <span class='counter'>" . count( $_MASSIV_priority_kws ) . "</span>
    ";
} else {
    $_MASSIV_spisok_priority_kws = "Заявок на перевод пока нет.";
}

$mysqli->close();
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
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/analytics_code.php');?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/link_to_index.php' );?>
    <br>
    <a href="/step_1.php" title="Начать подбирать ключевые слова">К подбору</a>
    <br>
    <br>
    <h1 class="bold">Очередь заявок на перевод</h1>
    <br>
    <br>
    <br>
    <?php echo $_MASSIV_spisok_priority_kws;?>
    <br>
    <br>
    <?php if (isset($_SESSION["queue_kws_for_translation"])) {echo $_SESSION["queue_kws_for_translation"];};?>
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
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' );?>
</div>
</body>
</html>
