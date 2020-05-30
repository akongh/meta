<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_SESSION);
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
            <?php if (isset($_SESSION["arr_kws_ordered"])) {
                foreach ($_SESSION["arr_kws_ordered"] as $kw) {
                    $kw = htmlspecialchars($kw, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
                    $arr_kws_ordered[] = "
                        <li>
                            <input type='checkbox'
                                   name='arr_kws_marked[]'
                                   class='hidden'
                                   checked
                                   value='{$kw}'>{$kw}</li>
                                   ";
                }
                echo implode("\n", $arr_kws_ordered);
            } else {
                echo "Нечему выставлять очерёдность.";
            } ?>
        </ul>
        <br>
        <br>
        <?php if (isset($_SESSION["arr_kws_ordered"])) {
            echo "<span class='counter'>" . count($_SESSION["arr_kws_ordered"]) . "</span>";
        } ?>
        <br>
        <br>
        <br>
        <br>
        <input name="poluchit"
               type="submit"
               value="Выбрать перевод">
    </form>
    <br>
    <a class="link-button-reset"
       href="/step_3.php"
       title="Назад">[<<<< Назад]</a>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
</body>
</html>
