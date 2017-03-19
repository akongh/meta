<?php error_reporting( 0 );

session_start();

$russk   = $_POST["russk"];//print_r($russk);
$angl    = $_POST["angl"];//print_r($angl);
$zayavka = $_POST["zayavka"];

if ( isset( $angl ) ) {
	$angl = array_values( array_unique( $angl ) );
}

////$russk_strokoj = implode("", $russk);
//$angl_strokoj = implode("", $angl);

// // if(!preg_match("/[а-яё]+/i", $russk_strokoj))
// // {
// // $angl = $russk;
// // unset($russk);
// // }

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
	include( 'sql/SQL_sozdat_nabor_l.php' );
	$_REZULTAT_angl = implode( ", ", $angl );
}

//////////////////////////////////////////////////////////////////////////////////////
//if(!preg_match("/[a-z]+/i", $massiv_itog_strokoj))
//{
//	include ('sql/SQL_sozdat_nabor_k.php');
//	}
//	else if (!preg_match("/[а-яё]+/i", $massiv_itog_strokoj))
//	{
//		include ('sql/SQL_sozdat_nabor_l.php');
//		}
//////////////////////////////////////////////////////////////////////////////////////

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

header( "Location: http://meta.afoteris.com/shag_6.php" );

?>