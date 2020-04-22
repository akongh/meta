<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

if ( ! isset( $_SESSION["presence_mark"] ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta.php" );
}
if ( isset( $_SESSION["with_translation"] ) ) {
    $with_translation = $_SESSION["with_translation"];
};
if ( isset( $_SESSION["about_request"] ) ) {
    $about_request = $_SESSION["about_request"];
};

unset( $_SESSION["about_request"] );

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
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php');?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php' );?>
    <br>
    <br>
    <h1 class="bold">5/6. Выбираем перевод</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/php/ex_create_results_choice.php">
        <?php if (isset($with_translation)){echo $with_translation;}; ?>
        <br>
        <br>
        <span class="counter">
            <?php if (isset($_SESSION["total_kws_amount"])){echo $_SESSION["total_kws_amount"];}; ?>
            /
            <span id="countUniqEngChecked"></span></span>
        <br>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php' );?><span id="help" class="help hidden">
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
    <?php if(isset($about_request)){echo $about_request;};?>
    <?php require( $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php' );?>
</div>
<script src="/js/countUniqEngChecked.js"></script>
<script src="/js/uncheckedTranslations.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
