<?php
session_start();

?>

<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>Подбор ключевых слов</title>
<link href="stili.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="korobka">
  <div class="zamechaniya_2">Версия 1</div>
  <hr class="otbivka_12">
  <div class="zagolovok">3/3.<br>
    Результат.</div>
  <hr class="otbivka_48">
  <?php
$slova_flazhkov = $_POST["flazhok"];

if ($slova_flazhkov)
{
	for ($i = 0; $i < count($slova_flazhkov); $i++)
	{
		$slova_flazhkov_bez_probelov[$i] = trim($slova_flazhkov[$i]);//удаляем лишние пробелы
		}
	}


$dopolnenie = $_POST["dopolnenie"];

if ($dopolnenie)
{
	$dopolnitelnye_slova = explode(";", $dopolnenie);//разбиваем строку дополнительных слов на части и заносим их в массив(есть лишние пробелы)

	for ($i = 0; $i < count($dopolnitelnye_slova); $i++)//перебираем массив из строки в новый массив (без лишних пробелов)
		{
			$dopolnitelnye_slova_bez_probelov[$i] = trim($dopolnitelnye_slova[$i]);//удаляем лишние пробелы
			}
		}	
		
		
if ($slova_flazhkov_bez_probelov && $dopolnitelnye_slova_bez_probelov)
{
	$massiv_itog = array_values(array_unique(array_merge($slova_flazhkov_bez_probelov, $dopolnitelnye_slova_bez_probelov)));
	}		
		
	else if ($slova_flazhkov_bez_probelov && !$dopolnitelnye_slova_bez_probelov)
	{
		$massiv_itog = $slova_flazhkov_bez_probelov;
		}	
		else if (!$slova_flazhkov_bez_probelov && $dopolnitelnye_slova_bez_probelov)
		{
			$massiv_itog = $dopolnitelnye_slova_bez_probelov;
			}
		

	if ($massiv_itog)
	{
		$stroka_itog = implode("; ", $massiv_itog);
		$_SESSION["SESSION_massiv_itog"] = $massiv_itog;//добавляем в сессию массив всех итоговых слов
	echo $stroka_itog;
	echo "<hr class=\"otbivka_24\">";
		}

?>
  <form method="post" action="index_4.php">
    <input name="soxranit" type="submit" class="knopka_2" value="Создать набор и сначала">
    <hr class="otbivka_48">
    <div class="sbros"><a href="index.php">Сбросить и сначала</a></div>
  </form>
</div>
</body>
</html>
