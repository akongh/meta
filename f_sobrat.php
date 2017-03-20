<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

unset(
$_SESSION["oshibka_simvola"],
$_SESSION["oshibka_kolichestva"],
$_SESSION["dopolnitelnye_slova"],
$_SESSION["_REZULTAT_russk_neperevedennye"]
);

include( 'vstavki/regularnye_vyrazheniya.php' );
include( 'meta_config.php' );

$abv = $_POST["abv"];
$slova_s_flagom = $_POST["slova_s_flagom"];
$_MASSIV_rezultata = $_SESSION["_MASSIV_rezultata"];


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////обеспробеливаем массив отмеченных слов///////////////////////////////////////////////////////////////////
if ($slova_s_flagom != NULL)
{
	for ($i = 0; $i < count($slova_s_flagom); $i++)
	{
		$slova_s_flagom_bez_probelov[$i] = trim($slova_s_flagom[$i]);
		}
	}
/////////////////////////////////////////рисуем массив результата с отмеченными словами///////////////////////////////////////////////////////////
for ($i = 0; $i < count($_MASSIV_rezultata); $i++)
{
	if (isset($slova_s_flagom_bez_probelov))
	{
		if (in_array($_MASSIV_rezultata[$i], $slova_s_flagom_bez_probelov))
		{
			$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" checked value = '" . $_MASSIV_rezultata[$i] . "'> " . $_MASSIV_rezultata[$i];
		    }
			else
			{
				$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $_MASSIV_rezultata[$i] . "'> " . $_MASSIV_rezultata[$i];
			    }
		}
		else
		{
			$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $_MASSIV_rezultata[$i] . "'> " . $_MASSIV_rezultata[$i];
			}
	}
if ($spisok != NULL)
{
	$vyvod_spiska_flagov = implode("<br>", $spisok) . "<hr class=\"otbivka_24\">";
	//SESSION///////////////////////////////////////////////
	$_SESSION["vyvod_spiska_flagov"] = $vyvod_spiska_flagov;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////делаем массив из дополнительных слов/////////////////////////////////////////////////////////////	
$vvod_dop_slov = $_POST["vvod_dop_slov"];
$vvod_dop_slov = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($vvod_dop_slov))), "utf-8"));
$vvod_dop_slov = preg_replace("/ {2,}/", " ", $vvod_dop_slov);
$vvod_dop_slov = preg_replace("/-{2,}/", "-", $vvod_dop_slov);

$_MASSIV_dop_slov = preg_split("[\n|,|;]", $vvod_dop_slov, -1, PREG_SPLIT_NO_EMPTY);

for ($i = 0; $i < count($_MASSIV_dop_slov); $i++)
{
	$_MASSIV_dop_slov[$i] = trim($_MASSIV_dop_slov[$i]);
	}

$_MASSIV_dop_slov = array_values(array_unique((array_diff($_MASSIV_dop_slov, array('')))));
////////////////////////////////////удаляем из дополнительных слов те, которые отмечены флажком в подборе//////////////////////////////////////////////////
if (isset($slova_s_flagom_bez_probelov) && isset($_MASSIV_dop_slov))
{
	for ($i = 0;$i < count($_MASSIV_dop_slov);$i++)
	{
		if (!in_array($_MASSIV_dop_slov[$i], $slova_s_flagom_bez_probelov))
		{
			$dopolnenie_unikalnoe[$i] = $_MASSIV_dop_slov[$i];
			}
		}
	}
	else if (!isset($slova_s_flagom_bez_probelov) && isset($_MASSIV_dop_slov))
	{
		$dopolnenie_unikalnoe = $_MASSIV_dop_slov;
		}
