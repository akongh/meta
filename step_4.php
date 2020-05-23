<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

var_dump($_SESSION);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>4/6. Определяем очерёдность ключевых слов</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php'); ?>
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/changeOrderingList.js"></script>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php'); ?>
    <br>
    <br>
    <h1 class="bold">4/6. Определяем очерёдность ключевых слов</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/step_4_to_5.php">
        <ul id="sortable">
            <?php if (isset($_SESSION["arr_kws_assembled_marked"])) {
                for ($i = 0; $i < count($_SESSION["arr_kws_assembled_marked"]); $i++) {
                    $arr_kws_assembled_marked[$i] = "
                        <li>
                            <input type='checkbox'
                                   name='arr_kws_marked[]'
                                   class='hidden'
                                   checked
                                   value='{$_SESSION["arr_kws_assembled_marked"][$i]}'>{$_SESSION["arr_kws_assembled_marked"][$i]}</li>
                                   ";
                }
                echo implode("\n", $arr_kws_assembled_marked);
            } ?>
        </ul>
        <br>
        <br>
        <span class="counter">
            <?php if (isset($_SESSION["arr_kws_assembled_marked"])) {
                echo count($_SESSION["arr_kws_assembled_marked"]);
            } ?></span>
        <br>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php'); ?><span id="help" class="help hidden">
            1. <span class="bold">Перетаскивать</span> ключевое слово удобнее, хватаясь за строку с&nbsp;ним, а&nbsp;не целясь
            в&nbsp;само слово.<br>
            2. <span class="bold">Некоторые стоки</span> учитывают очерёдность ключевых слов.
            </span><br>
        </div>
        <br>
        <input name="poluchit"
               type="submit"
               value="4/6 Выбрать перевод">
    </form>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/showHelp.js"></script>
</body>
</html>
