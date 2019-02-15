<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

$_SESSION["metka"] = true;
if ( isset( $_SESSION["opornye_slova"] ) ) {
    $opornye_slova = $_SESSION["opornye_slova"];
};
if ( isset( $_SESSION["oshibka_nichego_ne_vveli"] ) ) {
    $oshibka_nichego_ne_vveli = $_SESSION["oshibka_nichego_ne_vveli"];
};
if ( isset( $_SESSION["oshibka_simvola"] ) ) {
    $oshibka_simvola = $_SESSION["oshibka_simvola"];
};
if ( isset( $_SESSION["oshibka_mnogo_op_slov"] ) ) {
    $oshibka_mnogo_op_slov = $_SESSION["oshibka_mnogo_op_slov"];
};
if ( isset( $_SESSION["sostoyanie_nabora"] ) ) {
    $sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];
};
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>1/6. Задаём опорные ключевые слова для подбора</title>
    <meta name="Description" content="Подбирайте ключевые слова на русском, результат получайте на английском.
    Составной подбор, удаление дубликатов, задание очерёдности, ручной перевод."/>
    <meta name="Keywords" content="ключевые слова фотографий, фотостоки подбор слов, подбор ключевых слов для фотостоков,
    атрибутирование фотографий, ключевые слова перевод на английский, сервис для создания ключевых слов,
    ключевые слова фотобанков, ключевые слова для фотографа, ключевики для стоков"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/native.css"
          rel="stylesheet"
          type="text/css">
    <link rel="shortcut icon"
          href="http://<?php echo $site_domain_name ?>/favicon.ico"
          type="image/ven.microsoft.ico">
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/yandex_metric_meta.php' );?>
</head>
<body>
<div class="page">
    <br>
    <br>
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/link_to_index.php' );?>
    <br>
    <br>
    <h1 class="bold">1/6. Задаём опорные ключевые слова для подбора</h1>
    <br>
    <br>
    <br>
    <br>
    <?php if (isset( $sostoyanie_nabora )) { echo $sostoyanie_nabora; };?>
    <form action="/php/ex_create_choice_list.php"
          method="post">
        <textarea name="vvod_op_slov"
                  class="textarea-keywords"
                  wrap="soft"
                  rows="8"
                  placeholder=""
                  autofocus><?php if (isset( $opornye_slova )){echo $opornye_slova;};?></textarea>
        <br>
        <?php if (isset( $oshibka_nichego_ne_vveli )) { echo $oshibka_nichego_ne_vveli; };?>
        <?php if (isset( $oshibka_simvola )) { echo $oshibka_simvola; };?>
        <?php if (isset( $oshibka_mnogo_op_slov )) { echo $oshibka_mnogo_op_slov; };?>
        <br>
        <br>
        <br>
        <div class="content-right">
            <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/link_help.php' );?><span id="help" class="help hidden">
            1. <span class="bold">е&nbsp;≠&nbsp;ё</span>.<br>
            2. <span class="bold">Дубликаты</span> ключевых слов удалятся автоматически.<br>
            3. <span class="bold">Галочки</span> удобнее ставить, щёлкая по связанным строке или слову, а&nbsp;не целясь
            именно в&nbsp;квадратик.<br>
            4. <span class="bold">«Не более 80/160»</span>&nbsp;— граница количества ключевых слов в&nbsp;результате подбора на
            следующем шаге. Выбор значения определяется опытным путём и&nbsp;зависит от широты тематики, строгости подбора&nbsp;(п.&nbsp;5)
            и&nbsp;вашего настроя быстрее сделать&nbsp;(80) или больше охватить&nbsp;(160).<br>
            5. <span class="bold">«Нестрого»</span>&nbsp;— постепенное автоматическое уменьшение строгости соответствия подбора
            всему списку опорных ключевых слов сразу, если не удаётся ничего подобрать. Результат подбора увеличивается
            за счёт потери точности и&nbsp;стремится к&nbsp;выбранной границе&nbsp;(п. 4). Условие проявляет действие при двух и&nbsp;более
            опорных ключевых словах. При снятой галочке выполняется строгий подбор, точность максимальная, но увеличение
            количества опорных ключевых слов резко уменьшает результат.
            </span><br>
            <br>
        </div>
        <span title="Граница количества ключевых слов в результате подбора на следующем шаге">Не более <select size="1" name="granicza">
            <option selected value="80">80</option>
            <option value="160">160</option>
        </select>.</span>
        <label title="Постепенное автоматическое уменьшение строгости, если не удаётся ничего подобрать"><input type="checkbox" name="sposob321" checked> Нестрого.</label>
        <br>
        <br>
        <input name="podobrat"
               type="submit"
               value="1/6 Подобрать">
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
