<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

//var_dump($_SESSION);
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
    <?php echo meta_kws_markup_state_amount(); ?>
    <form action="/step_1_to_2.php"
          method="post">
        <textarea name="input_str_kws_query"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?php echo meta_kws_content_input(1); ?></textarea>
        <br>
        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>
        <br>
        <br>
        <br>
        <span title="Граница количества ключевых слов в результате подбора на следующем шаге">Граница
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
               value="Подобрать">
    </form>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_reset_and_start_over.php"); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"); ?>
</div>
</body>
</html>
