<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Перевод по заявке</title>
    <link href="/css/meta_admin.css" rel="stylesheet" type="text/css">
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
    <div class="upravlenie"><a href="/meta_admin.php">На главную</a></div>
    <hr class="otbivka_96">
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/meta_admin/parts/footer.php' );?>
</div>
</body>
</html>
