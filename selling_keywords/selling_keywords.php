<?php

declare(strict_types=1);
error_reporting(-1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Продавшие ключевые слова</title>
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
    <div id="up-button-block"
         class="up-block">
        <div class="up-center-block content_right">
            <a href="#"
               class="link-button up-button"
               title="Наверх">[Наверх]</a>
        </div>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Продавшие ключевые слова</h1>
    <a id="top"></a>
    <label><input type="text"
                  id="author"
                  class="textarea-author"
                  maxlength="26"></label>
    <span class="hover-invert">andreikorzhyts</span>
    <span class="hover-invert">vaselenka</span>
    <a href="#"
       id="delete-author-button"
       class="link-button"
       title="Удалить автора">[x]</a>
    <label><textarea id="keyword"
                     class="textarea-keywords"
                     wrap="soft"
                     rows="8"
                     placeholder=""
                     autofocus></textarea></label>
    <div class="content_right">
        <a href="#"
           id="clear-keyword-button"
           class="link-button"
           title="Очистить поле запроса">[x]</a>
    </div>
    <div class="label_info">
        <label><input type="radio"
                      name="image_type"
                      value="all"
                      checked> All</label>
        <label><input type="radio"
                      name="image_type"
                      value="photo"> Photo</label>
        <label><input type="radio"
                      name="image_type"
                      value="vector"> Vector</label>
        <label><input type="radio"
                      name="image_type"
                      value="illustration"> Illustration</label>
    </div>
    <input type="submit"
           id="get-selling-keywords-button"
           name="get-selling-keywords-button"
           value="Получить продавшие ключевые слова">
    <span id="status"></span>
    <div class="content_right">
        <span id="count-keywords"
              class="amount">0</span>
        <a href="#"
           id="delete-keywords-objects-array-button"
           class="link-button"
           title="Удалить текущую строку результата">[x]</a>
    </div>
    <div id="selling-keywords-string" class="result">Строка результата пуста.</div>
    <div id="works-list" class="result">Список произведений пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/_third_party/lodash.js"></script>
<script src="/selling_keywords/selling_keywords.js"></script>
</body>
</html>
