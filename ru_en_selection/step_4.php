<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>4/6. Определяем очерёдность ключевых слов</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
    <?php
    echo file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/../_meta_privacy/analytics_code'); ?>
    <script src="/_third_party/jquery-1.10.2.js"></script>
    <script src="/_third_party/jquery-ui.js"></script>
    <script src="/ru_en_selection/js/changeOrderingList.js"></script>
</head>
<body>
<div class="wrap">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/link_to_index.php'); ?>
    <h1>Русско-английский подбор</h1>
    <h2>4/6. Определяем очерёдность ключевых слов</h2>
    <form method="post"
          action="/ru_en_selection/step_4_to_5.php">
        <ul id="sortable" class="wrap_list_kws">
            <?php
            if (isset($_SESSION["arr_kws_ordered"]) and 0 < count($_SESSION["arr_kws_ordered"])) {
                $arr_kws_ordered = array();
                foreach ($_SESSION["arr_kws_ordered"] as $kw) {
                    $kw = htmlspecialchars($kw, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
                    $arr_kws_ordered[] = "
                        <li class='sortable_element'>
                            <input type='checkbox'
                                   name='arr_kws_marked[]'
                                   hidden
                                   checked
                                   value='{$kw}'>{$kw}</li>
                                   ";
                }
                echo implode("", $arr_kws_ordered);
            } else {
                echo "Список для задания очерёдности пуст.";
            }
            ?>
        </ul>
        <div class="amount_kws">
            <?= "<span class='amount'>" . count($_SESSION["arr_kws_ordered"]) . "</span>"; ?>
        </div>
        <input name="poluchit"
               type="submit"
               value="Выбрать перевод">
    </form>
    <div class="back_link">
        <a href="/ru_en_selection/step_3.php"
           title="Назад">[<<<< Назад]</a>
    </div>
    <div class="content_right">
        <?php
        require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
</body>
</html>
