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
    <title>МЕТА SPECIAL</title>
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
    <h1>МЕТА SPECIAL<br>
        Инстументы для ключевых слов</h1>
    <div class="tool_list">
        <div class="tool_title">
            <h2>
                <a href="/selling_keywords/selling_keywords.php"
                   title="Продавшие ключевые слова на Шаттерстоке">Продавшие ключевые слова</a>
            </h2>
            <p>Получение по поисковому запросу только тех ключевых слов, по которым были проданы произведения на Шаттерстоке.</p></div>
        <div class="tool_title">
            <h2>
                <a href="/set_compiler/set_compiler.php"
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
            <p>Подбор ключевых слов на русском с результатами на русском и английском.</p>
            <a href="/ru_en_selection/management/"
               title="Управление">Управление</a></div>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
<script src="/sendMessage.js"></script>
</body>
</html>
