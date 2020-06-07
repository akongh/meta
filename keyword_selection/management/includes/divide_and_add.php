<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Разбить-добавить (рус.)</title>
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
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/management/includes/link_to_main.php');
    require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/management/includes/management_title.php'); ?>
    <h2>Разбить-добавить (рус.)</h2>
    <hr class="otbivka_24">
    <a href="translation_request.php">&#9668; По заявке</a>
    <hr class="otbivka_24">
    <div class="statistika">Ключевых слов на русском переведено: <span
                class="statistika_czyfra"><?php
            echo $perevedeno; ?></span> <br>
        Ключевых слов на русском на заявке: <span class="statistika_czyfra"><?php
            echo $na_zayavke; ?></span></div>
    <hr class="otbivka_96">
    <form action="/keyword_selection/management/php/ex_divide_and_add.php" method="post">
        <textarea name="novoe_slovo_razbit" wrap="soft" class="vvod_slov_tekst" placeholder=""
                  autofocus><?php
            echo $slovo_razbit; ?></textarea>
        <hr class="otbivka_24">
        <input name="razbit" type="submit" value="Разбить-добавить">
    </form>
    <hr class="otbivka_96">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
</body>
</html>
