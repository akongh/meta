<?php
session_start();

$slovo_k = $_SESSION["slovo_original"];

include ('/home/webart/www/_upravlyalka.200slov.andrej.by/bd.php');
	
mysql_query("
UPDATE `k-ts`
SET `f` = 4
WHERE `s` = '".$slovo_k."' 
");
	
mysql_close($podkluchenie);

header("Location: http://upravlyalka.200slov.andrej.by/perevod_po_chastote.php");

?>