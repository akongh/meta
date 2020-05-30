<?php error_reporting( - 1 );

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Действующий на&nbsp;базе Меты инструмент подбора ключевых слов для&nbsp;стоков по&nbsp;подсказкам ключевых запросов в&nbsp;строке поиска от&nbsp;некоторых из&nbsp;них</title>
    <meta name="Description" content="Подбор ключевых слов, используя подсказки ключевых запросов."/>
    <meta name="Keywords" content="ключевые слова, подсказки, ключевые запросы, перевод на английский, перевод на русском, шаттерсток"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php');?>
</head>
<body>
<div class="page">
    <div id="up-button-block" class="up-block">
        <div class="up-center-block content-right">
            <span id="hints-total-and-selected-top" class="counter"></span>
            <a class="link-button up-button" href="#top" title="Наверх">[Наверх]</a>
        </div>
    </div>
    <br>
    <br>
    <h1 class="bold">
        <span class="meta">МЕТА-подсказки</span>
        <br>
        <br>
        Действующий на&nbsp;базе Меты инструмент подбора ключевых слов для&nbsp;стоков по&nbsp;подсказкам ключевых запросов в&nbsp;строке поиска от&nbsp;некоторых из&nbsp;них
    </h1>
    <br>
    <br>
    <br>
    <br>
    <input type="text" id="in-russian" class="textarea-keywords" maxlength="64">
    <span id='error-translations' class='error'></span>
    <br>
    <br>
    <div class="content-right">
        <a id="get-translation-button" class="link-button" href="##" title="Получить перевод">[Перевод]</a>
        <a id="clear-translation-button" class="link-button" href="##" title="Очистить перевод">[х]</a>
    </div>
    <br>
    <br>
    <div id="translations-area">Список перевода пуст.</div>
    <br>
    <br>
    <textarea id="basic-keywords-string"
              name="basic-keywords-string"
              class="textarea-keywords"
              wrap="soft"
              rows="8"
              placeholder=""
              autofocus></textarea>
    <span id="error-hints" class='error'></span>
    <br>
    <br>
    <div class="content-right">
        <a id="add-keywords-to-list-button" class="link-button" href="##" title="Добавить в список свои ключевые слова">[Добавить в&nbsp;список]</a>
        <a id="clear-button" class="link-button" href="##" title="Очистить поле запроса">[x]</a>
    </div>
    <br>
    <label><input type="radio" name="media-type" value="image" checked> Изображения</label>
    <label><input type="radio" name="media-type" value="audio"> Аудио</label>
    <label><input type="radio" name="media-type" value="video"> Видео</label>
    <br>
    <br>
    <input id="get-basic-keywords-button-shutterstock" type="submit" value="От Шаттерстока">
    <br>
    <br>
    <input id="get-basic-keywords-button-istockphoto" type="submit" value="От Айстокфото">
    <br>
    <br>
    <input id="get-basic-keywords-button-getty" type="submit" value="От Геттиимаджес">
    <br>
    <br>
    <input id="get-basic-keywords-button-fotolia" type="submit" value="От Фотолии">
    <br>
    <br>
    <label><input type="radio" name="type" value="image" checked> Изображения</label>
    <label><input type="radio" name="type" value="video"> Видео</label>
    <br>
    <br>
    <input id="get-basic-keywords-button-bigstockphoto" type="submit" value="От Бигстокфото">
    <br>
    <br>
    <input id="get-basic-keywords-button-depositphotos" type="submit" value="От Депозитфотос">
    <br>
    <br>
    <input id="get-basic-keywords-button-123rf" type="submit" value="От 123РФ">
    <a name="top"></a>
    <br>
    <br>
    <br>
    <br>
    <a id="create-result-string-button" class="link-button" href="##" title="Создать строку результата">[Результат]</a>
    <a id="rank-hints-list-button" class="link-button" href="##" title="Задать очерёдность подсказок в списке">[Очерёдность]</a>
    <a id="return-to-list-view-button" class="link-button" href="##" title="Вернуть список подсказок">[Список]</a>
    <a id="sort-a-z-button" class="link-button" href="##" title="Сортировать список по алфавиту">[По&nbsp;алфавиту]</a>
    <a id="delete-deselected-hints-button" class="link-button" href="##" title="Очистить список от невыбранных подсказок">[Очистить]</a>
    <br>
    <br>
    <a id="select-all-hints-button" class="link-button" href="##" title="Вернуть список подсказок">[Все]</a>
    <a id="deselect-all-hints-button" class="link-button" href="##" title="Очистить список от невыбранных подсказок">[Ничего]</a>
    <br>
    <br>
    <div class="content-right">
        <span id="hints-total-and-selected" class="counter"></span>
        <a id="delete-hints-objects-array-button" class="link-button" href="##" title="Удалить текущий список подсказок">[x]</a>
    </div>
    <br>
    <br>
    <div id="hints-area">Список подсказок пуст.</div>
    <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php' );?>
</div>
<script src="/hints/js/hints.js"></script>
<script src="/js/jquery-1.10.2.js"></script>
<script src="/js/jquery-ui.js"></script>
</body>
</html>
