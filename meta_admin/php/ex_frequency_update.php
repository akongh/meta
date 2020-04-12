<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

mysqli_query( $db_connect, "
	UPDATE `k-ts`
	SET `k-ts`.`kol` = (SELECT COUNT(*)
	FROM `k-t_s`
	WHERE `k-t_s`.`id_s` = `k-ts`.`ids`)
	" );

$_SESSION["obnovlenie_chastoty"] = mysqli_affected_rows( $db_connect );

mysqli_close( $db_connect );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/meta_admin.php" );