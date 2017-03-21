<?php error_reporting(E_ALL ^E_NOTICE);

session_start();

include( 'meta_config.php' );

$russk   = $_POST["russk"];
$angl    = $_POST["angl"];
$zayavka = $_POST["zayavka"];

if ( isset( $angl ) ) {
	$angl = array_values( array_unique( $angl ) );
}



$_SESSION["kol_slov_russk"] = count( $russk );
if ( isset( $angl ) ) {
	$_SESSION["kol_slov_angl"] = count( $angl );
} else {
	$_SESSION["kol_slov_angl"] = 0;
};

$vr_nabora = time();
$ses       = session_id();

if ( isset( $russk ) ) {
	include( 'sql/SQL_sozdat_nabor_k.php' );
	$_REZULTAT_russk = implode( ", ", $russk );
}

if ( isset( $angl )) {
	$_REZULTAT_angl = implode( ", ", $angl );
}



if ( isset( $zayavka ) ) {
	$zayavka     = implode( "', '", $zayavka );
	$SQL_zayavka = mysqli_query( $db_connect,  "
	update `k-ts`
	set `f` = 7
	where `s` in ('" . $zayavka . "')
	" );
}

//SESSION///////////////////////////

$_SESSION["_REZULTAT_russk"] = $_REZULTAT_russk;
$_SESSION["_REZULTAT_angl"]  = $_REZULTAT_angl;

header( "Location: http://".$site_domain_name."/shag_6.php" );

?>