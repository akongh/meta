<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Предпросмотр перевода подсказки</title>
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
<div class="korobka">
    <hr class="otbivka_48">
    <div class="blok_perevoda">
        <?php if (isset($with_translation)){echo $with_translation;};?>
    </div>
    <hr class="otbivka_24">
    <div class="upravlenie">
        <!--Молодец! 7000 слов. Поздравляю!<br>-->
        <a href="translation_hint.php" title="Перевод">&#9658; Продолжить перевод</a>
    </div>
    <hr class="otbivka_96">
</div>
</body>
</html>
