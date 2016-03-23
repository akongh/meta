<?php

mysql_query("  
INSERT INTO `tn` (`vr`, `ses`)  
VALUES ('".$vr_nabora."', '".$ses."')
");

for ($i = 0;$i < count($massiv_itog);$i++)
{
	mysql_query("  
	INSERT IGNORE INTO `ts` (`s`)
	VALUES ('".$massiv_itog[$i]."')
	");
	mysql_query("  
	INSERT INTO `t_s` (`id_n`, `id_s`)  
	VALUES ((SELECT `idn` FROM `tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
			(SELECT `ids` FROM `ts` WHERE `s` = '".$massiv_itog[$i]."'))  
	");
	}
?>