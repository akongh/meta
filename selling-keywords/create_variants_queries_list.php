<?php error_reporting( - 1 );


$full_string_query = $_POST['fullStringQuery'];


$queries_array = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $full_string_query ) ) ), "utf-8" );
$queries_array = preg_replace( "/ {2,}/", " ", trim( $queries_array ) );
$queries_array = preg_split( "[\n|,|;]", $queries_array, - 1, PREG_SPLIT_NO_EMPTY );

for ( $i = 0; $i < count( $queries_array ); $i ++ ) {
    $queries_array[ $i ] = trim( $queries_array[ $i ] );
};

$queries_array = array_values( array_unique( ( array_diff( $queries_array, array( "" ) ) ) ) );

if ( count( $queries_array ) == 0 ) {
    echo( '-1' );
    exit;
};

$n = 0;
for ( $i = 0; $i < count( $queries_array ); $i ++ ) {
    $queries_array_2 = $queries_array;
    if ( $i > 0 ) {
        array_splice( $queries_array_2, $i );
        $first_elem = implode( ' ', $queries_array_2 );
        for ( $j = $i; $j < count( $queries_array ); $j ++ ) {
            $variants_queries_array[ $n ] = $first_elem . ' ' . $queries_array[ $j ];
            $n ++;
        };
    } else {
        for ( $j = $i; $j < count( $queries_array ); $j ++ ) {
            $variants_queries_array[ $n ] = $queries_array[ $j ];
            $n ++;
        };
    };
};

for ( $i = 0; $i < count( $variants_queries_array ); $i ++ ) {
    $variants_queries_array[ $i ] = str_pad( $i + 1, 2, 0, STR_PAD_LEFT ) . ' <span class="variant-query" name="variant-query">' . $variants_queries_array[ $i ] . '</span>';
};


$result_variats_queries = implode( '<br>', $variants_queries_array );


echo( $result_variats_queries );