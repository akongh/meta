<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>1/6. Задаём опорные ключевые слова для подбора</title>
    <meta name="Description"
          content="Подбирайте ключевые слова на русском, результат получайте на английском.
    Составной подбор, удаление дубликатов, задание очерёдности, ручной перевод."/>
    <meta name="Keywords"
          content="ключевые слова фотографий, фотостоки подбор слов, подбор ключевых слов для фотостоков,
    атрибутирование фотографий, ключевые слова перевод на английский, сервис для создания ключевых слов,
    ключевые слова фотобанков, ключевые слова для фотографа, ключевики для стоков"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/analytics_code.php"); ?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_to_index.php"); ?>
    <br>
    <br>
    <h1 class="bold">1/6. Задаём опорные ключевые слова для подбора</h1>
    <br>
    <br>
    <br>
    <br>
    <?php
    if (isset($_SESSION["arr_kws_state"])) {
        echo meta_kws_markup_state_amount($_SESSION["arr_kws_state"]);
    }
    ?>
    <form action="/step_1_to_2.php"
          method="post">
        <textarea name="input_str_kws_query"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?php
            if (isset($_SESSION["arr_kws_query"])) {
                echo htmlspecialchars(implode("\n", $_SESSION["arr_kws_query"]), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
            }
            ?></textarea>
        <br>
        <?php
        if (isset($_SESSION["error_messages"])) {
            echo meta_markup_errors_list($_SESSION["error_messages"]);
        }
        ?>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_help.php"); ?>
            <span id="help"
                  class="help hidden">
            1. <span class="bold">е&nbsp;≠&nbsp;ё</span>.<br>
            2. <span class="bold">Дубликаты</span> ключевых слов удалятся автоматически.<br>
            3. <span class="bold">Галочки</span> удобнее ставить, щёлкая по связанным строке или слову, а&nbsp;не целясь
            именно в&nbsp;квадратик.<br>
            4. <span class="bold">«Не менее 64/127»</span>&nbsp;— граница количества ключевых слов в&nbsp;результате подбора на
            следующем шаге. Выбор значения определяется опытным путём и&nbsp;зависит от широты тематики, строгости подбора&nbsp;(п.&nbsp;5)
            и&nbsp;вашего настроя быстрее сделать&nbsp;(64) или больше охватить&nbsp;(128).<br>
            5. <span class="bold">«Нестрого»</span>&nbsp;— постепенное автоматическое уменьшение строгости соответствия подбора
            всему списку опорных ключевых слов сразу, если не удаётся ничего подобрать. Результат подбора увеличивается
            за счёт потери точности и&nbsp;стремится к&nbsp;выбранной границе&nbsp;(п. 4). Условие проявляет действие при двух и&nbsp;более
            опорных ключевых словах. При снятой галочке выполняется строгий подбор, точность максимальная, но увеличение
            количества опорных ключевых слов резко уменьшает результат.
            </span>
        </div>
        <br>
        <span title="Граница количества ключевых слов в результате подбора на следующем шаге">Не менее
            <select size="1"
                    name="max_choice_amount">
            <option selected
                    value="64">64</option>
            <option value="128">128</option>
        </select>.</span>
        <label title="Постепенное автоматическое уменьшение строгости, если не удаётся ничего подобрать">
            <input type="checkbox"
                   name="non_strict_choice"
                   checked> Нестрого.
        </label>
        <br>
        <br>
        <input name="make_choice"
               type="submit"
               value="1/6 Подобрать">
    </form>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_reset_and_start_over.php"); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"); ?>
</div>
<script src="/js/showHelp.js"></script>
</body>
</html>
