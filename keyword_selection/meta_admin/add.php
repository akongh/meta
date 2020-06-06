<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

$perevedeno_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'" );
$perevedeno_otvet  = mysqli_fetch_row( $perevedeno_zapros );
$perevedeno        = $perevedeno_otvet[0];

$propustit_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'" );
$propustit_otvet  = mysqli_fetch_row( $propustit_zapros );
$propustit        = $propustit_otvet[0];

$kw_ruolichestvo = mysqli_query( $mysqli, "
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` = 5
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	" );

$n = 0;
while ( $data = mysqli_fetch_array( $kw_ruolichestvo ) ) {
    $slovo[ $n ] = $data["slovo"];
    $kol[ $n ]   = $data["kol"];
    $n ++;
}

$slovo                      = $slovo[0];
$kol                        = $kol[0];
$_SESSION["original_kw"] = $slovo;

mysqli_close( $mysqli );
require($_SERVER["DOCUMENT_ROOT"] . '/meta_admin/includes/add.php');