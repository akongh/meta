<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}

if ( isset( $_SESSION["kol_slov_russk"] ) ) {
    $kol_slov_russk = $_SESSION["kol_slov_russk"];
}
if ( isset( $_SESSION["kol_slov_angl"] ) ) {
    $kol_slov_angl = $_SESSION["kol_slov_angl"];
}
if ( isset( $_SESSION["_REZULTAT_russk"] ) ) {
    $_REZULTAT_russk = $_SESSION["_REZULTAT_russk"];
}
if ( isset( $_SESSION["_REZULTAT_angl"] ) ) {
    $_REZULTAT_angl = $_SESSION["_REZULTAT_angl"];
};
if ( isset( $_SESSION["_REZULTAT_russk_neperevedennye"] ) ) {
    $_REZULTAT_russk_neperevedennye = $_SESSION["_REZULTAT_russk_neperevedennye"];
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>6/6. Результат строками</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/native.css"
          rel="stylesheet"
          type="text/css">
    <link rel="shortcut icon"
          href="http://<?php echo $site_domain_name ?>/favicon.ico"
          type="image/ven.microsoft.ico">
    <?php include( 'includes/yandex_metric_meta.php' );?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php include( 'includes/link_to_index.php' );?>
    <br>
    <br>
    <h1 class="bold">6/6. Результат строками</h1>
    <br>
    <br>
    <br>
    <br>
    <div class="content-right">
        <?php include( 'includes/link_help.php' );?><span id="help" class="help hidden">
        1. <span class="bold">Чтобы выбрать текст</span>, просто щёлкните по нему.<br>
        2. <span class="bold">«Изменить вид на единый»</span>&nbsp;— объединяет результаты на русском и&nbsp;на английском
        в&nbsp;один текст из двух абзацев для единого выделения и&nbsp;копирования.<br>
        3. <span class="bold">«Изменить вид на раздельный»</span>&nbsp;— разделяет результаты на русском и&nbsp;на английском
        на два текста по одному абзацу для раздельного выделения и&nbsp;копирования.
        </span><br>
    </div>
    <br>
    <span id="separate-result-view">
    <div class="content-right">
        <a id="single-view-button"
           class="link-button"
           href="#"
           title="Изменить вид результата на единый">[Изменить вид на единый]</a>
    </div>
    <br>
    <br>
    <h2 class="bold">На русском</h2>
    <br>
    <span class="result" name="select-result"><?php if (isset($_REZULTAT_russk)){echo $_REZULTAT_russk;}; ?></span>
    <span class="counter"><?php if (isset($kol_slov_russk)){echo $kol_slov_russk;}; ?></span>
    <br>
    <br>
    <br>
    <br>
    <h2 class="bold">На английском</h2>
    <br>
    <span class="result" name="select-result"><?php if (isset($_REZULTAT_angl)){echo $_REZULTAT_angl;}; ?></span>
    <span class="counter"><?php if (isset($kol_slov_angl)){echo $kol_slov_angl;}; ?></span>
    </span>
    <span id="single-result-view" class="hidden">
    <div class="content-right">
        <a id="separate-view-button"
           class="link-button"
           href="#"
           title="Изменить вид результата на раздельный">[Изменить вид на раздельный]</a>
    </div>
    <br>
    <br>
    <h2 class="bold">На русском и английском</h2>
    <br>
    <span class="result" name="select-result"><?php if (isset($_REZULTAT_russk)){echo $_REZULTAT_russk;}; ?><br>
<br><?php if (isset($_REZULTAT_angl)){echo $_REZULTAT_angl;}; ?></span>
        <br>
        <br>
        <span class="counter"><?php if (isset($kol_slov_russk)){echo $kol_slov_russk;}; ?> / <?php if (isset($kol_slov_angl)){echo $kol_slov_angl;}; ?></span>
    </span>
    <br>
    <br>
    <br>
    <br>
    <?php if (isset($_REZULTAT_russk_neperevedennye)){echo $_REZULTAT_russk_neperevedennye;}; ?>
    <!--<br>-->
    <!--<br>-->
    <!--Рады, что вы выбрали Мету.-->
    <br>
    <br>
    <?php include( 'includes/socialIcons.php' );?>
    <br>
    <br>
    <br>
    <br>
    <span id="messageBlock">
    Обратная связь.
    <br>
    <div class="content-right">
        <span class="counter"><span id="countInformer"></span></span>
    </div>
    <textarea id="messageForm"
              class="textarea-message"
              wrap="soft"
              rows="4"
              placeholder=""
              maxlength="240"></textarea><!-- Установка [maxLength] продублирована в [js/controlMessage.js (var maxLength)]. -->
    <br>
    <br>
    </span>
    <div id="responseMessage" class="content-right">
        <a id="clearButton" class="link-button" href="#" title="Очистить поле отзыва">[x]</a>
        <a id="sendMessageButton" class="link-button" href="#" title="Отправить отзыв">[Отправить]</a>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="content-right">
        <a class="link-button"
           href="../php/reset_choice.php"
           title="Перейти к первому шагу и начать новый подбор">[Начать новый подбор]</a>
    </div>
    <?php include( 'includes/footer.php' );?>
</div>
<script src="../js/changeResultView.js"></script>
<script src="../js/selectResult.js"></script>
<script src="../js/controlMessage.js"></script>
<script src="../js/sendMessage.js"></script>
<script src="../js/showHelp.js"></script>
</body>
</html>
