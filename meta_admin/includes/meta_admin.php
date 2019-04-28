<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Управление Метой</title>
    <link href="/css/meta_admin.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="http://<?php echo $site_domain_name ?>/favicon.ico" type="image/ven.microsoft.ico">
    <link rel="shortcut icon" href="http://<?php echo $site_domain_name ?>/favicon.ico" type="image/ven.microsoft.ico">
</head>
<body>
<div class="korobka">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/meta_admin/parts/meta_admin_title.php');?>
    <hr class="otbivka_48">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/meta_admin/parts/statistic.php');?>
    <hr class="otbivka_24">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/meta_admin/parts/yandex_metric_admin.php');?>
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
    <a href="#">Добавление</a><!--Ссылка на файл add.php-->
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_24">
    <h2>Обслуживание</h2>
    <hr class="otbivka_48">
    <a href="php/ex_frequency_update.php">Обновление частоты (рус.)</a>
    <hr class="otbivka_12">
    <div class="statistika">
        Последний раз обновлено строк: <span class="statistika_czyfra">
<?php
if ( isset( $obnovlenie_chastoty ) ) {
	echo $obnovlenie_chastoty;
};
?>
  </span></div>
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_24">
    <h2>Сбор наборов</h2>
    <hr class="otbivka_48">
    <a href="lori_keyword_parser.php">Лори (рус.)</a>
    <hr class="otbivka_48">
    <hr class="cherta">
    <hr class="otbivka_96">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/meta_admin/parts/footer.php');?>
    <hr class="otbivka_24">
</div>
</body>
</html>
