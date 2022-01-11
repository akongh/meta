<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Перевод по частоте</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="/_third_party/normalize.css"
          type="text/css">
    <link rel="stylesheet"
          href="/style.css"
          type="text/css">
</head>
<body class="bg">
<div class="wrap">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/link_to_main.php');
    require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/management_title.php'); ?>
    <h2>Пераквох па заяуцы;)</h2>
    <hr class="otbivka_24">
    <div class="statistika">
        Ключевых слов переведено: <span class="statistika_czyfra"><?php
            echo $perevedeno; ?></span>
    </div>
    <hr class="otbivka_96">
    Слов на перевод пока нет.
    <hr class="otbivka_96">
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . '/footer.php'); ?>
</div>
</body>
</html>
