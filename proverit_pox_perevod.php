<?php //error_reporting(0);
session_start();

include ('/home/webart/www/d_meta/bd_meta.php');

if(!isset($_POST["slovo_proverka"]))
{
	$slovo = $_SESSION["slovo_original"];
	}
	else
	{
		$slovo = $_POST["slovo_proverka"];
		}

$slovo_kolichestvo = mysql_query("
	SELECT `kol`
	from `k-ts`
	where `s` = '".$slovo."'
	");
$n = 0;
while ($data = mysql_fetch_array($slovo_kolichestvo))
{
	$kol[$n] = $data['kol'];
	$n++;
	}
$kol = $kol[0];

$SQL_p_z = mysql_query("
select `l-ts`.`s`, `tz`.`z`
from `k-ts`
join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
join `tz` on `tz`.`idz`=`k_l`.`idz`
where `k-ts`.`s`='".$slovo."'
");

$n = 0;
while ($rez = mysql_fetch_array($SQL_p_z))
{
	$p[$n] = $rez['s'];
	$z[$n] = $rez['z'];
	$p_z[$n] = "<span class=\"perevod\">".$p[$n]."</span><span class=\"znachenie\"> — ".$z[$n]."</span>";

	$n++;
	}
if (isset($p_z))
{
	$p_z = implode("<hr class=\"otbivka_0\">", $p_z);
	$s_perevodom = "<hr class=\"otbivka_6\">".$p_z."<hr class=\"otbivka_6\">";
	}
	else
	{
		$s_perevodom = "<hr class=\"otbivka_6\"><span class=\"perevoda_net\">…</span><hr class=\"otbivka_6\">";
		}

unset($p_z, $p, $z);

//////////////////////////////////////////////////////////////////////
include ('SQL_podbor_k.php');

$n = 0;
while ($data = mysql_fetch_array($_SQL_rezultat_podbora))
{
	$_MASSIV_rezultata[$n] = $data['s'];
	$n++;
	}

if ($_MASSIV_rezultata != NULL)
{
	$_MASSIV_rezultata = array_values(array_unique($_MASSIV_rezultata));
	}
		
for ($i = 0; $i < count($_MASSIV_rezultata); $i++)
{
	$_MASSIV_spisok_podbora[$i] = $_MASSIV_rezultata[$i];
	}

if (isset($_MASSIV_spisok_podbora))
{
	$vyvod_spiska_flagov = implode("<br>", $_MASSIV_spisok_podbora);
	}
//////////////////////////////////////////////////////////////////////

mysql_close($podkluchenie);	

include('proverit_pox_perevod.html');
?>