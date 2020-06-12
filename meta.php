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

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/analytics_code.php"); ?>
</head>
<body>
<div class="wrap">
    <h1>МЕТА<br>
        Инстументы для ключевых слов</h1>
    <div class="tool_list">
        <div class="tool_title">
            <h2>
                <a href="/kwsets/kwsets.php"
                   title="Составитель наборов">Составитель наборов</a>
            </h2>
            <p>Составление отдельных наборов ключевых слов из одного общего набора.</p></div>
        <div class="tool_title">
            <h2>
                <a href="/search_hints/search_hints.php"
                   title="Поисковые подсказки">Поисковые подсказки</a>
            </h2>
            <p>Просмотр поисковых подсказок ключевых слов.</p></div>
        <div class="tool_title">
            <h2>
                <a href="/ru_en_selection/step_1.php"
                   title="Русско-английский подбор">Русско-английский подбор</a>
            </h2>
            <p>Подбор ключевых слов на русском с результатами на русском и английском.</p></div>
    </div>
    <div class="meta_info">
        <p>
            Ключевых слов на русском переведено на английский
            <span class="amount"><?php
                if (isset($count_translated)) {
                    echo "{$count_translated}";
                } ?></span>.
        </p>
        <p>
            В <a href="/queue_for_translation.php"
                 title="Список ключевых слов, добавленных пользователями в очередь на перевод">очереди на перевод</a>
            <span class="amount"><?php
                if (isset($count_request)) {
                    echo $count_request;
                } ?></span>.
        </p>
    </div>
    <div class="message_form">
        <div id="messageBlock">
            <p>Обратная связь</p>
            <div class="content_right">
                <span class="amount">
                    <span id="lengthMessageInformer"></span>
                </span>
            </div>
            <label>
            <textarea id="textMessageForm"
                      wrap="soft"
                      rows="4"
                      placeholder=""
                      maxlength="240"></textarea></label>
            <!--Установка [maxLength] продублирована в [/sendMessage.js (let textMessageMaxLength)].-->
        </div>
        <div id="responseMessage"
             class="content_right">
            <a href="#"
               id="clearMessageButton"
               title="Очистить поле текста сообщения">[x]</a>
            <a href="#"
               id="sendMessageButton"
               title="Отправить сообщение">[Отправить]</a>
        </div>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
<script src="/sendMessage.js"></script>
</body>
</html>
