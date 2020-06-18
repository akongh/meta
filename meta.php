<?php

declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

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
    echo file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/../_meta_privacy/analytics_code'); ?>
</head>
<body>
<div class="wrap">
    <h1>МЕТА<br>
        Инстументы для ключевых слов</h1>
    <div class="tool_list">
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
            <p>Подбор ключевых слов на русском с результатами на русском и английском.</p>
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
