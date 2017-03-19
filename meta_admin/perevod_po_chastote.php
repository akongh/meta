<?php
session_start();

unset($_SESSION["slovo_original"]);

include ('/meta/meta_config_db.php');

$propustit_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'");
$propustit_otvet = mysqli_fetch_row($propustit_zapros);
$propustit = $propustit_otvet[0];

$perevedeno_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysqli_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

$ne_perevoditsya_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '2'");
$ne_perevoditsya_otvet = mysqli_fetch_row($ne_perevoditsya_zapros);
$ne_perevoditsya = $ne_perevoditsya_otvet[0];

$ne_znakomo_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '4'");
$ne_znakomo_otvet = mysqli_fetch_row($ne_znakomo_zapros);
$ne_znakomo = $ne_znakomo_otvet[0];

$s_oshibkoj_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '3'");
$s_oshibkoj_otvet = mysqli_fetch_row($s_oshibkoj_zapros);
$s_oshibkoj = $s_oshibkoj_otvet[0];

//$slovo_kolichestvo = mysqli_query( $db_connect, "
//	SELECT `k-ts`.`s` slovo, count(*) kol
//	FROM `k-t_s`
//	join `k-ts` on `k-t_s`.`id_s` = `k-ts`.`ids`
//	where `k-ts`.`f` = 0
//	GROUP BY `k-t_s`.`id_s`
//	ORDER BY count(`k-t_s`.`id_s`) DESC
//	LIMIT 1
//	");

$slovo_kolichestvo = mysqli_query( $db_connect, "
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` in (0, 6)
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	");

//$slovo_kolichestvo = mysqli_query( $db_connect, "
//	SELECT `s` slovo, `kol`
//	from `k-ts`
//	where `f` = 0 and `s` regexp ' '
//	ORDER BY `k-ts`.`kol` DESC
//	LIMIT 1
//	");

$n = 0;
while ($data = mysqli_fetch_array($slovo_kolichestvo))
{
	$slovo[$n] = $data['slovo'];
	$kol[$n] = $data['kol'];
	$n++;
	}

//mysqli_query( $db_connect, "
//	UPDATE `k-ts`
//	SET `f` = 10
//	WHERE `s` = '".$slovo."' 
//	");

$slovo = $slovo[0];//var_dump($slovo);
/////////////////////////////////////////////////////////////////////
$SQL_p_z = mysqli_query( $db_connect, "
select `l-ts`.`s`, `tz`.`z`
from `k-ts`
join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
join `tz` on `tz`.`idz`=`k_l`.`idz`
where `k-ts`.`s`='".$slovo."'
");

$n = 0;
while ($rez = mysqli_fetch_array($SQL_p_z))
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

mysqli_close($db_connect);
////////////////////////////////////////////////////////////////////
$kol = $kol[0];//var_dump($kol);
$_SESSION["slovo_original"] = $slovo;

if(isset($slovo))
{
	include('perevod_po_chastote.html');
	}
	else
	{
		include('net_slov_na_perevod.html');
		}

unset($slovo);

?>