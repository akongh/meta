<?php error_reporting( - 1 );
session_start();

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta.php" );
}
if ( isset( $_SESSION["ochered"] ) ) {
    $ochered = $_SESSION["ochered"];
};
if ( isset( $_SESSION["oshibka_kolichestva"] ) ) {
    $oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];
};
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>4/6. Определяем очерёдность ключевых слов</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/analytics_code.php');?>
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/changeOrderingList.js"></script>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/link_to_index.php' );?>
    <br>
    <br>
    <h1 class="bold">4/6. Определяем очерёдность ключевых слов</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/php/ex_create_translation_list.php">
        <ul id="sortable">
            <?php if(isset($ochered)){echo $ochered;}; ?>
        </ul>
        <br>
        <br>
        <span class="counter">
            <?php if (isset($_SESSION["kol_slov_itog"])){echo $_SESSION["kol_slov_itog"];}; ?></span>
        <br>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/link_help.php' );?><span id="help" class="help hidden">
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
        <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/link_reset_choice.php' );?>
    </div>
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' );?>
</div>
<script src="/js/showHelp.js"></script>
</body>
</html>
