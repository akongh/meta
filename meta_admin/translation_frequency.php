<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

unset( $_SESSION["slovo_original"] );

$propustit_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'" );
$propustit_otvet  = mysqli_fetch_row( $propustit_zapros );
$propustit        = $propustit_otvet[0];

$perevedeno_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'" );
$perevedeno_otvet  = mysqli_fetch_row( $perevedeno_zapros );
$perevedeno        = $perevedeno_otvet[0];

$slovo_kolichestvo = mysqli_query( $db_connect, "
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` in (0, 6)
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	" );

$n = 0;
while ( $data = mysqli_fetch_array( $slovo_kolichestvo ) ) {
    $slovo[ $n ] = $data['slovo'];
    $kol[ $n ]   = $data['kol'];
    $n ++;
}

if ( isset( $slovo[0] ) ) {
    $slovo = $slovo[0];
};
// написать комментарий
if ( isset( $slovo ) ) {
    $SQL_p_z = mysqli_query( $db_connect, "
    select `l-ts`.`s`, `tz`.`z`
    from `k-ts`
    join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
    join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
    join `tz` on `tz`.`idz`=`k_l`.`idz`
    where `k-ts`.`s`='" . $slovo . "'
    " );
    $n       = 0;
    while ( $rez = mysqli_fetch_array( $SQL_p_z ) ) {
        $p[ $n ]   = $rez['s'];
        $z[ $n ]   = $rez['z'];
        $p_z[ $n ] = "<span class=\"perevod\">" . $p[ $n ] . "</span><span class=\"znachenie\"> — " . $z[ $n ] . "</span>";

        $n ++;
    }
};
if ( isset( $p_z ) ) {
    $p_z         = implode( "<hr class=\"otbivka_0\">", $p_z );
    $s_perevodom = "<hr class=\"otbivka_6\">" . $p_z . "<hr class=\"otbivka_6\">";
} else {
    $s_perevodom = "<hr class=\"otbivka_6\"><span class=\"perevoda_net\">…</span><hr class=\"otbivka_6\">";
}

unset( $p_z, $p, $z );

if ( isset( $kol[0] ) ) {
    $kol = $kol[0];
};

if ( isset( $slovo ) ) {
    $_SESSION["slovo_original"] = $slovo;
    include( 'translation_frequency.html' );
} else {
    include( 'no_keyword_for_translation.html' );
}

mysqli_close( $db_connect );
unset( $slovo );