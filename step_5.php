<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}
if ( isset( $_SESSION["s_perevodom"] ) ) {
    $s_perevodom = $_SESSION["s_perevodom"];
};
if ( isset( $_SESSION["pro_zayavku"] ) ) {
    $pro_zayavku = $_SESSION["pro_zayavku"];
};

include( 'html/step_5.html' );

unset( $_SESSION["pro_zayavku"] );
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>5/6. Выбираем перевод</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/native.css"
          rel="stylesheet"
          type="text/css">
    <link rel="shortcut icon"
          href="http://<?php echo $site_domain_name ?>/favicon.ico"
          type="image/ven.microsoft.ico">
    <?php include('shtml/yandex_metric_meta.shtml');?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php include('shtml/link_to_index.shtml');?>
    <br>
    <br>
    <h1 class="bold">5/6. Выбираем перевод</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="../php/ex_create_results_choice.php">
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
            <?php include('shtml/link_help.shtml');?><span id="help" class="help hidden">
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
        <?php include('shtml/link_reset_choice.shtml');?>
    </div>
    <?php if(isset($pro_zayavku)){echo $pro_zayavku;};?>
    <?php include('shtml/footer.shtml');?>
</div>
<script src="../js/countUniqEngChecked.js"></script>
<script src="../js/uncheckedTranslations.js"></script>
<script src="../js/showHelp.js"></script>
</body>
</html>
