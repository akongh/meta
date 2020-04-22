<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');

if ( isset( $_POST["po_chastote"] ) ) {
    $po_chastote = $_POST["po_chastote"];
}

if ( isset( $_POST["resulting_arr"] ) ) {
    $resulting_arr = $_POST["resulting_arr"];
}

if ( !isset($resulting_arr) || count( $resulting_arr ) < 8) {
    $err_msg_of_kws_amount = "<span class='error'>В наборе менее 8-ми уникальных ключевых слов.</span><br>";

    $_SESSION["err_msg_of_kws_amount"] = $err_msg_of_kws_amount;
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php" );
    exit;
}
//сортировать или нет по частоте
if ( isset( $po_chastote ) && $po_chastote == "on" ) {
    $resulting_arr_2 = implode( "','", $resulting_arr );

    $mysqli_result = $mysqli->query( sql_select_kws_frequency($resulting_arr_2) );
    $data           = $mysqli_result->fetch_all(MYSQLI_ASSOC);
    $mysqli_result->free();

    $mysqli->close();

    foreach ( $data as $key => $val ) {
        $resulting_arr_est_v_base_slovo[ $key ] = $val["s"];
    }
    if ( count( $resulting_arr_est_v_base_slovo ) != count( $resulting_arr ) ) {
        $resulting_arr_net_v_base_slova = array_diff( $resulting_arr, $resulting_arr_est_v_base_slovo );
        sort( $resulting_arr_net_v_base_slova, SORT_STRING );
        $resulting_arr = array_merge( $resulting_arr_est_v_base_slovo, $resulting_arr_net_v_base_slova );
    } else {
        ( $resulting_arr = $resulting_arr_est_v_base_slovo );
    }
}

unset( $resulting_arr_2 );
unset( $po_chastote );

$_SESSION["total_kws_amount"] = count( $_POST["resulting_arr"] );

for ( $i = 0; $i < count( $resulting_arr ); $i ++ ) {
	$priority_kws[ $i ] = "<li><input type='checkbox' name='spisok_mesto[]' class='hidden' checked value = '" . $resulting_arr[ $i ] . "'>" . $resulting_arr[ $i ] . "</li>";
}

$priority_kws = implode( "", $priority_kws );

$_SESSION["priority_kws"] = $priority_kws;

header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_4.php" );