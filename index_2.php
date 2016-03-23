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
  <div class="zagolovok">2/3.<br>Уточните и дополните выбор своими ключевыми словами.</div>
  <hr class="otbivka_48">
  
  <form method = "post" action="index_3.php">
  
  <?php
  
if ($_POST["vvod_slov"])
{
	$podkluchenie = mysql_connect("by114","andrej","ss4TU0BH") or die("MySQL сервер недоступен!".mysql_error());
	mysql_query("SET character_set_database=utf8"); 
	mysql_query("SET NAMES utf8");	
	mysql_select_db("webart_servis_kluchevyx_slov", $podkluchenie) or die("MySQL сервер недоступен!".mysql_error());

	$vvod_slov = $_POST["vvod_slov"]; //помещаем в переменную опорные слова строкой
	$oporn_slova = explode("\n", $vvod_slov);//разбиваем строку опорных слов на части и заносим их в массив(есть лишние пробелы)

	for ($i = 0; $i < count($oporn_slova); $i++)//перебираем массив из строки в новый массив (без лишних пробелов)
		{
			$oporn_slova_bez_probelov[$i] = trim($oporn_slova[$i]);
			}
			
			// ЗДЕСЬ НУЖНО УДАЛИТЬ ИЗ МАССИВА $oporn_slova_bez_probelov ВСЕ ЭЛЕМЕНТЫ БЕЗ БУКВ
	
	$kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov);//количество опорных слов
	
	
//########################################################################
//%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
for ($i = 0; $i < $kolichestvo_opornyx_slov; $i++)
	{
		//выбираем id наборов, с которыми связаны заданные пользователем слова
		$massiv_osnovy_zaprosa[$i] = "
		(SELECT id_naborov FROM tablizca_svyazej WHERE id_slov = (SELECT id_sl FROM tablizca_slov WHERE slova = '" . $oporn_slova_bez_probelov[$i] . "')
		";//но здесь не хватает закрывающих скобок для SQL запроса
		}
		
$osnova_zaprosa = implode(" AND id_naborov IN ", $massiv_osnovy_zaprosa);

$zakryvayushhchie_skobki = ")";

for ($i = 0; $i < $kolichestvo_opornyx_slov; $i++)//нужное число закрывающих скобок
{
	$zakryvayushhchie_skobki .= ")";
	}
	
$SQL_zapros = "
	SELECT slova FROM tablizca_slov WHERE id_sl IN
	(SELECT id_slov FROM tablizca_svyazej WHERE id_naborov IN
	" . $osnova_zaprosa . $zakryvayushhchie_skobki . "
	";
	//print_r($SQL_zapros);
	//echo "<br>";
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%	
//############################################################################


$rezultat_podbora = mysql_query($SQL_zapros);

mysql_close($podkluchenie);
	
$n = 0;//номера ячеек $massiv_rezultata
	while ($data = mysql_fetch_array($rezultat_podbora))//если в $rezultat_podbora нет ни одной записи, то цикл не выполняется
		{
		$massiv_rezultata[$n] = $data['slova'];//массив для вывода результата подбора строкой
		$n++;
		};
		
if ($massiv_rezultata)
{
		$massiv_rezultata = array_values(array_unique(array_merge($oporn_slova_bez_probelov, $massiv_rezultata)));//объединяем массивы, удаляем дубликаты и переписываем индексы
	}
	else
	{
		$massiv_rezultata = $oporn_slova_bez_probelov;
		}


//#################################################################################
// РИСУЕМ СПИСОК ПОДБОРА С ФЛАЖКАМИ ###############################################
	for ($i = 0; $i < count($massiv_rezultata); $i++)
	{
		if ($i < $kolichestvo_opornyx_slov)//сколько первых слов (первыми пойдут те, которые ввёл пользователь) отметить птичкой
		{
			//начинаем вывод результата подбора списком с флажками и сразу отмечаем те, которые ввёл пользователь
			echo "<input type=\"checkbox\" name=\"flazhok[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i] . "<br>\n";
			}
			else
			{
				//продолжаем вывод результата подбора списком с флажками без отметок
				echo "<input type=\"checkbox\" name=\"flazhok[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i] . "<br>\n";
				}
		}
// ЗАКОНЧИЛИ РИСОВАТЬ СПИСОК ПОДБОРА С ФЛАЖКАМИ ##################################
//################################################################################

	
	echo "<hr class=\"otbivka_24\">";
}
?>
  
  <!--продолжение формы-->
  <textarea name="dopolnenie" wrap="off" class="dopolnenie" placeholder="" autofocus></textarea>
  <div class="zamechaniya">Разделяйте ключевые слова переносом строки.</div>
  <hr class="otbivka_12">
  <input name="sobrat" type="submit" class="knopka" value="Собрать">
  <hr class="otbivka_48">
  <div class="sbros"><a href="index.php">Сбросить и сначала</a></div>
  </form>
</div>
</body>
</html>
