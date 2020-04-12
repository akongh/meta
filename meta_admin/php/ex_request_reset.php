<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

$zayavka_na_perevod = "
update `k-ts`
set `k-ts`.`f` = 0
where `k-ts`.`f` = 7
";
mysqli_query( $db_connect, $zayavka_na_perevod);
mysqli_close($db_connect);
header("Location: " . $_SERVER["DOCUMENT_ROOT"]."/meta_admin/add_related_in_request.php");