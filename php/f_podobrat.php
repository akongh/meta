<?php error_reporting(-1);
session_start();

unset(
$_SESSION["oshibka_nichego_ne_vveli"],
$_SESSION["oshibka_simvola"],
$_SESSION["oshibka_mnogo_op_slov"],
$_SESSION["_REZULTAT_russk_neperevedennye"]
);

include( 'regexp.php' );
include( '../meta_config.php' );

if(isset($_POST["sposob321"])){
	$sposob321 = $_POST["sposob321"];
};
$granicza = $_POST["granicza"];
$vvod_op_slov = $_POST["vvod_op_slov"];
$vvod_op_slov = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($vvod_op_slov))), "utf-8"));
$vvod_op_slov = preg_replace("/ {2,}/", " ", $vvod_op_slov);
$vvod_op_slov = preg_replace("/-{2,}/", "-", $vvod_op_slov);

$_MASSIV_op_slov = preg_split("[\n|,|;]", $vvod_op_slov, -1, PREG_SPLIT_NO_EMPTY);

for ($i = 0;$i < count($_MASSIV_op_slov);$i++)
{
	$_MASSIV_op_slov[$i] = trim($_MASSIV_op_slov[$i]);
	}

$_MASSIV_op_slov = array_values(array_unique((array_diff($_MASSIV_op_slov, array('')))));

$opornye_slova = implode("\n", $_MASSIV_op_slov);
//SESSION///////////////////////////////////
$_SESSION["opornye_slova"] = $opornye_slova; 




if(!isset($_SESSION["_MASSIV_sostoyanie_nabora"]) && $vvod_op_slov == NULL)
{
	$oshibka_nichego_ne_vveli = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; Необходимы опорные ключевые слова.</span>";
	//SESSION///////////////////////////////////////
	$_SESSION["oshibka_nichego_ne_vveli"] = $oshibka_nichego_ne_vveli;
	}

if(count($_MASSIV_op_slov) > 80)
{
	$oshibka_mnogo_op_slov = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; Не более 80-ти опорных ключевых слов.</span>";
	//SESSION///////////////////////////////////////
	$_SESSION["oshibka_mnogo_op_slov"] = $oshibka_mnogo_op_slov;
	}

if(count($_MASSIV_op_slov) > 0)
{
	$proverka_simvola = implode("", $_MASSIV_op_slov);
	if (!preg_match($regulyar_slova, $proverka_simvola))
	{
		$oshibka_simvola = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; Только кириллица, цифры, пробел и&nbsp;дефис.</span>";
		//SESSION///////////////////////////////////////
		$_SESSION["oshibka_simvola"] = $oshibka_simvola;
		}
	}

if (isset($_SESSION["_MASSIV_sostoyanie_nabora"]) && count($_MASSIV_op_slov) > 0)
{
	$_MASSIV_sostoyanie_nabora = $_SESSION["_MASSIV_sostoyanie_nabora"];
	$proverka_simvola = array_values(array_unique(array_merge($_MASSIV_op_slov, $_MASSIV_sostoyanie_nabora)));
	$proverka_simvola = implode("", $proverka_simvola);
	if (!preg_match($regulyar_slova, $proverka_simvola))
	{
		$oshibka_simvola = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; Только кириллица, цифры, пробел и&nbsp;дефис.</span>";
		//SESSION///////////////////////////////////////
		$_SESSION["oshibka_simvola"] = $oshibka_simvola;
		}
	}


if (isset($oshibka_simvola) or isset($oshibka_mnogo_op_slov) or isset($oshibka_nichego_ne_vveli))
{
	header("Location: http://".$site_domain_name."/step_1.php");
	exit;
	}	


$_SQL_stroka_dlya_podbora = implode("','", $_MASSIV_op_slov);
$kolichestvo_opornyx_slov = count($_MASSIV_op_slov);

$_MASSIV_op_slov_strokoj = implode("", $_MASSIV_op_slov);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($sposob321) && $kolichestvo_opornyx_slov>1)
{
	for($i=$kolichestvo_opornyx_slov; $i>0; $i--)
	{
		include( 'sql/SQL_podbor_k.php' );
		$n = 0;
		while ($data = mysqli_fetch_array($_SQL_rezultat_podbora))
		{
			$_MASSIV_rezultata[$n] = $data['s'];
			$n++;
			}
		if ($_MASSIV_rezultata != NULL)
		{
			$_MASSIV_rezultata = array_values(array_unique(array_merge($_MASSIV_op_slov, $_MASSIV_rezultata)));
			if (count($_MASSIV_rezultata) > $kolichestvo_opornyx_slov)
			{
				if (count($_MASSIV_rezultata) > $granicza)
				{
					$_MASSIV_rezultata = array_slice($_MASSIV_rezultata, 0, $granicza);
					}
				break;
				}
			}
		}
	}
	else
	{
		include( '../sql/SQL_podbor_k.php' );
		$n = 0;
		while ($data = mysqli_fetch_array($_SQL_rezultat_podbora))
		{
			$_MASSIV_rezultata[$n] = $data['s'];
			$n++;
			}
		if (isset($_MASSIV_rezultata) && $_MASSIV_rezultata != NULL)
		{
			$_MASSIV_rezultata = array_values(array_unique(array_merge($_MASSIV_op_slov, $_MASSIV_rezultata)));
			}
			else
			{
				$_MASSIV_rezultata = $_MASSIV_op_slov;
				}
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//SESSION///////////////////////////////////////////	
$_SESSION["_MASSIV_rezultata"] = $_MASSIV_rezultata;

for ($i = 0;$i < count($_MASSIV_rezultata);$i++)
{
	if ($i < $kolichestvo_opornyx_slov)
	{
		$_MASSIV_spisok_podbora[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" checked value = '" . $_MASSIV_rezultata[$i] . "'> " . $_MASSIV_rezultata[$i];
		}
		else
		{
			$_MASSIV_spisok_podbora[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $_MASSIV_rezultata[$i] . "'> " . $_MASSIV_rezultata[$i];
			}
	}

if (isset($_MASSIV_spisok_podbora))
{
	$vyvod_spiska_flagov = implode("<br>", $_MASSIV_spisok_podbora) . "<hr class=\"otbivka_24\">";
	//SESSION/////////////////////////////////
	$_SESSION["vyvod_spiska_flagov"] = $vyvod_spiska_flagov;
	}

header("Location: http://".$site_domain_name."/step_2.php");
?>