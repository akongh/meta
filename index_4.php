<?php
session_start();
$podkluchenie = mysql_connect("by114","andrej","ss4TU0BH") or die("MySQL сервер недоступен!".mysql_error());
	mysql_query("SET character_set_database=utf8"); 
	mysql_query("SET NAMES utf8");	
	mysql_select_db("webart_servis_kluchevyx_slov", $podkluchenie) or die("MySQL сервер недоступен!".mysql_error());

$imya_nabora = time();
$massiv_itog = $_SESSION["SESSION_massiv_itog"];

if ($massiv_itog)
{
//########################################################################
//%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
mysql_query ("
INSERT INTO tablizca_naborov (nabory)
VALUES ('" . $imya_nabora . "')");

for ($i = 0; $i < count($massiv_itog); $i++)
{
	//делаем повторяющуюся часть запроса
mysql_query("
INSERT IGNORE INTO tablizca_slov (slova)
VALUES ('" . $massiv_itog[$i] . "')");

mysql_query("
INSERT INTO tablizca_svyazej (id_naborov, id_slov)
VALUES ((SELECT id_nab FROM tablizca_naborov WHERE nabory = '" . $imya_nabora . "'),
	    (SELECT id_sl FROM tablizca_slov WHERE slova = '" . $massiv_itog[$i] . "'))
");
}
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//############################################################################
}

mysql_close($podkluchenie);
session_destroy();
?>

<?php require_once('index_1.php'); ?>