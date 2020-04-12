<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Разбить-добавить (анг.)</title>
    <link href="/css/meta_admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="korobka">
    <h2>Разбить-добавить (анг.)</h2>
    <hr class="otbivka_24">
    <a href="meta_admin.php">На главную</a>
    <hr class="otbivka_24">
    <a href="translation_hint.php">&#9668; По заявке</a>
    <hr class="otbivka_24">
    <div class="statistika">Подсказок переведено: <span class="statistika_czyfra"><?php echo $perevedeno;?></span> <br>
        Подсказок на заявке: <span class="statistika_czyfra"><?php echo $na_zayavke;?></span></div>
    <hr class="otbivka_96">
    <form action="php/ex_divide_hint_and_add.php" method="post">
        <textarea name="novoe_slovo_razbit" wrap="soft" class="vvod_slov_tekst" placeholder=""
                  autofocus><?php echo $slovo_razbit;?></textarea>
        <hr class="otbivka_24">
        <input name="razbit" type="submit" class="knopka" value="Разбить-добавить">
    </form>
    <hr class="otbivka_96">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/meta_admin/parts/footer.php');?>
</div>
</body>
</html>
