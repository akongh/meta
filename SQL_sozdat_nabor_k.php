<?php //error_reporting(0);
include ('bd.php');

mysql_query("  
INSERT INTO `k-tn` (`vr`, `ses`)  
VALUES ('".$vr_nabora."', '".$ses."')
");

for ($i = 0;$i < count($massiv_itog);$i++)
{
	mysql_query("  
	INSERT IGNORE INTO `k-ts` (`s`)
	VALUES ('".$massiv_itog[$i]."')
	");
	mysql_query("  
	INSERT INTO `k-t_s` (`id_n`, `id_s`)  
	VALUES ((SELECT `idn` FROM `k-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
			(SELECT `ids` FROM `k-ts` WHERE `s` = '".$massiv_itog[$i]."'))  
	");
	}

?>