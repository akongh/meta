<?php
session_start();

include ('bd.php');
$vr_nabora = time();
$massiv_itog = $_SESSION["SESSION_massiv_itog"];
$ses = session_id();

if ($massiv_itog)
{
	//%%%%%%%% SQL_zapros СВОИ НАБОРЫ %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	mysql_query("  
	INSERT INTO `tn` (`vr`, `ses`)  
	VALUES ('".$vr_nabora."', '".$ses."')
	");
	//делаем повторяющуюся часть запроса
		for ($i = 0;$i < count($massiv_itog);$i++)
		{
			mysql_query("  
			INSERT IGNORE INTO `ts` (`s`)
			VALUES ('".$massiv_itog[$i]."')
			");
			//создаём связи
			mysql_query("  
			INSERT INTO `t_s` (`id_n`, `id_s`)  
			VALUES ((SELECT `idn` FROM `tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
					(SELECT `ids` FROM `ts` WHERE `s` = '".$massiv_itog[$i]."'))  
			");
			}
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	}
mysql_close($podkluchenie);
unset(
$_SESSION["SESSION_massiv_itog"],
$_SESSION["vvod_slov_utochnit"],
$_SESSION['vyvod_spiska'],
$_SESSION['dopolnenie_unikalnoe']
);
header("Location: http://200slov.andrej.by");
?>