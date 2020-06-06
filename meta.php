<?php

declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

//var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>МЕТА. Набор инстументов для подбора ключевых слов</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="css/style.css"
          type="text/css">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/analytics_code.php"); ?>
</head>
<body>
<div class="wrap">
    <h1>МЕТА</h1>
    <h2>Набор инстументов для подбора ключевых слов</h2>
    <div class="content_right">
        <a href="/keyword_selection/keyword_selection.php"
           title="Начать подбирать ключевые слова">[Русско-английский подбор]</a>
    </div>
    <div class="content_right">
        <a href="/search_hints/search_hints.php"
           title="Начать исследовать подсказки ключевых слов">[Поисковые подсказки]</a>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
</body>
</html>
