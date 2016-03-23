<?php
session_start();
include ('metka_vxoda.php');
include ('regularnye_vyrazheniya.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];
$slova_s_flagom = $_POST["slova_s_flagom"];//var_dump($slova_s_flagom);
$dopolnenie = $_POST["dopolnenie"];//var_dump($dopolnenie);
$massiv_rezultata = $_SESSION["massiv_rezultata"];//var_dump($massiv_rezultata);
$kolichestvo_opornyx_slov = $_SESSION["kolichestvo_opornyx_slov"];

include('slova_nabory.php');
include('slova_nabory_pol.php');

////////////////////////////////////////обеспробеливаем массив отмеченных слов///////////////////////////////////////////////////////////////////
if ($slova_s_flagom != NULL)
{
	for ($i = 0; $i < count($slova_s_flagom); $i++)
	{
		//удаляем лишние пробелы, создаём массив отмеченых слов
		$slova_s_flagom_bez_probelov[$i] = trim($slova_s_flagom[$i]);
		}
	}
/////////////////////////////////////////рисуем массив результата с отмеченными словами///////////////////////////////////////////////////////////
for ($i = 0;$i < count($massiv_rezultata);$i++)
{
	if (isset($slova_s_flagom_bez_probelov))
	{
		//проверяем наличие значений подбора в массиве отмеченых элементов подбора
		if (in_array($massiv_rezultata[$i], $slova_s_flagom_bez_probelov))
		{
			//продолжаем вывод результата подбора списком с флажками c новыми отметками, если они есть
			$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
		    }
			else
			{
				//продолжаем вывод результата подбора списком с флажками без отметок
				$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
			    }
		}
		else
		{
			$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
			}
	}
if ($spisok != NULL)
{
	$vyvod_spiska = implode("<br>\n", $spisok) . "<hr class=\"otbivka_24\">";//var_dump($spisok);
	$_SESSION['vyvod_spiska'] = $vyvod_spiska;
	}
////////////////////////////////////////////////////делаем массив из дополнительных слов/////////////////////////////////////////////////////////////	
//помещаем в переменную дополнительные слова строкой
$dopolnenie = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($dopolnenie))), "utf-8"));//var_dump($dopolnenie);
//$dopolnenie = preg_replace("/(the | the | the)+/", " ", $dopolnenie);//var_dump($vvod_slov);
$dopolnenie = preg_replace("/ {2,}/", " ", $dopolnenie);//var_dump($dopolnenie);
//разбиваем строку дополнительных слов на части и заносим их в массив(есть лишние пробелы)
$dop_slova = preg_split("[\n|,|;]", $dopolnenie, -1, PREG_SPLIT_NO_EMPTY);//var_dump($dop_slova);
//перебираем массив из строки в новый массив (без лишних пробелов)
for ($i = 0;$i < count($dop_slova);$i++)
{
	//удаляем лишние пробелы и обрезаем
	$dop_slova_bez_probelov[$i] = trim($dop_slova[$i]);
    }//var_dump($dop_slova_bez_probelov);
////////////////////////////////////делаем вывод ошибки символа, если она есть//////////////////////////////////////////////////////////////////	
if (isset($dop_slova_bez_probelov))
{
	//возвращаем последовательность индексам, удаляем дубликаты
	$dop_slova_bez_probelov = array_values(array_unique((array_diff($dop_slova_bez_probelov, array('')))));//var_dump($dop_slova_bez_probelov);
	if (count($dop_slova_bez_probelov) > 0)
	{
		//готовим дополнительные слова для проверки на соответствие регулярному выраженияю
		$dop_slova = implode("", $dop_slova_bez_probelov);//var_dump($dop_slova);
		if (!preg_match($regulyar_slova, $dop_slova))
		{
			$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
			}
		}
	}
////////////////////////////////////удаляем из дополнительных слов те, которые отмечены флажком в подборе и выводим их в окно дополнения//////////////
//var_dump(!isset($slova_s_flagom_bez_probelov));
//var_dump($dop_slova_bez_probelov);
if (isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov))
{
	//сравниваем дополнение с подбором и удаляем из дополнения дубликаты элементов подбора
	for ($i = 0;$i < count($dop_slova_bez_probelov);$i++)
	{
		if (!in_array($dop_slova_bez_probelov[$i], $slova_s_flagom_bez_probelov))
		{
			$dopolnenie_unikalnoe[$i] = $dop_slova_bez_probelov[$i];
			}
		}
	}
	else if (!isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov))
	{
		$dopolnenie_unikalnoe = $dop_slova_bez_probelov;//var_dump($dop_slova_bez_probelov);
		}
//////////////////////////////////делаем строку с переносами из массива уникального дополненния////////////////////////////////////////////////////////////
if (isset($dopolnenie_unikalnoe)) {//echo "dopolnenie_unikalnoe массив — ";var_dump($dopolnenie_unikalnoe);echo "<br>";
    $dopolnenie_unikalnoe = implode("\n", $dopolnenie_unikalnoe);//var_dump($dopolnenie_unikalnoe);
	$_SESSION['dopolnenie_unikalnoe'] = $dopolnenie_unikalnoe;
}
/////////////////////////////////////////итоговый массив из подбора и дополнения/////////////////////////////////////////////////////////////////////////////////////
if (isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov)) {
    $massiv_itog = array_values(array_unique(array_merge($slova_s_flagom_bez_probelov, $dop_slova_bez_probelov)));
} else if (isset($slova_s_flagom_bez_probelov) && !isset($dop_slova_bez_probelov)) {
    $massiv_itog = $slova_s_flagom_bez_probelov;
} else if (!isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov)) {
    $massiv_itog = $dop_slova_bez_probelov;
}
//////////////////////////////////////////////////////ещё одна проверка на смесь кирилицы и латиницы//////////////////////////////////////////////////////////
if (isset($massiv_itog))
{
	//возвращаем последовательность индексам, удаляем дубликаты
	$massiv_itog = array_values(array_unique((array_diff($massiv_itog, array('')))));//var_dump($dop_slova_bez_probelov);
	if (count($massiv_itog) > 0)
	{
		//готовим дополнительные слова для проверки на соответствие регулярному выраженияю
		$massiv_itog_stroka = implode("", $massiv_itog);//var_dump($dop_slova);
		if (!preg_match($regulyar_slova, $massiv_itog_stroka))
		{
			$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
			}
		}
	}
//////////////////////////////////////////////////////ошибка малого количества слов для набора////////////////////////////////////////////////////////////////
if (count($massiv_itog) < 10 )
{
	$oshibka_massiv_itog_10 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">В наборе менее 10-ти уникальных ключевых слов.</span>";
	}
///////////////////////////////////////////////переходим к третьему шагу, если нет ошибок/////////////////////////////////////////////////////////////////////
if (!isset($oshibka_massiv_itog_10) && !isset($oshibka_simvol))
{
	//добавляем в сессию массив всех итоговых слов
	$_SESSION["SESSION_massiv_itog"] = $massiv_itog; 
	$kol_slov_itog = count($massiv_itog);
	$stroka_itog = implode("; ", $massiv_itog);
	include ('shag_3.html');
	}
	else
		{
			include ('shag_2.html');
			}
?>