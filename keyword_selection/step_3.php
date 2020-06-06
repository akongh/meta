<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/functions.php');

//var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>3/6. Получаем текущий результат списком</title>
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
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/link_to_index.php'); ?>
    <h1>3/6. Получаем текущий результат списком</h1>
    <form method="post"
          action="/keyword_selection/step_3_to_1_or_4.php">
        <div class="wrap_list_kws">
            <?php
            if (isset($_SESSION["arr_kws_assembled"]) and count($_SESSION["arr_kws_assembled"]) > 0) {
                echo meta_kws_markup_checkbox_list($_SESSION["arr_kws_assembled"],
                    $_SESSION["arr_kws_assembled_marked"]);
            } else {
                echo "Список выбранных ключевых слов пуст.";
            }
            ?>
        </div>
        <div class="amount_kws">
            <span id="countRusChecked" class="amount"></span>
        </div>
        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>
        <input name="order"
               type="submit"
               value="Определить очерёдность">
        <input name="remember"
               type="submit"
               value="Запомнить и ещё запрос">
    </form>
    <div class="back_link">
        <a href="/keyword_selection/step_2.php"
           title="Назад">[<<<< Назад]</a>
    </div>
    <div class="content_right">
        <?php
        require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/keyword_selection/js/countRusChecked.js"></script>
</body>
</html>
