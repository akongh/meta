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
                  name="character_array"
                  value="no"
                  checked> No</label>
    <label><input type="radio"
                  name="character_array"
                  value="digits"> 0-9</label>
    <label><input type="radio"
                  name="character_array"
                  value="latin"> a-z</label>
    <label><input type="radio"
                  name="character_array"
                  value="cyrillic"> а-я</label>
    <br>
    <label><input type="radio"
                  name="language_code"
                  value="en"> en</label>
    <label><input type="radio"
                  name="language_code"
                  value="ru"> ru</label>
    <br>
    <label><input type="radio"
                  name="country_code"
                  value="us"> us</label>
    <label><input type="radio"
                  name="country_code"
                  value="ca"> ca</label>
    <label><input type="radio"
                  name="country_code"
                  value="au"> au</label>
    <label><input type="radio"
                  name="country_code"
                  value="uk"> uk</label>
    <label><input type="radio"
                  name="country_code"
                  value="kr"> kr</label>
    <label><input type="radio"
                  name="country_code"
                  value="de"> de</label>
    <label><input type="radio"
                  name="country_code"
                  value="no"> no</label>
    <label><input type="radio"
                  name="country_code"
                  value="se"> se</label>
    <label><input type="radio"
                  name="country_code"
                  value="fi"> fi</label>
    <label><input type="radio"
                  name="country_code"
                  value="ru"> ru</label>
    <!--/common parameters-->
    <hr class="otbivka_48">
    <!--youtube-->
    <input type="submit"
           id="get-basic-keywords-button-youtube"
           value="От Ютуба">
    <!--/youtube-->
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
