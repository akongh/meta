<?php error_reporting( - 1 );
session_start();

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta.php" );
}
if ( isset( $_SESSION["s_perevodom"] ) ) {
    $s_perevodom = $_SESSION["s_perevodom"];
};
if ( isset( $_SESSION["pro_zayavku"] ) ) {
    $pro_zayavku = $_SESSION["pro_zayavku"];
};

unset( $_SESSION["pro_zayavku"] );
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
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/includes/analytics_code.php');?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_to_index.php' );?>
    <br>
    <br>
    <h1 class="bold">5/6. Выбираем перевод</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/php/ex_create_results_choice.php">
        <?php if (isset($s_perevodom)){echo $s_perevodom;}; ?>
        <br>
        <br>
        <span class="counter">
            <?php if (isset($_SESSION["kol_slov_itog"])){echo $_SESSION["kol_slov_itog"];}; ?>
            /
            <span id="countUniqEngChecked"></span></span>
        <br>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php' );?><span id="help" class="help hidden">
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
        <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_choice.php' );?>
    </div>
    <?php if(isset($pro_zayavku)){echo $pro_zayavku;};?>
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php' );?>
</div>
<script src="/js/countUniqEngChecked.js"></script>
<script src="/js/uncheckedTranslations.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
