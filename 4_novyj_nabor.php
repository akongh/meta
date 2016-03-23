<?php
session_start();
include('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

include ('bd.php');
$vr_nabora = time();
$massiv_itog = $_SESSION["SESSION_massiv_itog"];

if ($massiv_itog)
{
	//%%%%%%%% SQL_zapros СВОИ НАБОРЫ %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	mysql_query("  
	INSERT INTO `tn` (`vr`, `el_p`)  
	VALUES ('".$vr_nabora."', '".$el_p_pol."')
	");
	//делаем повторяющуюся часть запроса
		for ($i = 0;$i < count($massiv_itog);$i++)
		{
			mysql_query("  
			INSERT IGNORE INTO `ts` (`s`)  
			VALUES ('".$massiv_itog[$i]."')");
				
			//создаём связи
			mysql_query("  
			INSERT INTO `t_s` (`id_n`, `id_s`)  
			VALUES ((SELECT `idn` FROM `tn` WHERE `vr` = '".$vr_nabora."' AND `el_p` = '".$el_p_pol."'),  
					(SELECT `ids` FROM `ts` WHERE `s` = '".$massiv_itog[$i]."'))  
			");
			mysql_query("  
			INSERT INTO `".$id_pol."--t_s` (`id_n`, `id_s`)  
			VALUES ((SELECT `idn` FROM `tn` WHERE `vr` = '".$vr_nabora."' AND `el_p` = '".$el_p_pol."'),  
					(SELECT `ids` FROM `ts` WHERE `s` = '".$massiv_itog[$i]."'))  
			");
			}
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	}
mysql_close($podkluchenie);
unset($_SESSION["SESSION_massiv_itog"]);
header("Location: /1_vvod_slov.php");
?>