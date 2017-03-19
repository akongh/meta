<?php //error_reporting(0);
session_start();

include ('/meta/meta_config.php');

$slovo_k = $_SESSION['slovo_k'];
$aaa = $_SESSION["aaa"];

$SQL_p_z = mysqli_query( $db_connect, "
select `l-ts`.`s`, `tz`.`z`
from `k-ts`
join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
join `tz` on `tz`.`idz`=`k_l`.`idz`
where `k-ts`.`s`='".$slovo_k."'
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
	$s_perevodom[$i] = "<span class = \"russk\">".$slovo_k."</span><hr class=\"otbivka_6\">".$p_z;
	}
	else
	{
		$s_perevodom[$i] = "<span class = \"russk\">".$slovo_k."</span><hr class=\"otbivka_6\"><span class = \"perevoda_net\">…</span>";
		}

unset($p_z, $p, $z);
	
$s_perevodom = implode("</div><div class = \"blok_perevoda\">", $s_perevodom);//print_r($s_perevodom);

mysqli_close($db_connect);

include('perevod_prosmotr_po_zayavke.html');
?>