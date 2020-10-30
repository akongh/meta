<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Предпросмотр перевода по частоте</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.ru/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
</head>
<body class="bg">
<div class="wrap">
    <hr class="otbivka_48">
    <div class="blok_perevoda">
        <?php
        if (isset($with_translation)) {
            echo $with_translation;
        } ?>
    </div>
    <hr class="otbivka_24">
    <div class="upravlenie">
        <a href="translation_frequency.php" title="Перевод">&#9658; Продолжить перевод</a>
    </div>
    <hr class="otbivka_96">
</div>
</body>
</html>
