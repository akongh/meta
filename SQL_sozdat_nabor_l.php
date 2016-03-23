<?php //error_reporting(0);
include ('/home/webart/www/_200slov.andrej.by/bd.php');

mysql_query("  
INSERT INTO `l-tn` (`vr`, `ses`)  
VALUES ('".$vr_nabora."', '".$ses."')
");

for ($i = 0;$i < count($angl);$i++)
{
	mysql_query("  
	INSERT IGNORE INTO `l-ts` (`s`)
	VALUES ('".$angl[$i]."')
	");
	mysql_query("  
	INSERT INTO `l-t_s` (`id_n`, `id_s`)  
	VALUES ((SELECT `idn` FROM `l-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
			(SELECT `ids` FROM `l-ts` WHERE `s` = '".$angl[$i]."'))  
	");
	}

?>