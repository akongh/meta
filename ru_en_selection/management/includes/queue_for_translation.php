<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Очередь заявок на перевод</title>
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
    <h2>Очередь заявок на перевод</h2>
    <div class="wrap_list_kws">
        <?= $html_kws_for_translation; ?>
    </div>
    <div class="amount_kws">
        <?= "<span class='amount'>$amount_kws_for_translation</span>"; ?>
    </div>
    <?php
    require($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
</div>
</body>
</html>
