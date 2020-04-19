<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

unset( $_SESSION["original_kw"] );

$na_zayavke_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '7'" );
$na_zayavke_otvet  = mysqli_fetch_row( $na_zayavke_zapros );
$na_zayavke        = $na_zayavke_otvet[0];

$propustit_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '5'" );
$propustit_otvet  = mysqli_fetch_row( $propustit_zapros );
$propustit        = $propustit_otvet[0];

$perevedeno_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '1'" );
$perevedeno_otvet  = mysqli_fetch_row( $perevedeno_zapros );
$perevedeno        = $perevedeno_otvet[0];

$kw_ruolichestvo = mysqli_query( $mysqli, "
	SELECT `s` slovo, `ids`
	from `l-ts`
	where `f` = 7
	ORDER BY `l-ts`.`ids`
	LIMIT 1
	" );

$n = 0;
while ( $data = mysqli_fetch_array( $kw_ruolichestvo ) ) {
    $slovo[ $n ] = $data['slovo'];
//    $kol[ $n ]   = $data['ids'];
    $n ++;
}
if ( isset( $slovo[0] ) ) {
    $slovo = $slovo[0];

    $SQL_p_z = mysqli_query( $mysqli, "
select `k-ts`.`s`, `tz`.`z`
from `k-ts`
join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
join `tz` on `tz`.`idz`=`k_l`.`idz`
where `l-ts`.`s`='" . preg_replace("/'/", "\'", $slovo) . "'
" );
};
if ( isset( $SQL_p_z ) ) {
    $n = 0;
    while ( $rez = mysqli_fetch_array( $SQL_p_z ) ) {
        $p[ $n ]   = $rez['s'];
        $z[ $n ]   = $rez['z'];
        $p_z[ $n ] = "<span class=\"perevod\">" . $p[ $n ] . "</span><span class=\"znachenie\"> — " . $z[ $n ] . "</span>";

        $n ++;
    }
}

if ( isset( $p_z ) ) {
    $p_z         = implode( "<hr class=\"otbivka_0\">", $p_z );
    $with_translation = "<hr class=\"otbivka_6\">" . $p_z . "<hr class=\"otbivka_6\">";
} else {
    $with_translation = "<hr class=\"otbivka_6\"><span class=\"perevoda_net\">…</span><hr class=\"otbivka_6\">";
}

unset( $p_z, $p, $z );

//if ( isset( $kol[0] ) ) {
//    $kol = $kol[0];
//};

if ( isset( $slovo ) ) {

    $queue_hints_translation_querry = mysqli_query( $mysqli, "
	SELECT `s` hints, `ids`
	from `l-ts`
	where `f` = 7
	ORDER BY `l-ts`.`ids`
	" );

    $n = 0;
    while ( $data = mysqli_fetch_array( $queue_hints_translation_querry ) ) {
        if ( $n > 0 ) {
            $queue_hints_translation[ $n ] = $data['hints'];
        };
        $n ++;
    }
    if ( isset( $queue_hints_translation ) && count( $queue_hints_translation ) > 0 ) {
        $queue_hints_translation = implode( '<br>', $queue_hints_translation );
    };

    $_SESSION["original_kw"] = $slovo;
    include( $_SERVER["DOCUMENT_ROOT"] . '/meta_admin/includes/translation_hint.php' );
} else {
    include( $_SERVER["DOCUMENT_ROOT"] . '/meta_admin/includes/no_hints_for_translation.php' );
}

mysqli_close( $mysqli );
unset( $slovo );