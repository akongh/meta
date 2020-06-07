<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

//var_dump($_SESSION);
?>

<!DOCTYPE html>
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
          href="/style.css"
          type="text/css">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/analytics_code.php"); ?>
</head>
<body>
<div class="wrap">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/link_to_index.php"); ?>
    <h1>Русско-английский подбор<br>
        1/6. Задаём опорные ключевые слова для подбора</h1>
    <?= meta_kws_markup_state_amount(); ?>
    <form action="/keyword_selection/step_1_to_2.php"
          method="post">
        <label>
        <textarea name="input_str_kws_query"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?= meta_kws_content_input(1); ?></textarea></label>
        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>
        <div class="label_info">
            <label title="Граница количества ключевых слов в результате подбора на следующем шаге">Предел выборки
                <select name="max_choice_amount"
                        size="1">
                    <option selected
                            value="64">64
                    </option>
                    <option value="128">128
                    </option>
                </select>.</label>
            <label title="Постепенное автоматическое уменьшение строгости, если не удаётся ничего подобрать">
                <input type="checkbox"
                       name="non_strict_choice"
                       checked> Нестрого.</label>
        </div>
        <input name="make_choice"
               type="submit"
               value="Подобрать">
    </form>
    <div class="content_right">
        <?php
        require($_SERVER["DOCUMENT_ROOT"] . "/keyword_selection/includes/link_reset_and_start_over.php"); ?>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
</body>
</html>
