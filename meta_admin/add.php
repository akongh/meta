<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

$perevedeno_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'" );
$perevedeno_otvet  = mysqli_fetch_row( $perevedeno_zapros );
$perevedeno        = $perevedeno_otvet[0];

$propustit_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'" );
$propustit_otvet  = mysqli_fetch_row( $propustit_zapros );
$propustit        = $propustit_otvet[0];

$slovo_kolichestvo = mysqli_query( $db_connect, "
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` = 5
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	" );

$n = 0;
while ( $data = mysqli_fetch_array( $slovo_kolichestvo ) ) {
    $slovo[ $n ] = $data['slovo'];
    $kol[ $n ]   = $data['kol'];
    $n ++;
}

$slovo                      = $slovo[0];
$kol                        = $kol[0];
$_SESSION["slovo_original"] = $slovo;

mysqli_close( $db_connect );
include( 'includes/add.php' );