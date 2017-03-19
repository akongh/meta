<?php //error_reporting(0);
session_start();

include( $_SERVER['DOCUMENT_ROOT'].'/meta_config.php' );

if (isset($_POST["opornoe_slovo_zayavki"]))
{
	$opornoe_slovo_zayavki = $_POST["opornoe_slovo_zayavki"];
	unset($_POST["opornoe_slovo_zayavki"]);
	$opornoe_slovo_zayavki = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($opornoe_slovo_zayavki))), "utf-8"));
	$opornoe_slovo_zayavki = preg_replace("/ {2,}/", " ", $opornoe_slovo_zayavki);
	$opornoe_slovo_zayavki = preg_replace("/-{2,}/", "-", $opornoe_slovo_zayavki);
	
	$_MASSIV_opornoe_slovo_zayavki = preg_split("[\n|,|;]", $opornoe_slovo_zayavki, -1, PREG_SPLIT_NO_EMPTY);
	
	for ($i = 0;$i < count($_MASSIV_opornoe_slovo_zayavki);$i++)
	{
		$_MASSIV_opornoe_slovo_zayavki[$i] = trim($_MASSIV_opornoe_slovo_zayavki[$i]);
		}
	
	$_MASSIV_opornoe_slovo_zayavki = array_values(array_unique((array_diff($_MASSIV_opornoe_slovo_zayavki, array('')))));
	
	$_SQL_opornoe_slovo_zayavki = implode("','", $_MASSIV_opornoe_slovo_zayavki);
	
	include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');
	
	$zayavka_na_perevod_opornyx_slov = "
	update `k-ts`
	set `f` = 7
	where `s` in ('".$_SQL_opornoe_slovo_zayavki."') and `f` != 1";
	mysqli_query( $db_connect, $zayavka_na_perevod_opornyx_slov);
	
	$kolichestvo_opornoe_slovo_zayavki = count($_MASSIV_opornoe_slovo_zayavki);
	
	$zayavka_na_perevod = "
	update `k-ts`
	set `f` = 7
	where `s` in
	(select `k`.`s` from
		(select `k-ts`.`s`, `k-ts`.`f`, count(*) from
			(select `k-t_s`.`id_n` from  `k-ts`    
			join `k-t_s` on `k-t_s`.`id_s` = `k-ts`.`ids` 
			where `k-ts`.`s` in ('".$_SQL_opornoe_slovo_zayavki."')
			group by `k-t_s`.`id_n` having count(`k-t_s`.`id_s`) = '".$kolichestvo_opornoe_slovo_zayavki."') `g`   
		join `k-t_s` on `k-t_s`.`id_n` = `g`.`id_n`    
		join `k-ts` on `k-ts`.`ids` = `k-t_s`.`id_s`
		where `k-ts`.`f` in (0, 1, 6, 7)
		group by `k-t_s`.`id_s`, `k-ts`.`s`    
		order by count(*) desc, `k-ts`.`s` LIMIT 0, 160) `k`
	where `k`.`f` = 0)
	";
	mysqli_query( $db_connect, $zayavka_na_perevod);
	mysqli_close($db_connect);
	}

header("Location: http://".$site_domain_name."/meta_admin/ne_xvataet_perevoda.php");

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>