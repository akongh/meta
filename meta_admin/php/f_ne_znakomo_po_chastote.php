<?php error_reporting(-1);
session_start();

$slovo_k = $_SESSION["slovo_original"];

include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );
	
mysqli_query( $db_connect, "
UPDATE `k-ts`
SET `f` = 4
WHERE `s` = '".$slovo_k."' 
");
	
mysqli_close($db_connect);

header("Location: http://".$site_domain_name."/meta_admin/perevod_po_chastote.php");

?>