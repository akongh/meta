<?php //error_reporting(0);
include ('/home/webart/www/_200slov.andrej.by/bd.php');

mysql_query("  
INSERT INTO `k-tn` (`vr`, `ses`)  
VALUES ('".$vr_nabora."', '".$ses."')
");

for ($i = 0;$i < count($russk);$i++)
{
	mysql_query("  
	INSERT IGNORE INTO `k-ts` (`s`)
	VALUES ('".$russk[$i]."')
	");
	mysql_query("  
	INSERT INTO `k-t_s` (`id_n`, `id_s`)  
	VALUES ((SELECT `idn` FROM `k-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
			(SELECT `ids` FROM `k-ts` WHERE `s` = '".$russk[$i]."'))  
	");
	}

?>