<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Проверка похожего перевода</title>
    <link href="/css/meta_admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="korobka">
    <h2>Проверка похожего перевода</h2>
    <hr class="otbivka_96">
    <form method="post" action="check_similar_translation.php">
        <h1>
            <input name="slovo_proverka" type="text" class="vvod_slovo" value="<?php echo $slovo;?>">
        </h1>
        <hr class="otbivka_12">
        <div class="kol"><?php if ( isset ( $kol ) ) { echo $kol; }; ?></div>
        <hr class="otbivka_24">
        <div class="blok_perevoda">
            <?php echo $with_translation;?> </div>
        <hr class="otbivka_48">
        <input name="proverit_pox_perevod" type="submit" class="knopka" value="&#9658; Проверить похожий перевод">
    </form>
    <hr class="otbivka_48">
    <?php if ( isset ( $output_marked_kws_list ) ) { echo $output_marked_kws_list; }; ?>
    <hr class="otbivka_96">
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/meta_admin/parts/footer.php');?>
</div>
</body>
</html>