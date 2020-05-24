<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

if (isset($_SESSION["arr_kws_ru"])) {
    $str_kws_ru = implode(", ", $_SESSION["arr_kws_ru"]);
    $count_kws_ru = count($_SESSION["arr_kws_ru"]);
} else {
    $str_kws_ru = "";
    $count_kws_ru = 0;
}

if (isset($_SESSION["arr_kws_en"])) {
    $str_kws_en = implode(", ", $_SESSION["arr_kws_en"]);
    $count_kws_en = count($_SESSION["arr_kws_en"]);
} else {
    $str_kws_en = "";
    $count_kws_en = 0;
}

if (isset($_SESSION["arr_kws_untranslated"])) {
    $str_kws_untranslated = implode(", ", $_SESSION["arr_kws_untranslated"]);
    $count_kws_untranslated = count($_SESSION["arr_kws_untranslated"]);
} else {
    $str_kws_untranslated = "";
    $count_kws_untranslated = 0;
}

var_dump($_POST);
var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>6/6. Результат строками</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php'); ?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php'); ?>
    <br>
    <br>
    <h1 class="bold">6/6. Результат строками</h1>
    <br>
    <br>
    <br>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php'); ?>
        <span id="help"
              class="help hidden">
            1. <span class="bold">Чтобы выбрать текст</span>, просто щёлкните по нему.<br>
            2. <span class="bold">«Изменить вид на единый»</span>&nbsp;— объединяет результаты на русском и&nbsp;на английском
            в&nbsp;один текст из двух абзацев для единого выделения и&nbsp;копирования.<br>
            3. <span class="bold">«Изменить вид на раздельный»</span>&nbsp;— разделяет результаты на русском и&nbsp;на английском
            на два текста по одному абзацу для раздельного выделения и&nbsp;копирования.
        </span>
    </div>
    <br>
    <div id="separate-result-view">
        <span class="content-right">
            <a id="single-view-button"
               class="link-button"
               href="#"
               title="Изменить вид результата на единый">[Изменить вид на единый]</a>
        </span>
        <br>
        <br>
        <h2 class="bold">На русском</h2>
        <br>
        <span class="result"><?php echo $str_kws_ru; ?></span>
        <span class="counter"><?php echo $count_kws_ru; ?></span>
        <br>
        <br>
        <br>
        <br>
        <h2 class="bold">На английском</h2>
        <br>
        <span class="result"><?php echo $str_kws_en; ?></span>
        <span class="counter"><?php echo $count_kws_en; ?></span>
    </div>
    <div id="single-result-view"
         class="hidden">
        <span class="content-right">
            <a id="separate-view-button"
               class="link-button"
               href="#"
               title="Изменить вид результата на раздельный">[Изменить вид на раздельный]</a>
        </span>
        <br>
        <br>
        <h2 class="bold">На русском и английском</h2>
        <br>
        <span class="result">
            <?php echo $str_kws_ru; ?>
            <br>
            <br>
            <?php echo $str_kws_en; ?>
        </span>
        <br>
        <br>
        <span class="counter">
            <?php echo $count_kws_ru; ?> / <?php echo $count_kws_en; ?>
        </span>
    </div>
    <br>
    <br>
    <br>
    <br>
    <h2 class='bold'>Непереведённые</h2>
    <br>
    <span class='result'
          name='result-no-transl'><?php echo $str_kws_untranslated; ?></span>
    <span class='counter'><?php echo $count_kws_untranslated; ?></span>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <span id="messageBlock">
        Обратная связь.
        <br>
        <span class="content-right">
            <span class="counter">
                <span id="countInformer">
                </span>
            </span>
        </span>
        <textarea id="messageForm"
                  class="textarea-message"
                  wrap="soft"
                  rows="4"
                  placeholder=""
                  maxlength="240"></textarea>
        <!-- Установка [maxLength] продублирована в [js/controlMessage.js (var maxLength)]. -->
        <br>
        <br>
    </span>
    <div id="responseMessage"
         class="content-right">
        <a id="clearButton"
           class="link-button"
           href="#"
           title="Очистить поле отзыва">[x]</a>
        <a id="sendMessageButton"
           class="link-button"
           href="#"
           title="Отправить отзыв">[Отправить]</a>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_reset_and_start_over.php"); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/changeResultView.js"></script>
<script src="/js/selectResult.js"></script>
<script src="/js/controlMessage.js"></script>
<script src="/js/sendMessage.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
