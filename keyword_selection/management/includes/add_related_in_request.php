<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Заявка на перевод (рус.)</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="//commonresources.afoteris.com/initstyles.css"
          type="text/css">
    <link rel="stylesheet"
          href="/management.css"
          type="text/css">
</head>
<body>
<div class="korobka">
  <h2>Заявка на перевод (рус.)</h2>
  <hr class="otbivka_24">
  <a href="management.php">На главную</a>
  <hr class="otbivka_24">
  <div class="statistika">Ключевых слов на русском переведено: <span class="statistika_czyfra"><?php echo $perevedeno;?></span> <br>
    Ключевых слов на русском на заявке: <span class="statistika_czyfra"><?php echo $na_zayavke;?></span> </div>
  <hr class="otbivka_96">
  <form action="/keyword_selection/management/php/ex_add_related_in_request.php" method="post">
    <textarea name="opornoe_slovo_zayavki" wrap="soft" class="vvod_slov_tekst" placeholder="" autofocus></textarea>
    <hr class="otbivka_24">
    <input name="zayavka" type="submit" class="knopka" value="Отправить заявку">
  </form>
  <hr class="otbivka_96">
  <div class="upravlenie">
  <a href="/keyword_selection/management/php/ex_request_reset.php" title="Сброс заявок" class="krasnaya">&#9660; Сброс заявок</a>
     </div>
  <hr class="otbivka_96">
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/footer.php');?>
</div>
</body>
</html>
