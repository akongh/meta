<?php
session_start();

$slovo_k = $_SESSION["slovo_original"];

include ('/meta/meta_config.php');
	
mysqli_query( $db_connect, "
UPDATE `k-ts`
SET `f` = 3
WHERE `s` = '".$slovo_k."' 
");
	
mysqli_close($db_connect);

header("Location: http://up.meta.afoteris.com/perevod_po_zayavke.php");

?>