<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Перевод по заявке (рус.—анг.)</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
</head>
<body class="bg">
<div class="wrap">
    <h2>Перевод по заявке (рус.—анг.)</h2>
    <hr class="otbivka_24">
    <a href="management.php">На главную</a>
    <hr class="otbivka_24">
    <div class="statistika">Ключевых слов на русском переведено: <span class="statistika_czyfra"><?php echo $perevedeno;?></span>
        <br>
        Ключевых слов на русском на заявке: <span class="statistika_czyfra"><?php echo $na_zayavke;?></span></div>
    <hr class="otbivka_96">
    <form method="post" action="/keyword_selection/management/php/ex_save_request_translation.php">
        <div class="kol"><a href="divide_and_add.php" class="proverit_pox_perevod">Разбить-добавить &#9658;</a></div>
        <hr class="otbivka_12">
        <h1>
            <input name="slovo" type="text" class="vvod_slovo" value="<?php echo $slovo;?>">
        </h1>
        <hr class="otbivka_12">
        <div class="kol"><?php echo $kol;?><a href="check_similar_translation.php" target="_blank"
                                              class="proverit_pox_perevod">Проверить похожий перевод &#9658;</a></div>
        <hr class="otbivka_24">
        <div class="blok_perevoda">
            <?php echo $with_translation;?> </div>
        <hr class="otbivka_48">
        <div id="parentId">
            <div>
                <input name="perevod[]" type="text" class="vvod_perevod" autofocus>
                —
                <input name="znachenie[]" type="text" class="vvod_znachenie" value="<?php echo $slovo;?>">
                <a href="##" onclick="return deleteField(this)" class="link">
                    <div class="minus_plus">
                        <input type="button" class="pm_knopka" onclick="return deleteField(this)" value="×">
                    </div>
                </a>
                <hr class="otbivka_12">
            </div>
        </div>
        <hr class="otbivka_12">
        <a href="##" onclick="return addField()" class="link">
            <div class="minus_plus_dobavit">
                <input type="button" class="pm_knopka_dobavit" value="+">
            </div>
        </a>
        <hr class="otbivka_96">
        <input name="soxranit_perevod" type="submit" value="&#9658; Сохранить перевод">
    </form>
    <hr class="otbivka_24">
    <div class="upravlenie"><a href="/keyword_selection/management/php/ex_omit_by_request.php" title="Пропустить">&#9660; Пропустить</a> —
        <span class="statistika_czyfra"><?php echo $propustit;?></span>
    </div>
    <hr class="otbivka_96">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/footer.php');?>
</div>
<script src="/keyword_selection/management/js/addAndDeleteField.js"></script>
</body>
</html>
