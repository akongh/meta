<?php error_reporting( - 1 );


$json_selling_keywords = $_POST['jsonSellingKeywords'];

$array_selling_keywords_objects = json_decode( $json_selling_keywords, true );

$k = 0;
for ( $i = 0; $i < count( $array_selling_keywords_objects ); $i ++ ) {
    if ( count( $array_selling_keywords_objects[ $i ]['keywords'] ) > 0 ) {
        for ( $j = 0; $j < count( $array_selling_keywords_objects[ $i ]['keywords'] ); $j ++ ) {
            $keywords_array[ $k ] = $array_selling_keywords_objects[ $i ]['keywords'][ $j ]['keyword'] . ' - ' . $array_selling_keywords_objects[ $i ]['keywords'][ $j ]['percentage'];
            $k ++;
        };
    } else {
        continue;
    };
};

$keywords_array = implode( '<br>', $keywords_array );

echo( $keywords_array );