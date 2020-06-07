<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Meta management</title>
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
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/management/includes/management_title.php');?>
    <hr class="otbivka_48">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/management/includes/statistic.php');?>
    <hr class="otbivka_24">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/analytics_info.php');?>
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_24">
    <h2>Переводы </h2>
    <hr class="otbivka_48">
    <a href="translation_hint.php">По заявке (анг.—рус.)</a>
    <hr class="otbivka_24">
    <a href="translation_frequency.php">По частоте (рус.—анг.)</a>
    <hr class="otbivka_6">
    <a href="translation_request.php">По заявке (рус.—анг.)</a>
    <hr class="otbivka_6">
    <a href="add_in_request.php">Сброс в заявку (рус.)</a>
    <hr class="otbivka_6">
    <a href="add_related_in_request.php">Заявка на перевод (рус.)</a>
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_24">
    <h2>Правка по связям (возможность не готова)</h2>
    <hr class="otbivka_48">
    <a href="##">Добавление</a><!--Ссылка на файл add.php-->
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_24">
    <h2>Обслуживание</h2>
    <hr class="otbivka_48">
    <a href="/keyword_selection/management/php/ex_frequency_update.php">Обновление частоты (рус.)</a>
    <hr class="otbivka_12">
    <div class="statistika">
        Последний раз обновлено строк: <span class="statistika_czyfra">
<?php
if ( isset( $amount_updated_frequencies ) ) {
	echo $amount_updated_frequencies;
};
?>
  </span></div>
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_96">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/footer.php');?>
    <hr class="otbivka_24">
</div>
</body>
</html>
