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
    <title>2/6. Выбираем из подобранных и добавляем свои</title>
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
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/link_to_index.php'); ?>
    <h1>Русско-английский подбор</h1>
    <h2>2/6. Выбираем из подобранных…</h2>
    <form method="post"
          action="/ru_en_selection/step_2_to_3.php">
        <div class="wrap_list_kws">
            <?php
            if (isset($_SESSION["arr_kws_selection"]) and count($_SESSION["arr_kws_selection"]) > 0) {
                echo meta_kws_markup_checkbox_list($_SESSION["arr_kws_selection"],
                    $_SESSION["arr_kws_selection_marked"]);
            } else {
                echo "Список подобранных ключевых слов пуст.";
            }
            ?>
        </div>
        <?= meta_kws_markup_state_amount(); ?>
        <h2>…и добавляем свои</h2>
        <label>
        <textarea name="input_str_kws_addition"
                  wrap="soft"
                  rows="8"
                  placeholder=""><?= meta_kws_content_input(2); ?></textarea></label>

        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>
        <div class="label_info">
            <label title="Для наглядного определения избыточных похожих ключевых слов на следующем шаге">
                <input type="checkbox"
                       checked
                       name="alphabetical_order">
                Алфавитный порядок.</label>
        </div>
        <input name="sobrat"
               type="submit"
               value="Собрать в список">
    </form>
    <div class="back_link">
        <a href="/ru_en_selection/step_1.php"
           title="Назад">[<<<< Назад]</a>
    </div>
    <div class="content_right">
        <?php
        require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
<script src="/ru_en_selection/js/selectAll.js"></script>
</body>
</html>
