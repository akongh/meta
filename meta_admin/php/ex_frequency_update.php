<?php error_reporting( - 1 );
session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

mysqli_query( $mysqli, "
	UPDATE `k-ts`
	SET `k-ts`.`kol` = (SELECT COUNT(*)
	FROM `k-t_s`
	WHERE `k-t_s`.`id_s` = `k-ts`.`ids`)
	" );

$_SESSION["amount_updated_frequencies"] = mysqli_affected_rows( $mysqli );

mysqli_close( $mysqli );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/meta_admin.php" );