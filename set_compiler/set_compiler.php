<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Составитель наборов</title>
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
    <div id="up-button-block"
         class="up-block">
        <div class="up-center-block content_right">
            <span id="hints-total-and-selected-top"
                  class="amount"></span>
            <a href="#top"
               class="link-button up-button"
               title="Наверх">[Наверх]</a>
        </div>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Составитель наборов</h1>
    <h2><label for="in-russian">Составление отдельных наборов ключевых слов из одного общего набора.</label></h2>
    <input type="text"
           id="in-russian"
           class="textarea-keywords"
           maxlength="64">
    <div id='error-translations'
         class='error'></div>
    <div class="content_right">
        <a href="#"
           id="get-translation-button"
           class="link-button"
           title="Перевести">[Перевести]</a>
        <a href="#"
           id="clear-translation-button"
           class="link-button"
           title="Очистить перевод">[х]</a>
    </div>
    <div id="translations-area">Список перевода пуст.</div>
    <h2><label for="basic_keywords_string">Опорные ключевые слова</label></h2>
    <textarea id="basic_keywords_string"
              name="basic_keywords_string"
              class="textarea-keywords"
              wrap="soft"
              rows="8"
              placeholder=""
              autofocus></textarea>
    <div id="error-hints"
         class='error'></div>
    <div id="error-hints-trigger"
         class='error-trigger'></div>
    <div class="content_right">
        <a href="#"
           id="clear-button"
           class="link-button"
           title="Очистить поле опорных ключевых слов">[x]</a>
    </div>
    <label><input type="checkbox"
                  id="without-trim"
                  name="without-trim"> без trim()</label>
    <label><input type="checkbox"
                  id="without-preg-match"
                  name="without-preg-match"> без preg_match()</label>
    <input type="submit"
           id="add-keywords-to-set-button"
           value="Добавить в список">
    <a id="top"></a>
    <div class="links_block">
        <a href="#"
           id="rank-hints-list-button"
           class="link-button"
           title="Задать очерёдность в списке ключевых слов">[Очерёдность]</a>
        <a href="#"
           id="return-to-list-view-button"
           class="link-button"
           title="Вернуть список ключевых слов">[Список]</a>
        <a href="#"
           id="sort-a-z-button"
           class="link-button"
           title="Сортировать список ключевых слов по алфавиту">[По&nbsp;алфавиту]</a>
        <a href="#"
           id="delete-deselected-hints-button"
           class="link-button"
           title="Очистить список ключевых слов от невыбранных">[Очистить]</a>
        <a href="#"
           id="select-all-hints-button"
           class="link-button"
           title="Выбрать все ключевые слова">[Все]</a>
        <a href="#"
           id="deselect-all-hints-button"
           class="link-button"
           title="Очистить список от невыбранных ключевых слов">[Ничего]</a>
        <hr/>
        <a href="#"
           id="create-result-string-button"
           class="link-button"
           title="Создать строку результата из списка ключевых слов">[Результат строкой]</a>
        <a href="#"
           id="create-result-list-button"
           class="link-button"
           title="Создать список результата из списка ключевых слов">[Результат списком]</a>
    </div>
    <div class="content_right">
        <span id="hints-total-and-selected"
              class="amount"></span>
        <a href="#"
           id="delete-hints-objects-array-button"
           class="link-button"
           title="Удалить текущий список ключевых слов">[x]</a>
    </div>
    <div id="hints-area" class="result">Список ключевых слов пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/set_compiler/set_compiler.js"></script>
<script src="/_third_party/jquery-1.10.2.js"></script>
<script src="/_third_party/jquery-ui.js"></script>
</body>
</html>
