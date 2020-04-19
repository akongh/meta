<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Сброс в заявку (рус.)</title>
    <link href="/css/meta_admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="korobka">
    <h2>Сброс в заявку (рус.)</h2>
    <hr class="otbivka_24">
    <a href="meta_admin.php">На главную</a>
    <hr class="otbivka_24">
    <div class="statistika">Ключевых слов на русском переведено: <span class="statistika_czyfra">
      <?php if (isset($perevedeno)){echo $perevedeno;};?></span> <br>
        Ключевых слов на русском на заявке: <span class="statistika_czyfra">
          <?php if (isset($na_zayavke)){echo $na_zayavke;};?></span></div>
    <hr class="otbivka_96">
    <form action="php/ex_add_in_request.php" method="post">
        <textarea name="opornoe_slovo_sbrosa" wrap="soft" class="vvod_slov_tekst" placeholder="" autofocus></textarea>
        <hr class="otbivka_24">
        <input name="zayavka" type="submit" class="knopka" value="Сбросить в заявку">
    </form>
    <hr class="otbivka_96">
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/meta_admin/parts/footer.php');?>
</div>
</body>
</html>