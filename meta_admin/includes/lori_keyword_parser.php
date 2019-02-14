<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Наборы с Лори</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="http://<?php echo $site_domain_name ?>/favicon.ico" type="image/ven.microsoft.ico">
<style>
.ot-do {
	text-align: right;
	margin: 0px;
	padding: 12px;
	border: 1px solid #3399FF;
	width: 112px;
	font-family: "PT Sans Caption Bold";
	font-size: 24px;
}
</style>
<link rel="shortcut icon" href="http://<?php echo $site_domain_name ?>/favicon.ico" type="image/ven.microsoft.ico">
</head>
<body>
<div class="korobka">
  <h2>Тырка с Лори</h2>
  <hr class="otbivka_96">
  <div class="upravlenie">
    <form action="php/ex_lori_keyword_parser.php" method="post">
      <input name="ot" type="text" class="ot-do" value="<?php echo $nomer_straniczy;?>">
      —
      <input name="do" type="text" class="ot-do" value="<?php echo $nomer_straniczy_2;?>">
      <hr class="otbivka_24">
      <input name="podobrat" type="submit" class="knopka" value="ТЫРНУТЬ у Лори">
    </form>
    <hr class="otbivka_96">
    <a href="index.php">На главную</a> </div>
  <hr class="otbivka_96">
  <?php include('parts/footer.php');?>
</div>
</body>
</html>
