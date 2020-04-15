<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta.php" );
}
if ( isset( $_SESSION["vyvod_spiska_flagov"] ) ) {
    $vyvod_spiska_flagov = $_SESSION["vyvod_spiska_flagov"];
};
if ( isset( $_SESSION["dopolnitelnye_slova"] ) ) {
    $dopolnitelnye_slova = $_SESSION["dopolnitelnye_slova"];
};
if ( isset( $_SESSION["oshibka_simvola"] ) ) {
    $oshibka_simvola = $_SESSION["oshibka_simvola"];
};
if ( isset( $_SESSION["sostoyanie_nabora"] ) ) {
    $sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];
};
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>2/6. Выбираем из подобранных и добавляем свои</title>
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
    <h1 class="bold">2/6. Выбираем из подобранных…</h1>
    <br>
    <br>
    <br>
    <br>
    <form method="post"
          action="/php/ex_create_check_choice_list.php">
        <?php if (isset($vyvod_spiska_flagov)){echo $vyvod_spiska_flagov;};?>
        <?php if (isset($sostoyanie_nabora)){echo $sostoyanie_nabora;};?>
        <h1 class="bold">…и добавляем свои</h1>
        <br>
        <textarea name="vvod_dop_slov"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""><?php if (isset($dopolnitelnye_slova)){echo $dopolnitelnye_slova;};?></textarea>
        <br>
        <?php if (isset($oshibka_simvola)){echo $oshibka_simvola;};?>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_help.php' );?><span id="help" class="help hidden">
            1. <span class="bold">е&nbsp;≠&nbsp;ё</span>.<br>
            2. <span class="bold">Дубликаты</span> ключевых слов удалятся автоматически.<br>
            3. <span class="bold">Галочки</span> удобнее ставить, щёлкая по связанным строке или слову, а&nbsp;не целясь
            именно в&nbsp;квадратик.<br>
            4. <span class="bold">«Уточнить запрос»</span>&nbsp;— вернёт вас на первый шаг с&nbsp;сохранением списка опорных
            ключевых слов.<br>
            5. <span class="bold">«Алфавитный порядок»</span>&nbsp;— выстраивает на следующем шаге общий результат подбора
            в&nbsp;алфавитном порядке, чтобы удобнее было исключать похожие избыточные ключевые слова. Галочку имеет смысл
            снять, если вас устраивает текущий порядок ключевых слов. Это сэкономит время на четвёртом шаге при
            определении очерёдности.
            </span><br>
            <br>
            <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_back_to_step_1_refine_current_query.php' );?><br>
        </div>
        <br>
        <label title="Для наглядного определения избыточных похожих ключевых слов на следующем шаге">
            <input type="checkbox"
                   checked
                   name="abv">
            Алфавитный порядок.</label>
        <br>
        <br>
        <input name="sobrat"
               type="submit"
               value="2/6 Собрать в список">
    </form>
    <br>
    <div class="content-right">
        <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/link_reset_choice.php' );?>
    </div>
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php' );?>
</div>
<script src="/js/selectAll.js"></script>
<script src="/js/showHelp.js"></script>
</body>
</html>
