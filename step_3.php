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
    <title>3/6. Получаем текущий результат списком</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h1 class="bold">3/6. Получаем текущий результат списком</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/step_3_to_1_or_4.php">
        <?php if (isset($_SESSION["arr_kws_assembled"])) {
            echo kws_list_markup($_SESSION["arr_kws_assembled"], $_SESSION["arr_kws_assembled"]);
        } ?>
        <br>
        <br>
        <span id="countRusChecked" class="counter"></span>
        <br>
        <?php
        if (isset($_SESSION["error_messages"])) {
            echo error_messages_markup($_SESSION["error_messages"]);
        }
        ?>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php'); ?>
            <span id="help"
                  class="help hidden">
            1. <span class="bold">Галочки</span> удобнее ставить, щёлкая по связанным строке или слову, а&nbsp;не целясь
            именно в&nbsp;квадратик.<br>
            2. <span class="bold">«Запомнить и&nbsp;ещё запрос»</span>&nbsp;— запомнит текущий список подобранных
            ключевых слов (без учёта снятых галочек) и&nbsp;вернёт вас на первый шаг для дополнительного подбора.<br>
            3. <span class="bold">«Изменить подбор»</span>&nbsp;— вернёт вас на предыдущий шаг с&nbsp;сохранёнными списками
            отмеченных и&nbsp;дополненных ключевых слов для возможности их изменения.<br>
            4. <span class="bold">«Уточнить запрос»</span>&nbsp;— вернёт вас на первый шаг с&nbsp;сохранением списка опорных
            ключевых слов.<br>
            5. <span class="bold">«По частоте в&nbsp;Мете»</span>&nbsp;— список ключевых слов на следующем шаге выстраивается
            по частоте их использования в&nbsp;Мете другими авторами. Выбор условия определяется опытным путём и&nbsp;иногда
            экономит время на определении очерёдности.
            </span>
        </div>
        <br>
        <input name="order"
               type="submit"
               value="3/6 Определить очерёдность">
        <br>
        <br>
        <input name="remember"
               type="submit"
               value="[Запомнить и ещё запрос]">
    </form>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/countRusChecked.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
