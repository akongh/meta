<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

if ( ! isset( $_SESSION["presence_mark"] ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta.php" );
}

if ( isset( $_SESSION["amount_chosen_ru_kws"] ) ) {
    $amount_chosen_ru_kws = $_SESSION["amount_chosen_ru_kws"];
}
if ( isset( $_SESSION["amount_chosen_en_kws"] ) ) {
    $amount_chosen_en_kws = $_SESSION["amount_chosen_en_kws"];
}
if ( isset( $_SESSION["resulting_ru_kws_set"] ) ) {
    $resulting_ru_kws_set = $_SESSION["resulting_ru_kws_set"];
}
if ( isset( $_SESSION["resulting_en_kws_set"] ) ) {
    $resulting_en_kws_set = $_SESSION["resulting_en_kws_set"];
};
if ( isset( $_SESSION["total_untranslated_ru_kws"] ) ) {
    $total_untranslated_ru_kws = $_SESSION["total_untranslated_ru_kws"];
}

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
    <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php' ); ?>
    <br>
    <br>
    <h1 class="bold">6/6. Результат строками</h1>
    <br>
    <br>
    <br>
    <br>
<!--    <div class="notice">-->
<!--        <p class="notice-title">-->
<!--            Удобно извлекайте со&nbsp;стоков подсказки для поисковых запросов с&nbsp;инструментом-->
<!--            <a href="http://meta.afoteris.com/hints/hints.php"-->
<!--               title="Перейти в Мета-подсказки"-->
<!--               target="_blank">«Мета-подсказки»</a>-->
<!--        </p>-->
<!--        <p class="notice-description">Ещё один, действующий на&nbsp;базе Меты, инструмент подбора ключевых слов для&nbsp;стоков-->
<!--            по&nbsp;подсказкам ключевых запросов в&nbsp;строке поиска от&nbsp;некоторых из&nbsp;этих стоков.-->
<!--        </p>-->
<!--        <a href="http://meta.afoteris.com/hints/hints.php"-->
<!--           title="Перейти в Мета-подсказки"-->
<!--           target="_blank">-->
<!--            <img src="images/meta_hints_interface.png" alt="Мета-подсказки"></a>-->
<!--    </div>-->
<!--    <br>-->
<!--    <br>-->
    <div class="content-right">
        <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php' ); ?>
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
        <span class="result"><?php if ( isset( $resulting_ru_kws_set ) ) {
                echo $resulting_ru_kws_set;
            }; ?></span>
        <span class="counter"><?php if ( isset( $amount_chosen_ru_kws ) ) {
                echo $amount_chosen_ru_kws;
            }; ?></span>
        <br>
        <br>
        <br>
        <br>
        <h2 class="bold">На английском</h2>
        <br>
        <span class="result"><?php if ( isset( $resulting_en_kws_set ) ) {
                echo $resulting_en_kws_set;
            }; ?></span>
        <span class="counter"><?php if ( isset( $amount_chosen_en_kws ) ) {
                echo $amount_chosen_en_kws;
            }; ?></span>
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
        <span class="result"><?php if ( isset( $resulting_ru_kws_set ) ) {
                echo $resulting_ru_kws_set;
            }; ?>
            <br>
            <br>
            <?php if ( isset( $resulting_en_kws_set ) ) {
                echo $resulting_en_kws_set;
            }; ?></span>
        <br>
        <br>
        <span class="counter"><?php if ( isset( $amount_chosen_ru_kws ) ) {
                echo $amount_chosen_ru_kws;
            }; ?> / <?php if ( isset( $amount_chosen_en_kws ) ) {
                echo $amount_chosen_en_kws;
            }; ?></span>
    </div>
    <br>
    <br>
    <br>
    <br>
    <?php if ( isset( $total_untranslated_ru_kws ) ) {
        echo $total_untranslated_ru_kws;
    }; ?>
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
        <a class="link-button"
           href="/php/reset_choice.php"
           title="Перейти к первому шагу и начать новый подбор">[Начать новый подбор]</a>
    </div>
    <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php' ); ?>
</div>
<script src="/js/changeResultView.js"></script>
<script src="/js/selectResult.js"></script>
<script src="/js/controlMessage.js"></script>
<script src="/js/sendMessage.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
