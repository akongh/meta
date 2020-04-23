<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

$_SESSION["presence_mark"] = true;

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
    if (isset($_SESSION["state_of_kws_set"])) {
        echo $_SESSION["state_of_kws_set"];
    }
    ?>
    <form action="/php/ex_create_choice_list.php"
          method="post">
        <textarea name="input_str_basis_kws"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?php
            if (isset($_SESSION["arr_basis_kws"])) {
                echo implode("\n", $_SESSION["arr_basis_kws"]);
            }
            ?></textarea>
        <br>
        <?php
        if (isset($_SESSION["err_msg_empty_input"])) {
            echo $_SESSION["err_msg_empty_input"];
        }
        if (isset($_SESSION["err_msg_illegal_char"])) {
            echo $_SESSION["err_msg_illegal_char"];
        }
        if (isset($_SESSION["err_msg_illegal_basis_kws_amount"])) {
            echo $_SESSION["err_msg_illegal_basis_kws_amount"];
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
            4. <span class="bold">«Не более 80/160»</span>&nbsp;— граница количества ключевых слов в&nbsp;результате подбора на
            следующем шаге. Выбор значения определяется опытным путём и&nbsp;зависит от широты тематики, строгости подбора&nbsp;(п.&nbsp;5)
            и&nbsp;вашего настроя быстрее сделать&nbsp;(80) или больше охватить&nbsp;(160).<br>
            5. <span class="bold">«Нестрого»</span>&nbsp;— постепенное автоматическое уменьшение строгости соответствия подбора
            всему списку опорных ключевых слов сразу, если не удаётся ничего подобрать. Результат подбора увеличивается
            за счёт потери точности и&nbsp;стремится к&nbsp;выбранной границе&nbsp;(п. 4). Условие проявляет действие при двух и&nbsp;более
            опорных ключевых словах. При снятой галочке выполняется строгий подбор, точность максимальная, но увеличение
            количества опорных ключевых слов резко уменьшает результат.
            </span><br>
            <br>
        </div>
        <span title="Граница количества ключевых слов в результате подбора на следующем шаге">Не более
            <select size="1"
                    name="max_choice_amount">
            <option selected
                    value="80">80</option>
            <option value="160">160</option>
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
