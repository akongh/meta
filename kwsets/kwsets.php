<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Поисковые подсказки ключевых слов</title>
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
            <span id="hints-total-and-selected-top"
                  class="amount"></span>
            <a href="#top"
               class="link-button up-button"
               title="Наверх">[Наверх]</a>
        </div>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Поисковые подсказки ключевых слов</h1>
    <h2><label for="in-russian">Вспомогательный русско-английский перевод</label></h2>
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
    <span id="error-hints"
          class='error'></span>
    <div class="content_right">
        <a href="#"
           id="add-keywords-to-list-button"
           class="link-button"
           title="Добавить в список ключевых слов">[Добавить в&nbsp;список]</a>
        <a href="#"
           id="clear-button"
           class="link-button"
           title="Очистить поле опорных ключевых слов">[x]</a>
    </div>
<!--    <label><input type="radio"-->
<!--                  name="media_type_shutterstock"-->
<!--                  value="image"-->
<!--                  checked> Изображения</label>-->
<!--    <label><input type="radio"-->
<!--                  name="media_type_shutterstock"-->
<!--                  value="audio"> Аудио</label>-->
<!--    <label><input type="radio"-->
<!--                  name="media_type_shutterstock"-->
<!--                  value="video"> Видео</label>-->
<!--    <input type="submit"-->
<!--           id="get-basic-keywords-button-shutterstock"-->
<!--           value="От Шаттерстока">-->
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
    <a id="top"></a>
    <a href="#"
       id="create-result-string-button"
       class="link-button"
       title="Создать строку результата из списка ключевых слов">[Результат]</a>
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
    <div class="content_right">
        <span id="hints-total-and-selected"
              class="amount"></span>
        <a href="#"
           id="delete-hints-objects-array-button"
           class="link-button"
           title="Удалить текущий список ключевых слов">[x]</a>
    </div>
    <div id="hints-area">Список ключевых слов пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/search_hints/kwsets.js"></script>
<script src="/_third_party/jquery-1.10.2.js"></script>
<script src="/_third_party/jquery-ui.js"></script>
</body>
</html>
