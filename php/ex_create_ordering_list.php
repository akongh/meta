<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

if ( isset( $_POST["po_chastote"] ) ) {
    $po_chastote = $_POST["po_chastote"];
}

if ( isset( $_POST["massiv_itog"] ) ) {
    $massiv_itog = $_POST["massiv_itog"];
}

if ( !isset($massiv_itog) || count( $massiv_itog ) < 8) {
    $oshibka_kolichestva = "<span class='error'>В наборе менее 8-ми уникальных ключевых слов.</span><br>";

    $_SESSION["oshibka_kolichestva"] = $oshibka_kolichestva;
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php" );
    exit;
}
//сортировать или нет по частоте
if ( isset( $po_chastote ) && $po_chastote == "on" ) {
    $massiv_itog_2 = implode( "','", $massiv_itog );

    $SQL_est_v_base = mysqli_query( $db_connect, "
		select `s`, `kol`
		from `k-ts`
		where `s` in ('" . $massiv_itog_2 . "')
		order by `k-ts`.`kol` desc
		" );
    $n = 0;
    while ( $rez = mysqli_fetch_array( $SQL_est_v_base ) ) {
        $massiv_itog_est_v_base_slovo[ $n ] = $rez['s'];
        $n ++;
    }
    if ( count( $massiv_itog_est_v_base_slovo ) != count( $massiv_itog ) ) {
        $massiv_itog_net_v_base_slova = array_diff( $massiv_itog, $massiv_itog_est_v_base_slovo );
        sort( $massiv_itog_net_v_base_slova, SORT_STRING );
        $massiv_itog = array_merge( $massiv_itog_est_v_base_slovo, $massiv_itog_net_v_base_slova );
    } else {
        ( $massiv_itog = $massiv_itog_est_v_base_slovo );
    }
}

unset( $massiv_itog_2 );
unset( $po_chastote );

$_SESSION["kol_slov_itog"] = count( $_POST["massiv_itog"] );

for ( $i = 0; $i < count( $massiv_itog ); $i ++ ) {
	$ochered[ $i ] = "<li><input type='checkbox' name='spisok_mesto[]' class='hidden' checked value = '" . $massiv_itog[ $i ] . "'>" . $massiv_itog[ $i ] . "</li>";
}

$ochered = implode( "", $ochered );

$_SESSION["ochered"] = $ochered;

mysqli_close( $db_connect );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_4.php" );