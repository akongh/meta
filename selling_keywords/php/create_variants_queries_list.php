<?php error_reporting( - 1 );

$level             = $_POST['level'];
$full_string_query = $_POST['fullStringQuery'];

$queries_array = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $full_string_query ) ) ), "utf-8" );
$queries_array = preg_replace( "/ {2,}/", " ", $queries_array );
$queries_array = preg_split( "/[\n,;]/", $queries_array, - 1, PREG_SPLIT_NO_EMPTY );

for ( $i = 0; $i < count( $queries_array ); $i ++ ) {
    $queries_array[ $i ] = trim( $queries_array[ $i ] );
}

$queries_array = array_values( array_unique( ( array_diff( $queries_array, array( "" ) ) ) ) );

if ( count( $queries_array ) == 0 ) {
    echo( '-1' );
    exit;
}

if ( $level > count( $queries_array ) ) {
    $level = count( $queries_array );
}

$array_main_kw  = array_slice( $queries_array, 0, $level );
$string_main_kw = implode( ', ', $array_main_kw );
$array_other_kw = array_values( array_diff( $queries_array, $array_main_kw ) );

//var_dump( $array_main_kw );
//var_dump( $string_main_kw );
//var_dump( $array_other_kw );
//var_dump( count( $array_other_kw ) );

$count_other_kw = count( $array_other_kw );
//var_dump( $count_other_kw );

$array_result_kw = [];

$array_result_kw[0] = $string_main_kw;

if ( 0 !== $count_other_kw ) {
    for ( $i = 1; $i <= $count_other_kw; $i ++ ) {
        $array_result_kw[ $i ] = $string_main_kw . ', ' . $array_other_kw[ $i - 1 ];
    }
//    var_dump( $array_result_kw );
}

$json_variants_queries_array = json_encode( $array_result_kw );

echo( $json_variants_queries_array );
