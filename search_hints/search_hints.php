<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Поисковые подсказки</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
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
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Поисковые подсказки</h1>
    <label for="basic_keywords_string"></label>
    <input type="text"
           id="basic_keywords_string"
           name="basic_keywords_string"
           class="textarea-keywords"
           placeholder="Опорные ключевые слова"
           autofocus>
    <span id="error-hints"
          class='error'></span>
    <div class="content_right">
        <a href="#"
           id="clear-button"
           class="link-button"
           title="Очистить поле опорных ключевых слов">[x]</a>
    </div>
    <label><input type="radio"
                  name="media_type_shutterstock"
                  value="image"
                  checked> Изображения</label>
    <label><input type="radio"
                  name="media_type_shutterstock"
                  value="audio"> Аудио</label>
    <label><input type="radio"
                  name="media_type_shutterstock"
                  value="video"> Видео</label>
    <input type="submit"
           id="get-basic-keywords-button-shutterstock"
           value="От Шаттерстока">
    <label><input type="radio"
                  name="a_z_youtube"
                  value="no_a-z"
                  checked> no a-z</label>
    <label><input type="radio"
                  name="a_z_youtube"
                  value="a-z"> a-z</label>
    <label for="excluded_keywords_string"></label>
    <input type="text"
           id="excluded_keywords_string"
           name="excluded_keywords_string"
           class="textarea-keywords"
           placeholder="Исключённые ключевые слова через запятую">
    <input type="submit"
           id="get-basic-keywords-button-youtube"
           value="От Ютуба">
    <div id="hints-area" class="result">Список подсказок пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/search_hints/search_hints.js"></script>
<script src="/_third_party/jquery-1.10.2.js"></script>
<script src="/_third_party/jquery-ui.js"></script>
</body>
</html>
