<?php
session_start();

$slovo_k = $_SESSION["slovo_original"];

include ('/meta/meta_config_db.php');
	
mysqli_query( $db_connect, "
UPDATE `k-ts`
SET `f` = 2
WHERE `s` = '".$slovo_k."' 
");
	
mysqli_close($db_connect);

header("Location: http://meta.afoteris.com/meta_admin/perevod_po_chastote.php");

?>