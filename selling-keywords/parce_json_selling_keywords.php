<?php error_reporting( - 1 );

$json_selling_keywords          = $_POST['jsonSellingKeywords'];
$array_selling_keywords_objects = json_decode( $json_selling_keywords, true );

$k = 0;
for ( $i = 0; $i < count( $array_selling_keywords_objects ); $i ++ ) {
    if ( count( $array_selling_keywords_objects[ $i ]['keywords'] ) > 0 ) {
        for ( $j = 0; $j < count( $array_selling_keywords_objects[ $i ]['keywords'] ); $j ++ ) {
//            $keywords_array[ $k ]['keyword']    = $array_selling_keywords_objects[ $i ]['keywords'][ $j ]['keyword'];
            $keywords_array[ $k ] = $array_selling_keywords_objects[ $i ]['keywords'][ $j ]['keyword'];
//            $keywords_array[ $k ]['percentage'] = $array_selling_keywords_objects[ $i ]['keywords'][ $j ]['percentage'];
            $k ++;
        };
    } else {
        continue;
    };
};

$count_original = count( $keywords_array );

//for ( $i = 0; $i < count( $keywords_array ); $i ++ ) {
//    if ( $keywords_array[ $i ] != null ) {
//        for ( $j = $i + 1; $j < count( $keywords_array ); $j ++ ) {
//            if ( $keywords_array[ $j ] != null ) {
//                if ( $keywords_array[ $i ]['keyword'] === $keywords_array[ $j ]['keyword'] ) {
//                    if ( $keywords_array[ $i ]['percentage'] < $keywords_array[ $j ]['percentage'] ) {
//                        $keywords_array[ $i ]['percentage'] = $keywords_array[ $j ]['percentage'];
//                    };
//                    $keywords_array[ $j ] = null;
//                };
//            } else {
//                continue;
//            };
//        };
//    } else {
//        continue;
//    };
//};
//
//$k = 0;
//for ( $i = 0; $i < count( $keywords_array ); $i ++ ) {
//    if ( $keywords_array[ $i ] != null ) {
//        $result[ $k ]['keyword']    = $keywords_array[ $i ]['keyword'];
//        $result[ $k ]['percentage'] = $keywords_array[ $i ]['percentage'];
//        $k ++;
//    } else {
//        continue;
//    };
//};
//
//usort( $result, function ( $a, $b ) {//хрень, а не сортировка какая-то
//    return ( (int)$a['percentage'] - (int)$b['percentage'] );
//} );

$result = array_values( array_unique( $keywords_array ) );
sort($result);

$count_result = count( $result );

//for ( $i = 0; $i < count( $result ); $i ++ ) {
//    $result[ $i ] = $result[ $i ]['keyword'] . ' - ' . $result[ $i ]['percentage'];
//};

$result = implode( '<br>', $result );

echo( $result . '<br>' . '====' . '<br>' . $count_original . '<br>' . $count_result );