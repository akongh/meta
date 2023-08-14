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
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet"
          href="/_third_party/normalize.css"
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
        Инструменты для ключевых слов</h1>
    <div class="tool_list">
        <div class="tool_title">
            <h2>
                <a href="/ru_en_selection/step_1.php"
                   target="_blank"
                   title="Русско-английский подбор">Русско-английский подбор</a>
            </h2>
            <p>Подбор ключевых слов на русском с результатами на русском и английском.</p>
            <a href="/ru_en_selection/management/"
               target="_blank"
               title="Управление">Управление</a>
        </div>
        <div class="tool_title">
            <h2>
                <a href="/search_hints/search_hints.php"
                   target="_blank"
                   title="Поисковые подсказки">Поисковые подсказки</a>
            </h2>
            <p>Просмотр поисковых подсказок ключевых слов.</p>
        </div>
        <div class="tool_title">
            <h2>
                <a href="/set_compiler/set_compiler.php"
                   target="_blank"
                   title="Составитель наборов">Составитель наборов</a>
            </h2>
            <p>Составление отдельных наборов ключевых слов из одного общего набора.</p>
        </div>
<!--        <div class="tool_title">-->
<!--            <h2>-->
<!--                <a href="/selling_keywords/selling_keywords.php"-->
<!--                   target="_blank"-->
<!--                   title="Продавшие ключевые слова на Шаттерстоке">Продавшие ключевые слова</a>-->
<!--            </h2>-->
<!--            <p>Получение по поисковому запросу только тех ключевых слов, по которым были проданы произведения на Шаттерстоке.</p>-->
<!--        </div>-->
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
</body>
</html>
