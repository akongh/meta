<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Продавшие ключевые слова на Шаттерстоке</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/analytics_code.php'); ?>
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
    <h1>Продавшие ключевые слова на Шаттерстоке</h1>
    <a id="top"></a>
    <div id="variants-queries-list" class="saved_set">Без вариантов.</div>
    <div class="label_info">
        <span title="Число уровней повторяемости вариантов запросов">
            Основных
            <label><select size="1"
                           id="level">
                <option selected
                        value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                </select></label>
        </span>
    </div>
    <div class="content_right">
        <a href="#"
           id="create-variants-queries-button"
           class="link-button"
           title="Создатть варианты запросов">[Создать варианты]</a>
        <a href="#"
           id="delete-variants-queries-button"
           class="link-button"
           title="Удалить варианты запросов">[x]</a>
    </div>
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
        <label><input type="checkbox"
                      name="use-variant-queries"
                      value=""> На основе вариантов</label>
    </div>
    <div class="label_info">
        <label><input type="radio"
                      name="image_type"
                      value="all"
                      checked> Все</label>
        <label><input type="radio"
                      name="image_type"
                      value="photo"> Фото</label>
        <label><input type="radio"
                      name="image_type"
                      value="vector"> Вектор</label>
        <label><input type="radio"
                      name="image_type"
                      value="illustration"> Иллюстрации</label>
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
<script src="/selling_keywords/js/skw.js"></script>
</body>
</html>
