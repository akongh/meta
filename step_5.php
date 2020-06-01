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
    <title>5/6. Выбираем перевод</title>
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
    <h1>5/6. Выбираем перевод</h1>
    <form method="post"
          action="/step_5_to_6.php">
        <div class="wrap_list_kws">
            <?php
            foreach ($_SESSION["arr_kws_translations"] as $el) {
                $el[0] = htmlspecialchars($el[0], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
                switch ($el[2]) {
                    case 0:
                        $comment = "(перевода пока нет)";
                        break;
                    case 7:
                        $comment = "(в заявке на перевод)";
                }
                if ($el[2] == 0 or $el[2] == 7) {
                    $div_class = "block_not_translated";
                    $translation_meaning_markup = "{$comment}<input type='checkbox'
                                                                name='zayavka[]'
                                                                hidden
                                                                checked
                                                                value='{$el[0]}'>";
                } else {
                    $div_class = "block_translated";
                    foreach ($el[1] as $val) {
                        $translation = htmlspecialchars($val["s"], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
                            'UTF-8');
                        $meaning = htmlspecialchars($val["z"], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
                            'UTF-8');
                        $translation_meaning[] = "<label class='label_highlight separate_checkbox'>
                                                  <span class='keyword_en'>
                                                      <input type='checkbox'
                                                             name='angl[]'
                                                             value='{$translation}'>{$translation}</span> — {$meaning}
                                              </label>";
                    }
                    $translation_meaning_markup = implode("", $translation_meaning);
                }
                echo "<div class='{$div_class}'>
                    <span class='keyword_ru'>
                        <input type='checkbox'
                               name='russk[]'
                               hidden
                               checked
                               value='{$el[0]}'>{$el[0]}</span>
                    {$translation_meaning_markup}
              </div>";
                unset($translation_meaning);
            }
            ?>
        </div>
        <?= "<div class=\"amount_kws\"><span class='amount'>" . count($_SESSION["arr_kws_ordered"]) . " / <span id='countUniqEngChecked'></span></span></div>"; ?>

        <input name="poluchit"
               type="submit"
               value="Получить результат строками">
    </form>
    <div class="back_link">
        <a href="/step_4.php"
           title="Назад">[<<<< Назад]</a>
    </div>
    <div class="content_right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/countUniqEngChecked.js"></script>
<script src="/js/uncheckedTranslations.js"></script>
</body>
</html>
