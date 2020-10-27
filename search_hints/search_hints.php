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
          href="//commonresources.afoteris.ru/initstyles.css"
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
    <h2><label for="basic_keywords_string">Опорные ключевые слова</label></h2>
    <input type="text"
           id="basic_keywords_string"
           name="basic_keywords_string"
           class="textarea-keywords"
           placeholder=""
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
    <!--    <input type="submit"-->
    <!--           id="get-basic-keywords-button-istockphoto"-->
    <!--           value="От Айстокфото">-->
    <!--    <input type="submit"-->
    <!--           id="get-basic-keywords-button-getty"-->
    <!--           value="От Геттиимаджес">-->
    <!--    <input type="submit"-->
    <!--           id="get-basic-keywords-button-fotolia"-->
    <!--           value="От Фотолии">-->
    <!--    <label><input type="radio"-->
    <!--                  name="media_type_bigstockphoto"-->
    <!--                  value="image"-->
    <!--                  checked> Изображения</label>-->
    <!--    <label><input type="radio"-->
    <!--                  name="media_type_bigstockphoto"-->
    <!--                  value="video"> Видео</label>-->
    <!--    <input type="submit"-->
    <!--           id="get-basic-keywords-button-bigstockphoto"-->
    <!--           value="От Бигстокфото">-->
    <!--    <input type="submit"-->
    <!--           id="get-basic-keywords-button-depositphotos"-->
    <!--           value="От Депозитфотос">-->
    <!--    <input type="submit"-->
    <!--           id="get-basic-keywords-button-123rf"-->
    <!--           value="От 123РФ">-->
    <div id="hints-area" class="result">Список подсказок пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/search_hints/search_hints.js"></script>
<script src="/_third_party/jquery-1.10.2.js"></script>
<script src="/_third_party/jquery-ui.js"></script>
</body>
</html>
