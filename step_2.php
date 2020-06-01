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
    <title>2/6. Выбираем из подобранных и добавляем свои</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="css/style.css"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php'); ?>
</head>
<body>
<div class="wrap">

    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php'); ?>

    <h1>2/6. Выбираем из подобранных…</h1>

    <form method="post"
          action="/step_2_to_3.php">
        <?php
        if (isset($_SESSION["arr_kws_selection"]) and count($_SESSION["arr_kws_selection"]) > 0) {
            echo meta_kws_markup_checkbox_list($_SESSION["arr_kws_selection"], $_SESSION["arr_kws_selection_marked"]);
        } else {
            echo "Список подобраных ключевых слов пуст.";
        }
        ?>

        <?= meta_kws_markup_state_amount(); ?>
        <h1>…и добавляем свои</h1>

        <textarea name="input_str_kws_addition"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?= meta_kws_content_input(2); ?></textarea>

        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>

        <label title="Для наглядного определения избыточных похожих ключевых слов на следующем шаге">
            <input type="checkbox"
                   checked
                   name="alphabetical_order">
            Алфавитный порядок.</label>

        <input name="sobrat"
               type="submit"
               value="Собрать в список">
    </form>

    <a class="link-button-reset"
       href="/step_1.php"
       title="Назад">[<<<< Назад]</a>
    <div class="content_right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/selectAll.js"></script>
</body>
</html>
