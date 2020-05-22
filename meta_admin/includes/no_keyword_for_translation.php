<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Перевод по частоте</title>
    <link href="/css/meta_admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="korobka">
    <h2>Пераквох па заяуцы;)</h2>
    <hr class="otbivka_24">
    <div class="statistika">
        Ключевых слов переведено: <span class="statistika_czyfra"><?php echo $perevedeno;?></span>
    </div>
    <hr class="otbivka_96">
    Слов на перевод пока нет.
    <hr class="otbivka_96">
    <div class="upravlenie"><a href="meta_admin.php">На главную</a></div>
    <hr class="otbivka_96">
    <?php require( $_SERVER["DOCUMENT_ROOT"] . '/meta_admin/parts/footer.php' );?>
</div>
</body>
</html>
