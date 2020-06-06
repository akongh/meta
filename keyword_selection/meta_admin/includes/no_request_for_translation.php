<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Перевод по заявке</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/css/meta_admin.css"
          type="text/css">
</head>
<body>
<div class="korobka">
    <h2>Пераквох па заяуцы;)</h2>
    <hr class="otbivka_24">
    <div class="statistika">
        Ключевых слов переведено: <span class="statistika_czyfra"><?php echo $perevedeno;?></span>
        <br>
        Ключевых слов на заявке: <span class="statistika_czyfra"><?php echo $na_zayavke;?></span></div>
    <hr class="otbivka_96">
    Заявок на перевод пока нет.
    <hr class="otbivka_96">
    <div class="upravlenie"><a href="meta_admin.php">На главную</a></div>
    <hr class="otbivka_96">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php');?>
</div>
</body>
</html>
