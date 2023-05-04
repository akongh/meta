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
           placeholder="Поисковый запрос"
           autofocus>
    <span id="error-hints"
          class='error'></span>
    <div class="content_right">
        <a href="#"
           id="clear-button-basic"
           class="link-button"
           title="Очистить поле поискового запроса">[x]</a>
    </div>
    <hr class="otbivka_64">
    <!--common parameters-->
    <label><input type="radio"
                  name="0-z"
                  value="no_0-z"
                  checked> no 0-z</label>
    <label><input type="radio"
                  name="0-z"
                  value="0-z"> 0-z</label>
    <!--/common parameters-->
    <hr class="otbivka_48">
    <!--shutterstock-->
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
    <!--/shutterstock-->
    <!--youtube-->
    <input type="submit"
           id="get-basic-keywords-button-youtube"
           value="От Ютуба">
    <!--/youtube-->
    <!--pond5-->
    <label><input type="radio"
                  name="media_type_pond5"
                  value="footage"
                  checked> Footage</label>
    <label><input type="radio"
                  name="media_type_pond5"
                  value="sfx"> SFX</label>
    <input type="submit"
           id="get-basic-keywords-button-pond5"
           value="From Pond5">
    <!--/pond5-->
    <div id="hints-area" class="result">Список подсказок пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/search_hints/search_hints.js"></script>
<script src="/_third_party/jquery-1.10.2.js"></script>
<script src="/_third_party/jquery-ui.js"></script>
</body>
</html>
