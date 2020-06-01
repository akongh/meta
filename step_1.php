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
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="css/style.css"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/analytics_code.php"); ?>
</head>
<body>
<div class="page">

    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_to_index.php"); ?>

    <h1 class="bold">1/6. Задаём опорные ключевые слова для подбора</h1>

    <?= meta_kws_markup_state_amount(); ?>
    <form action="/step_1_to_2.php"
          method="post">
        <textarea name="input_str_kws_query"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?= meta_kws_content_input(1); ?></textarea>
        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>

        <span title="Граница количества ключевых слов в результате подбора на следующем шаге">Предел выборки
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

        <input name="make_choice"
               type="submit"
               value="Подобрать">
    </form>

    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/link_reset_and_start_over.php"); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"); ?>
</div>
</body>
</html>
