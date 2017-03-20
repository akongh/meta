<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');
include( $_SERVER['DOCUMENT_ROOT'].'/meta_config.php' );

mysqli_query( $db_connect, "
	UPDATE `k-ts` SET `k-ts`.`kol` = (SELECT COUNT(*) FROM `k-t_s` WHERE `k-t_s`.`id_s` = `k-ts`.`ids`)
	");

$_SESSION["obnovlenie_chastoty"] = mysqli_affected_rows();

//mysqli_query( $db_connect, $link, "UPDATE `k-ts` SET `k-ts`.`kol` = (SELECT COUNT(*) FROM `k-t_s` WHERE `k-t_s`.`id_s` = `k-ts`.`ids`)");
//printf("Обновлено строк: %d\n", mysqli_affected_rows($link));

mysqli_close($db_connect);

header("Location: http://".$site_domain_name."/meta_admin/upravlyalka.php");

?>