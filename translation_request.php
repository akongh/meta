<?php error_reporting( - 1 );
session_start();
session_unset();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

unset( $_POST );

include( $_SERVER['DOCUMENT_ROOT'] . '/sql/SQL_translation_queue.php' );
$_SQL_rezultat_ochered = mysqli_query( $db_connect, $_SQL_zapros_ochered );

$n = 0;
while ( $data = mysqli_fetch_array( $_SQL_rezultat_ochered ) ) {
    $_MASSIV_ochered[ $n ] = $data['s'];
    $n ++;
}

if ( isset($_MASSIV_ochered) && $_MASSIV_ochered != null ) {
    $_MASSIV_spisok_ochered       = implode( "<br>", $_MASSIV_ochered );
    $_SESSION["kol_slov_ochered"] = "
    <span class='counter'>" . count( $_MASSIV_ochered ) . "</span>
    ";
} else {
    $_MASSIV_spisok_ochered = "Заявок на перевод пока нет.";
}

mysqli_close( $db_connect );
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Очередь заявок на перевод</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/native.css"
          rel="stylesheet"
          type="text/css">
    <link rel="shortcut icon"
          href="http://<?php echo $site_domain_name ?>/favicon.ico"
          type="image/ven.microsoft.ico">
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/yandex_metric_meta.php' );?>
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
    <?php echo $_MASSIV_spisok_ochered;?>
    <br>
    <br>
    <?php if (isset($_SESSION["kol_slov_ochered"])) {echo $_SESSION["kol_slov_ochered"];};?>
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
