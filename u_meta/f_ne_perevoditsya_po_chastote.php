<?php
session_start();

$slovo_k = $_SESSION["slovo_original"];

include ('/home/webart/www/d_meta/bd_meta.php');
	
mysql_query("
UPDATE `k-ts`
SET `f` = 2
WHERE `s` = '".$slovo_k."' 
");
	
mysql_close($podkluchenie);

header("Location: http://up.meta.afoteris.com/perevod_po_chastote.php");

?>