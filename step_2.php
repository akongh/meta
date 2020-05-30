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
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php'); ?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php'); ?>
    <br>
    <br>
    <h1 class="bold">2/6. Выбираем из подобранных…</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/step_2_to_3.php">
        <?php
        if (isset($_SESSION["arr_kws_selection"]) and count($_SESSION["arr_kws_selection"]) > 0) {
            echo meta_kws_markup_checkbox_list($_SESSION["arr_kws_selection"], $_SESSION["arr_kws_selection_marked"]);
        } else {
            echo "Список подобраных ключевых слов пуст.";
        }
        ?>
        <br>
        <br>
        <?php echo meta_kws_markup_state_amount(); ?>
        <h1 class="bold">…и добавляем свои</h1>
        <br>
        <textarea name="input_str_kws_addition"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?php echo meta_kws_content_input(2); ?></textarea>
        <br>
        <?php
        echo meta_errors_markup_list();
        unset($_SESSION["error_messages"]);
        ?>
        <br>
        <br>
        <br>
        <label title="Для наглядного определения избыточных похожих ключевых слов на следующем шаге">
            <input type="checkbox"
                   checked
                   name="alphabetical_order">
            Алфавитный порядок.</label>
        <br>
        <br>
        <input name="sobrat"
               type="submit"
               value="2/6 Собрать в список">
    </form>
    <br>
    <a class="link-button-reset"
       href="/step_1.php"
       title="Назад"><<<< Назад</a>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/selectAll.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
