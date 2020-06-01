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
    <title>3/6. Получаем текущий результат списком</title>
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

    <h1 class="bold">3/6. Получаем текущий результат списком</h1>

    <form method="post"
          action="/step_3_to_1_or_4.php">
        <?php
        if (isset($_SESSION["arr_kws_assembled"]) and count($_SESSION["arr_kws_assembled"]) > 0) {
            echo meta_kws_markup_checkbox_list($_SESSION["arr_kws_assembled"], $_SESSION["arr_kws_assembled_marked"]);
        } else {
            echo "Список выбранных ключевых слов пуст.";
        }
        ?>

        <span id="countRusChecked" class="amount"></span>

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

    <a class="link-button-reset"
       href="/step_2.php"
       title="Назад">[<<<< Назад]</a>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/countRusChecked.js"></script>
</body>
</html>