//////////////////////////////////делаем строку с переносами из массива уникального дополненния////////////////////////////////
if (isset($dopolnenie_unikalnoe))
{
	$dopolnitelnye_slova = implode("\n", $dopolnenie_unikalnoe);
	//SESSION///////////////////////////////////////////////
	$_SESSION["dopolnitelnye_slova"] = $dopolnitelnye_slova; 
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////делаем вывод ошибки символа, если она есть//////////////////////////////////////////
if(count($dopolnenie_unikalnoe) > 0)
{
	$proverka_simvola = implode("", $dopolnenie_unikalnoe);
	if (!preg_match($regulyar_slova, $proverka_simvola))
	{
		$oshibka_simvola = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; Только кириллица, цифры, пробел и&nbsp;дефис.</span>";
		//SESSION///////////////////////////////////////
		$_SESSION["oshibka_simvola"] = $oshibka_simvola;
		}
	}
/////////////////////////////////////////итоговый массив из подбора, дополнения и состояния////////////////////////////////
if (isset($slova_s_flagom_bez_probelov) && isset($dopolnenie_unikalnoe))
{
    $massiv_itog = array_values(array_unique(array_merge($slova_s_flagom_bez_probelov, $dopolnenie_unikalnoe)));
	}
	else if (isset($slova_s_flagom_bez_probelov) && !isset($dopolnenie_unikalnoe))
	{
    $massiv_itog = $slova_s_flagom_bez_probelov;
		}
		else if (!isset($slova_s_flagom_bez_probelov) && isset($dopolnenie_unikalnoe))
		{
    	$massiv_itog = $dopolnenie_unikalnoe;
			}

if (isset($_SESSION["_MASSIV_sostoyanie_nabora"]) && $massiv_itog != NULL)
{
	$_MASSIV_sostoyanie_nabora = $_SESSION["_MASSIV_sostoyanie_nabora"];
	$massiv_itog = array_values(array_unique(array_merge($_MASSIV_sostoyanie_nabora, $massiv_itog)));
	}
	else if (isset($_SESSION["_MASSIV_sostoyanie_nabora"]) && $massiv_itog == NULL)
	{
		$massiv_itog = $_SESSION["_MASSIV_sostoyanie_nabora"];
		}
//////////////////////////////////////////////////////ещё одна проверка на смесь кирилицы и латиницы////////////////////////////////
if (isset($massiv_itog))
{
	$massiv_itog = array_values(array_unique((array_diff($massiv_itog, array('')))));

	if (count($massiv_itog) > 0)
	{
		$proverka_simvola = implode("", $massiv_itog);
		if (!preg_match($regulyar_slova, $proverka_simvola))
		{
			$oshibka_simvola = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; Только кириллица, цифры, пробел и&nbsp;дефис.</span>";
			//SESSION///////////////////////////////////////
			$_SESSION["oshibka_simvola"] = $oshibka_simvola;
			}
		}
	}
///////////////////////////////////////////////остаёмся исправлять ошибки/////////////////////////////
if(isset($oshibka_simvola))
{
	header("Location: http://".$site_domain_name."/shag_2.php");
	exit;
	}
///////////////////////////////////////////////переходим к третьему шагу, если нет ошибок/////////////
$kol_slov_itog = count($massiv_itog);
//SESSION///////////////////////////////////
$_SESSION["kol_slov_itog"] = $kol_slov_itog;

for ($i = 0; $i < count($massiv_itog); $i++)
{
	$sobranny_nabor[$i] = "<input type=\"checkbox\" name=\"massiv_itog[]\" checked value = '".$massiv_itog[$i]."'> ".$massiv_itog[$i];
	}
if (isset($sobranny_nabor))
{
	/////////////////////////////////сортировать или нет по алфавиту//////////////////////////////////////////////////////////
	if (isset($abv) && $abv == "on")
	{
		sort($sobranny_nabor, SORT_STRING);
		}
		unset($abv);
	
	$sobranny_nabor = implode("<br>\n", $sobranny_nabor);
	}


//$sobranny_nabor = implode("<br>", $massiv_itog);


//SESSION/////////////////////////////////////
$_SESSION["sobranny_nabor"] = $sobranny_nabor;
//SESSION///////////////////////////////
$_SESSION["massiv_itog"] = $massiv_itog;

header("Location: http://".$site_domain_name."/shag_3.php");
?>