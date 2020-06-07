<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавление по присутствию</title>
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
    <h2>Добавление по присутствию</h2>
    <hr class="otbivka_24">
    <div class="statistika"> Ключевых слов переведено: <span class="statistika_czyfra"><?php echo $perevedeno;?></span>
    </div>
    <hr class="otbivka_96">
    <form method="post" action="add.php">
        <h1>
            <input name="slovo" type="text" class="vvod_slovo" value="<?php echo $slovo;?>">
        </h1>
        <hr class="otbivka_12">
        <div class="kol"><?php echo $kol;?><a href="check_similar_translation.php" target="_blank"
                                              class="proverit_pox_perevod">Проверить похожий перевод &#9658;</a></div>
        <hr class="otbivka_48">
        <div id="parentId">
            <div>
                <input name="perevod[]" type="text" class="vvod_prisutstvie" autofocus>
                <a onclick="return deleteField(this)" href="##" class="link">
                    <div class="minus_plus_prisutstvie">
                        <input type="button" class="pm_knopka" onclick="return deleteField(this)" value="×">
                    </div>
                </a>
                <hr class="otbivka_12">
            </div>
        </div>
        <hr class="otbivka_12">
        <a onclick="return addField()" href="##" class="link">
            <div class="minus_plus_dobavit">
                <input type="button" class="pm_knopka_dobavit_prisutstvie" value="+">
            </div>
        </a>
        <hr class="otbivka_96">
        <input name="dobavlenie" type="submit" value="&#9658; Добавить">
    </form>
    <hr class="otbivka_24">
    <div class="upravlenie"><a href="/keyword_selection/management/php/ex_omit_by_request.php" title="Пропустить">&#9660; Прапускунчунец</a> —
        <span class="statistika_czyfra"><?php echo $propustit;?></span>
        <hr class="otbivka_96">
        <a href="management.php">На главную</a></div>
    <hr class="otbivka_96">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/footer.php');?>
</div>
<script src="/keyword_selection/management/js/addAndDeleteField.js"></script>
</body>
</html>
