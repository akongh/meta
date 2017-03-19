<?php error_reporting(0);
session_start();

//$massiv_itog = $_SESSION["massiv_itog"];

$po_chastote = $_POST["po_chastote"];
$massiv_itog = $_POST["massiv_itog"];

if (count($massiv_itog) < 8)
{
	$oshibka_kolichestva = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; В наборе менее 8-ми уникальных ключевых слов.</span>";
	//SESSION///////////////////////////////////////////////
	$_SESSION["oshibka_kolichestva"] = $oshibka_kolichestva;
	header("Location: http://meta.afoteris.com/shag_3.php");
	exit;
	}
	
	
	
	//*******************************************************************************************************************
/////////////////////////////////сортировать или нет по частоте//////////////////////////////////////////////////////////
	if (isset($po_chastote) && $po_chastote == "on")
	{
		$massiv_itog_2 = implode("','", $massiv_itog);
		
		include ('/home/webart/www/meta_access/db_connect.php');
		
		$SQL_est_v_base = mysql_query("
		select `s`, `kol`
		from `k-ts`
		where `s` in ('".$massiv_itog_2."')
		order by `k-ts`.`kol` desc
		");
	
		mysql_close($podkluchenie);	
	
		$n = 0;
	
		while ($rez = mysql_fetch_array($SQL_est_v_base))
	
		{
			$massiv_itog_est_v_base_slovo[$n] = $rez['s'];
			$n++;
			}
		
		if (count($massiv_itog_est_v_base_slovo) != count($massiv_itog))
		{
			$massiv_itog_net_v_base_slova = array_diff($massiv_itog, $massiv_itog_est_v_base_slovo);
			sort($massiv_itog_net_v_base_slova, SORT_STRING);
			$massiv_itog = array_merge($massiv_itog_est_v_base_slovo, $massiv_itog_net_v_base_slova);
			}
			else ($massiv_itog = $massiv_itog_est_v_base_slovo);
		}
		
		unset($massiv_itog_2);
		unset($po_chastote);
		//*******************************************************************************************************************




//SESSION/////////////////////////////////////
$_SESSION["kol_slov_itog"] = count($_POST["massiv_itog"]);

for ($i = 0; $i < count($massiv_itog); $i++)
{
	$ochered[$i] = "<li><input type=\"checkbox\" name=\"spisok_mesto[]\" checked value = '".$massiv_itog[$i]."' hidden=\"true\">".$massiv_itog[$i]."</li>";
	}
	
$ochered = implode("", $ochered);

//SESSION/////////////////////////////////////
$_SESSION["ochered"] = $ochered;

header("Location: http://meta.afoteris.com/shag_4.php");
?>