<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');

if (!isset($_SESSION["presence_mark"])) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/meta.php");
}

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
          action="/php/ex_create_results_choice.php">

        <?php if (!($mysqli_stmt_translation = $mysqli->prepare(SQL_SELECT_EN_TRANSLATION_AND_MEANING))) {
            echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
        }
        if (!($mysqli_stmt_statuses = $mysqli->prepare(SQL_SELECT_KW_STATUSES))) {
            echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
        }

        for ($i = 0; $i < count($_SESSION["arr_kws_ordered"]); $i++) {
            if (!$mysqli_stmt_translation->bind_param("s", $_SESSION["arr_kws_ordered"][$i])) {
                echo PHP_EOL . $mysqli_stmt_translation->errno . " --> " . $mysqli_stmt_translation->error . PHP_EOL;
            }
            if (!$mysqli_stmt_translation->execute()) {
                echo PHP_EOL . $mysqli_stmt_translation->errno . " --> " . $mysqli_stmt_translation->error . PHP_EOL;
            }
            $result = $mysqli_stmt_translation->get_result();
            $sql_select_en_translation_and_meaning = $result->fetch_all(MYSQLI_ASSOC);
            $mysqli_stmt_translation->free_result();

            foreach ($sql_select_en_translation_and_meaning as $key => $val) {
                $p[$key] = $val["s"];
                $p2[$key] = preg_replace("/'/", "&#039;", $p[$key]);
                $z[$key] = $val["z"];
                $p_z[$key] = "
        <label class='label-highlight separate-checkbox'>
            <span class='keyword-en'>
                <input type='checkbox'
                       name='angl[]'
                       value='" . $p2[$key] . "'> " . $p[$key] . "
            </span> — " . $z[$key] . "
        </label>
        ";
            }

            //выясняем флаг русского слова, если оно уже есть в базе, или его отсутствие, если слова в базе пока нет
            if (!$mysqli_stmt_statuses->bind_param("s", $_SESSION["arr_kws_ordered"][$i])) {
                echo PHP_EOL . $mysqli_stmt_statuses->errno . " --> " . $mysqli_stmt_statuses->error . PHP_EOL;
            }
            if (!$mysqli_stmt_statuses->execute()) {
                echo PHP_EOL . $mysqli_stmt_statuses->errno . " --> " . $mysqli_stmt_statuses->error . PHP_EOL;
            }
            $result = $mysqli_stmt_statuses->get_result();
            $sql_select_kw_statuses = $result->fetch_all(MYSQLI_ASSOC);
            $mysqli_stmt_statuses->free_result();

            foreach ($sql_select_kw_statuses as $key => $val) {
                $f[$key] = $val["f"];
            }

            if (isset($f[0])) {
                $f = $f[0];
            } else {
                $f = null;
            };

            if (isset($p_z) && count($p_z) > 1) {
                $p_z = implode("\n", $p_z);
                $with_translation[$i] = "
        <div class='block-translated'>
		    <span class='keyword-ru'>
		        <input type='checkbox'
                       name='russk[]'
                       class='hidden'
                       checked
                       value='" . $_SESSION["arr_kws_ordered"][$i] . "'>" . $_SESSION["arr_kws_ordered"][$i] . "
		    </span>
            <br>
            " . $p_z . "
        </div>
        ";
            } else {
                if (isset($p_z) && count($p_z) == 1) {
                    $p_z = "
        <label class='label-highlight separate-checkbox'>
                <span class='keyword-en'>
                    <input type='checkbox'
                           name='angl[]'
                           checked
                           value='" . $p2[0] . "'> " . $p[0] . "
                </span> — " . $z[0] . "
        </label>";
                    $with_translation[$i] = "
        <div class='block-translated'>
                <span class='keyword-ru'>
                    <input type='checkbox'
                           name='russk[]'
                           class='hidden'
                           checked
                           value='" . $_SESSION["arr_kws_ordered"][$i] . "'>" . $_SESSION["arr_kws_ordered"][$i] . "
                </span>
            <br>
            " . $p_z . "
        </div>
        ";
                } else {
                    if (!isset($p_z) && ($f == 0 or $f == null)) {
                        $arr_kws_untranslated[$i] = $_SESSION["arr_kws_ordered"][$i];
                        $with_translation[$i] = "
        <div class='block-not-translated'>
                    <span class='keyword-ru'>
                        <input type='checkbox'
                               name='russk[]'
                               class='hidden'
                               checked
                               value='" . $_SESSION["arr_kws_ordered"][$i] . "'>" . $_SESSION["arr_kws_ordered"][$i] . "
                    </span>
            <br>
            (перевода пока нет)<input type='checkbox'
                                      name='zayavka[]'
                                      class='hidden'
                                      checked
                                      value='" . $_SESSION["arr_kws_ordered"][$i] . "'>
        </div>
        ";
                    } else {
                        if (!isset($p_z) && $f == 7) {
                            $arr_kws_untranslated[$i] = $_SESSION["arr_kws_ordered"][$i];
                            $with_translation[$i] = "
        <div class='block-not-translated'>
                        <span class='keyword-ru'>
                            <input type='checkbox'
                                   name='russk[]'
                                   class='hidden'
                                   checked
                                   value='" . $_SESSION["arr_kws_ordered"][$i] . "'>" . $_SESSION["arr_kws_ordered"][$i] . "
                        </span>
            <br>
            (в заявке на перевод)<input type='checkbox'
                                        name='zayavka[]'
                                        class='hidden'
                                        checked
                                        value='" . $_SESSION["arr_kws_ordered"][$i] . "'>
        </div>
        ";
                        }
                    }
                }
            }

            unset($p_z, $p, $z, $f);
        }

        $mysqli_stmt_translation->close();
        $mysqli_stmt_statuses->close();

        echo implode("\n", $with_translation);

        if (isset($arr_kws_untranslated)) {
            $_SESSION["arr_kws_untranslated"] = $arr_kws_untranslated;
        }

        $mysqli->close(); ?>

        <br>
        <br>
        <span class="counter">
            <?php echo count($_SESSION["arr_kws_ordered"]); ?>
            /
            <span id="countUniqEngChecked"></span></span>
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
