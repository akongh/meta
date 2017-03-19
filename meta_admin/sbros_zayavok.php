<?php //error_reporting(0);
session_start();

include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');
include( $_SERVER['DOCUMENT_ROOT'].'/meta_config.php' );

$zayavka_na_perevod = "
update `k-ts`
set `k-ts`.`f` = 0
where `k-ts`.`f` = 7
";
mysqli_query( $db_connect, $zayavka_na_perevod);
mysqli_close($db_connect);

header("Location: http://".$site_domain_name."/meta_admin/ne_xvataet_perevoda.php");

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>