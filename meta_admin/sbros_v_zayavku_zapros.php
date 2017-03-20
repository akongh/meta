<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

$na_sbros = $_POST["opornoe_slovo_sbrosa"];
$na_sbros = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($na_sbros))), "utf-8"));
$_MASSIV_na_sbros = preg_split("[\n|,|;]", $na_sbros, -1, PREG_SPLIT_NO_EMPTY);

for ($i = 0;$i < count($_MASSIV_na_sbros);$i++)
{
	$_MASSIV_na_sbros[$i] = trim($_MASSIV_na_sbros[$i]);
	}

$_MASSIV_na_sbros = array_values(array_unique((array_diff($_MASSIV_na_sbros, array('')))));
$_SQL_stroka_na_sbros = implode("','", $_MASSIV_na_sbros);

include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');
include( $_SERVER['DOCUMENT_ROOT'].'/meta_config.php' );

mysqli_query( $db_connect, "UPDATE `k-ts` SET `k-ts`.`f` = 7 WHERE `k-ts`.`s` in ('" . $_SQL_stroka_na_sbros . "')");

mysqli_close($db_connect);

session_unset();
unset($_POST);
unset(
$na_sbros,
$_MASSIV_na_sbros,
$_SQL_stroka_na_sbros
);

header("Location: http://".$site_domain_name."/meta_admin/perevod_po_zayavke.php");





?>