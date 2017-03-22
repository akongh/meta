<?php error_reporting( - 1 );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
if ( isset( $russk ) ) {
    $russk2 = $russk;
    for ( $i = 0; $i < count( $russk2 ); $i ++ ) {
        $russk2[ $i ] = trim( $russk2[ $i ] );
        $russk2[ $i ] = preg_replace( "/ {2,}/", " ", $russk2[ $i ] );
        $russk2[ $i ] = preg_replace( "/'/", "\'", $russk2[ $i ] );
    }
}
mysqli_query( $db_connect, "  
INSERT INTO `k-tn` (`vr`, `ses`)  
VALUES ('" . $vr_nabora . "', '" . $ses . "')
" );
for ( $i = 0; $i < count( $russk2 ); $i ++ ) {
    mysqli_query( $db_connect, "  
	INSERT IGNORE INTO `k-ts` (`s`)
	VALUES ('" . $russk2[ $i ] . "')
	" );
    mysqli_query( $db_connect, "  
	INSERT INTO `k-t_s` (`id_n`, `id_s`)  
	VALUES ((SELECT `idn` FROM `k-tn` WHERE `vr` = '" . $vr_nabora . "' AND `ses` = '" . $ses . "'),  
			(SELECT `ids` FROM `k-ts` WHERE `s` = '" . $russk2[ $i ] . "'))  
	" );
}