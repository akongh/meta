<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

if (isset($_SESSION["arr_kws_ru"])) {
    $str_kws_ru = implode(", ", $_SESSION["arr_kws_ru"]);
    $str_kws_ru = htmlspecialchars($str_kws_ru, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    $count_kws_ru = count($_SESSION["arr_kws_ru"]);
} else {
    $str_kws_ru = "";
    $count_kws_ru = 0;
}

if (isset($_SESSION["arr_kws_en"])) {
    $str_kws_en = implode(", ", $_SESSION["arr_kws_en"]);
    $str_kws_en = htmlspecialchars($str_kws_en, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    $count_kws_en = count($_SESSION["arr_kws_en"]);
} else {
    $str_kws_en = "";
    $count_kws_en = 0;
}

if (isset($_SESSION["arr_kws_untranslated"])) {
    $str_kws_untranslated = implode(", ", $_SESSION["arr_kws_untranslated"]);
    $str_kws_untranslated = htmlspecialchars($str_kws_untranslated, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    $count_kws_untranslated = count($_SESSION["arr_kws_untranslated"]);
} else {
    $str_kws_untranslated = "";
    $count_kws_untranslated = 0;
}

//var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>6/6. Результат строками</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="../style.css"
          type="text/css">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/analytics_code.php'); ?>
</head>
<body>
<div class="wrap">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/includes/link_to_index.php'); ?>
    <h1>6/6. Результат строками</h1>
    <div id="separate_result_view">
        <div class="content_right">
            <a id="single_view_button"
               href="##"
               title="Изменить вид результата на единый">[Изменить вид на единый]</a>
        </div>
        <h2>На русском</h2>
        <div class="result"><span><?= $str_kws_ru; ?></span></div>
        <div class="amount_kws">
            <span class="amount"><?= $count_kws_ru; ?></span>
        </div>
        <h2>На английском</h2>
        <div class="result"><span><?= $str_kws_en; ?></span></div>
        <div class="amount_kws">
            <span class="amount"><?= $count_kws_en; ?></span>
        </div>
    </div>
    <div id="single_result_view"
         class="hidden">
        <div class="content_right">
            <a id="separate_view_button"
               href="##"
               title="Изменить вид результата на раздельный">[Изменить вид на раздельный]</a>
        </div>
        <h2>На русском и английском</h2>
        <div class="result">
            <span><?= $str_kws_ru; ?>
                <br>
                <br>
            <?= $str_kws_en; ?></span>
        </div>
        <div class="amount_kws">
            <span class="amount"><?= $count_kws_ru; ?> / <?= $count_kws_en; ?></span>
        </div>
    </div>
    <h2>Непереведённые</h2>
    <div id='result_no_transl'>
        <span><?= $str_kws_untranslated; ?></span>
    </div>
    <div class="amount_kws">
        <span class='amount'><?= $count_kws_untranslated; ?></span>
    </div>
    <div class="back_link">
        <a href="/keyword_selection/step_5.php"
           title="Назад">[<<<< Назад]</a>
    </div>
    <div class="content_right">
        <?php
        require($_SERVER["DOCUMENT_ROOT"] . "/keyword_selection/includes/link_reset_and_start_over.php"); ?>
    </div>
<!--    <div id="messageBlock">-->
<!--        <p>Обратная связь.</p>-->
<!--        <div class="content_right">-->
<!--            <span class="amount">-->
<!--                <span id="lengthMessageInformer"></span>-->
<!--            </span>-->
<!--        </div>-->
<!--        <label>-->
<!--        <textarea id="textMessageForm"-->
<!--                  wrap="soft"-->
<!--                  rows="4"-->
<!--                  placeholder=""-->
<!--                  maxlength="240"></textarea></label>-->
        <!-- Установка [maxLength] продублирована в [js/sendMessage.js (let textMessageMaxLength)]. -->
<!--    </div>-->
<!--    <div id="responseMessage"-->
<!--         class="content_right">-->
<!--        <a id="clearMessageButton"-->
<!--           href="##"-->
<!--           title="Очистить поле отзыва">[x]</a>-->
<!--        <a id="sendMessageButton"-->
<!--           href="##"-->
<!--           title="Отправить отзыв">[Отправить]</a>-->
<!--    </div>-->
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/keyword_selection/js/changeResultView.js"></script>
<script src="/keyword_selection/js/selectResult.js"></script>
<!--<script src="/js/sendMessage.js"></script>-->
</body>
</html>
