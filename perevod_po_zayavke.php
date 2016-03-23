<?php
session_start();

unset($_SESSION["slovo_original"]);

include ('/home/webart/www/_upravlyalka.200slov.andrej.by/bd.php');

$na_zayavke_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'");
$na_zayavke_otvet = mysql_fetch_row($na_zayavke_zapros);
$na_zayavke = $na_zayavke_otvet[0];

$propustit_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'");
$propustit_otvet = mysql_fetch_row($propustit_zapros);
$propustit = $propustit_otvet[0];

$perevedeno_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysql_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

$ne_perevoditsya_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '2'");
$ne_perevoditsya_otvet = mysql_fetch_row($ne_perevoditsya_zapros);
$ne_perevoditsya = $ne_perevoditsya_otvet[0];

$ne_znakomo_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '4'");
$ne_znakomo_otvet = mysql_fetch_row($ne_znakomo_zapros);
$ne_znakomo = $ne_znakomo_otvet[0];

$s_oshibkoj_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '3'");
$s_oshibkoj_otvet = mysql_fetch_row($s_oshibkoj_zapros);
$s_oshibkoj = $s_oshibkoj_otvet[0];

//$slovo_kolichestvo = mysql_query("
//	SELECT `k-ts`.`s` slovo, count(*) kol
//	FROM `k-t_s`
//	join `k-ts` on `k-t_s`.`id_s` = `k-ts`.`ids`
//	where `k-ts`.`f` = 0
//	GROUP BY `k-t_s`.`id_s`
//	ORDER BY count(`k-t_s`.`id_s`) DESC
//	LIMIT 1
//	");

$slovo_kolichestvo = mysql_query("
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` = 7
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	");

//$slovo_kolichestvo = mysql_query("
//	SELECT `s` slovo, `kol`
//	from `k-ts`
//	where `f` = 0 and `s` regexp ' '
//	ORDER BY `k-ts`.`kol` DESC
//	LIMIT 1
//	");

$n = 0;
while ($data = mysql_fetch_array($slovo_kolichestvo))
{
	$slovo[$n] = $data['slovo'];
	$kol[$n] = $data['kol'];
	$n++;
	}

//mysql_query("
//	UPDATE `k-ts`
//	SET `f` = 10
//	WHERE `s` = '".$slovo."' 
//	");

$slovo = $slovo[0];//var_dump($slovo);
/////////////////////////////////////////////////////////////////////
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

mysql_close($podkluchenie);
////////////////////////////////////////////////////////////////////
$kol = $kol[0];//var_dump($kol);
$_SESSION["slovo_original"] = $slovo;

if(isset($slovo))
{
	include('perevod_po_zayavke.html');
	}
	else
	{
		include('net_zayavok_na_perevod.html');
		}

unset($slovo);

?>