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
    <title>5/6. Выбираем перевод</title>
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
    <h1 class="bold">5/6. Выбираем перевод</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/step_5_to_6.php">

        <?php
        foreach ($_SESSION["arr_list_kws_translations"] as $el) {
            if ($el[2] == 0) {
                $comment = "(перевода пока нет)";
            } else {
                if ($el[2] == 7) {
                    $comment = "(в заявке на перевод)";
                }
            }

            if ($el[2] == 0 or $el[2] == 7) {
                $div_class = "block-not-translated";
                $translation_meaning_markup = "{$comment}<input type='checkbox'
                                                                name='zayavka[]'
                                                                class='hidden'
                                                                checked
                                                                value='{$el[0]}'>";
            } else {
                $div_class = "block-translated";
                foreach ($el[1] as $val) {
                    $translation = $val["s"];
                    $translation_entity = preg_replace("/'/", "&#039;", $translation);
                    $meaning = $val["z"];
                    $translation_meaning[] = "<label class='label-highlight separate-checkbox'>
                                                  <span class='keyword-en'>
                                                      <input type='checkbox'
                                                             name='angl[]'
                                                             value='{$translation_entity}'>{$translation}</span> — {$meaning}
                                              </label>";
                }
                $translation_meaning_markup = implode("\n", $translation_meaning);
            }
            echo "<div class='{$div_class}'>
                    <span class='keyword-ru'>
                        <input type='checkbox'
                               name='russk[]'
                               class='hidden'
                               checked
                               value='{$el[0]}'>{$el[0]}</span><br>
                    {$translation_meaning_markup}
              </div>";
            unset ($translation_meaning);
        }
        ?>
        <br>
        <br>
        <span class="counter">
            <?php echo count($_SESSION["arr_kws_ordered"]); ?> / <span id="countUniqEngChecked"></span>
        </span>
        <br>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php'); ?><span id="help" class="help hidden">
            1. <span class="bold">Дубликаты</span> переводов удалятся автоматически.<br>
            2. <span class="bold">Галочки</span> удобнее ставить, щёлкая по связанным строке или слову, а&nbsp;не целясь
            именно в&nbsp;квадратик.
            </span><br>
        </div>
        <br>
        <input name="poluchit"
               type="submit"
               value="5/6 Получить результат строками">
    </form>
    <br>
    <div class="content-right">
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_and_start_over.php'); ?>
    </div>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'); ?>
</div>
<script src="/js/countUniqEngChecked.js"></script>
<script src="/js/uncheckedTranslations.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
