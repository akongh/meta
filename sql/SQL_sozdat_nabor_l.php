<?php error_reporting(0);
include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');

if(isset($angl))
{
	$angl2 = $angl;//из-за кавычек
	for ($i = 0; $i < count($angl2); $i++)
	{
		$angl2[$i] = trim($angl2[$i]);
		$angl2[$i] = preg_replace("/ {2,}/", " ", $angl2[$i]);
		$angl2[$i] = preg_replace("/'/", "\'", $angl2[$i]);
		}
	}

mysqli_query( $db_connect, "  
INSERT INTO `l-tn` (`vr`, `ses`)  
VALUES ('".$vr_nabora."', '".$ses."')
");

for ($i = 0;$i < count($angl2);$i++)
{
	mysqli_query( $db_connect, "  
	INSERT IGNORE INTO `l-ts` (`s`)
	VALUES ('".$angl2[$i]."')
	");
	mysqli_query( $db_connect, "  
	INSERT INTO `l-t_s` (`id_n`, `id_s`)  
	VALUES ((SELECT `idn` FROM `l-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
			(SELECT `ids` FROM `l-ts` WHERE `s` = '".$angl2[$i]."'))  
	");
	}

?>