<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поисковые подсказки</title>
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
        <div class="up-center-block content-right">
            <span id="hints-total-and-selected-top"
                  class="counter"></span>
            <a href="#top"
               class="link-button up-button"
               title="Наверх">[Наверх]</a>
        </div>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Поисковые подсказки</h1>
    <label for="in-russian">Вспомогательный русско-английский перевод</label>
    <input type="text"
           id="in-russian"
           class="textarea-keywords"
           maxlength="64">
    <span id='error-translations'
          class='error'></span>
    <div class="content-right">
        <a href="#"
           id="get-translation-button"
           class="link-button"
           title="Получить перевод">[Перевод]</a>
        <a href="#"
           id="clear-translation-button"
           class="link-button"
           title="Очистить перевод">[х]</a>
    </div>
    <div id="translations-area">Список перевода пуст.</div>
    <label for="basic-keywords-string">Опорные ключевые слова</label>
    <textarea id="basic-keywords-string"
              name="basic-keywords-string"
              class="textarea-keywords"
              wrap="soft"
              rows="8"
              placeholder=""
              autofocus></textarea>
    <span id="error-hints"
          class='error'></span>
    <div class="content-right">
        <a href="#"
           id="add-keywords-to-list-button"
           class="link-button"
           title="Добавить в список свои ключевые слова">[Добавить в&nbsp;список]</a>
        <a href="#"
           id="clear-button"
           class="link-button"
           title="Очистить поле запроса">[x]</
    </div>
    <label><input type="radio"
                  name="media-type"
                  value="image"
                  checked> Изображения</label>
    <label><input type="radio"
                  name="media-type"
                  value="audio"> Аудио</label>
    <label><input type="radio"
                  name="media-type"
                  value="video"> Видео</label>
    <input id="get-basic-keywords-button-shutterstock"
           type="submit"
           value="От Шаттерстока">
    <input id="get-basic-keywords-button-istockphoto"
           type="submit"
           value="От Айстокфото">
    <input id="get-basic-keywords-button-getty"
           type="submit"
           value="От Геттиимаджес">
    <input id="get-basic-keywords-button-fotolia"
           type="submit"
           value="От Фотолии">
    <label><input type="radio"
                  name="type"
                  value="image"
                  checked> Изображения</label>
    <label><input type="radio"
                  name="type"
                  value="video"> Видео</label>
    <input id="get-basic-keywords-button-bigstockphoto"
           type="submit"
           value="От Бигстокфото">
    <input id="get-basic-keywords-button-depositphotos"
           type="submit"
           value="От Депозитфотос">
    <input id="get-basic-keywords-button-123rf"
           type="submit"
           value="От 123РФ">
    <a id="top"></a>
    <a href="#" id="create-result-string-button"
       class="link-button"
       title="Создать строку результата">[Результат]</a>
    <a href="#" id="rank-hints-list-button"
       class="link-button"
       title="Задать очерёдность подсказок в списке">[Очерёдность]</a>
    <a href="#" id="return-to-list-view-button"
       class="link-button"
       title="Вернуть список подсказок">[Список]</a>
    <a href="#" id="sort-a-z-button"
       class="link-button"
       title="Сортировать список по алфавиту">[По&nbsp;алфавиту]</a>
    <a href="#" id="delete-deselected-hints-button"
       class="link-button"
       title="Очистить список от невыбранных подсказок">[Очистить]</a>
    <a href="#" id="select-all-hints-button"
       class="link-button"
       title="Вернуть список подсказок">[Все]</a>
    <a href="#" id="deselect-all-hints-button"
       class="link-button"
       title="Очистить список от невыбранных подсказок">[Ничего]</a>
    <div class="content-right">
        <span id="hints-total-and-selected"
              class="counter"></span>
        <a href="#"
           id="delete-hints-objects-array-button"
           class="link-button"
           title="Удалить текущий список подсказок">[x]</a>
    </div>
    <div id="hints-area">Список подсказок пуст.</div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/search_hints/js/search_hints.js"></script>
<script src="/_third_party/jquery-1.10.2.js"></script>
<script src="/_third_party/jquery-ui.js"></script>
</body>
</html>
