<?php
session_start();

include ('regularnye_vyrazheniya.php');

$slova_s_flagom = $_POST["slova_s_flagom"];
$dopolnenie = $_POST["dopolnenie"];
$massiv_rezultata = $_SESSION["massiv_rezultata"];
$kolichestvo_opornyx_slov = $_SESSION["kolichestvo_opornyx_slov"];

include('SQL_slova_nabory.php');

////////////////////////////////////////обеспробеливаем массив отмеченных слов///////////////////////////////////////////////////////////////////
if ($slova_s_flagom != NULL)
{
	for ($i = 0; $i < count($slova_s_flagom); $i++)
	{
		$slova_s_flagom_bez_probelov[$i] = trim($slova_s_flagom[$i]);
		}
	}
/////////////////////////////////////////рисуем массив результата с отмеченными словами///////////////////////////////////////////////////////////
for ($i = 0;$i < count($massiv_rezultata);$i++)
{
	if (isset($slova_s_flagom_bez_probelov))
	{
		if (in_array($massiv_rezultata[$i], $slova_s_flagom_bez_probelov))
		{
			$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
		    }
			else
			{
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
	$vyvod_spiska = implode("<br>\n", $spisok) . "<hr class=\"otbivka_24\">";
	$_SESSION["vyvod_spiska"] = $vyvod_spiska;
	}
////////////////////////////////////////////////////делаем массив из дополнительных слов/////////////////////////////////////////////////////////////	
$dopolnenie = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($dopolnenie))), "utf-8"));
$dopolnenie = preg_replace("/ {2,}/", " ", $dopolnenie);
$dop_slova = preg_split("[\n|,|;]", $dopolnenie, -1, PREG_SPLIT_NO_EMPTY);
for ($i = 0;$i < count($dop_slova);$i++)
{
	$dop_slova_bez_probelov[$i] = trim($dop_slova[$i]);
    }
////////////////////////////////////делаем вывод ошибки символа, если она есть//////////////////////////////////////////////////////////////////	
if (isset($dop_slova_bez_probelov))
{
	$dop_slova_bez_probelov = array_values(array_unique((array_diff($dop_slova_bez_probelov, array('')))));
	if (count($dop_slova_bez_probelov) > 0)
	{
		$dop_slova = implode("", $dop_slova_bez_probelov);
		if (!preg_match($regulyar_slova, $dop_slova))
		{
			$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
			}
		}
	}
////////////////////////////////////удаляем из дополнительных слов те, которые отмечены флажком в подборе и выводим их в окно дополнения//////////////
if (isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov))
{
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
		$dopolnenie_unikalnoe = $dop_slova_bez_probelov;
		}
//////////////////////////////////делаем строку с переносами из массива уникального дополненния////////////////////////////////////////////////////////////
if (isset($dopolnenie_unikalnoe))
{
    $dopolnenie_unikalnoe = implode("\n", $dopolnenie_unikalnoe);
	$_SESSION["dopolnenie_unikalnoe"] = $dopolnenie_unikalnoe;
	}
	else
	{
		unset($_SESSION["dopolnenie_unikalnoe"]);
		}
/////////////////////////////////////////итоговый массив из подбора и дополнения/////////////////////////////////////////////////////////////////////////////////////
if (isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov)) {
    $massiv_itog = array_values(array_unique(array_merge($slova_s_flagom_bez_probelov, $dop_slova_bez_probelov)));
} else if (isset($slova_s_flagom_bez_probelov) && !isset($dop_slova_bez_probelov)) {
    $massiv_itog = $slova_s_flagom_bez_probelov;
} else if (!isset($slova_s_flagom_bez_probelov) && isset($dop_slova_bez_probelov)) {
    $massiv_itog = $dop_slova_bez_probelov;
}
if(isset($_SESSION["massiv_itog_zapom"]) && $massiv_itog != NULL)
{
	$massiv_itog_zapom = $_SESSION["massiv_itog_zapom"];
	$massiv_itog = array_values(array_unique(array_merge($massiv_itog_zapom, $massiv_itog)));
	}
//////////////////////////////////////////////////////ещё одна проверка на смесь кирилицы и латиницы//////////////////////////////////////////////////////////
if (isset($massiv_itog))
{
	$massiv_itog = array_values(array_unique((array_diff($massiv_itog, array('')))));
	if (count($massiv_itog) > 0)
	{
		$massiv_itog_stroka = implode("", $massiv_itog);
		if (!preg_match($regulyar_slova, $massiv_itog_stroka))
		{
			$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
			}
		}
	}
//////////////////////////////////////////////////////ошибка малого количества слов для набора////////////////////////////////////////////////////////////////
if (!isset($_SESSION["massiv_itog_zapom"]))
{
	if (count($massiv_itog) < 10 )
	{
		$oshibka_massiv_itog_10 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">В наборе менее 10-ти уникальных ключевых слов.</span>";
		}
	}
///////////////////////////////////////////////переходим к третьему шагу, если нет ошибок/////////////////////////////////////////////////////////////////////
if (!isset($oshibka_massiv_itog_10) && !isset($oshibka_simvol))
{
	if(isset($massiv_itog))
	{
		$kol_slov_itog = count($massiv_itog);
		$stroka_itog = implode("; ", $massiv_itog);
		$_SESSION["kol_slov_itog"] = $kol_slov_itog;
		$_SESSION["stroka_itog"] = $stroka_itog;
		$_SESSION["massiv_itog"] = $massiv_itog;
		}
	header("Location: http://200slov.andrej.by/3_rezultat.php");
	}
	else
		{
			$_SESSION["oshibka_massiv_itog_10"] = $oshibka_massiv_itog_10;
			$_SESSION["oshibka_simvol"] = $oshibka_simvol;
			header("Location: http://200slov.andrej.by/2_dopolnenie.php");
			}

?>