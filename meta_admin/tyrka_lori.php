<?php
//1 000 000 ≠ 1 020 000
$ot = $_POST["ot"];
$do = $_POST["do"];
for ( $ot; $ot <= $do; $ot ++ ) {
	sleep( 1 );
	include( '/home/webart/www/meta_access/db_connect.php' );
	$kod_straniczy = file_get_contents( 'http://lori.ru/' . $ot );
	if ( $kod_straniczy == false ) {
		print_r( $ot );
		echo( "<hr>" );
		flush();
		mysql_query( "
		UPDATE `tyrki`
		SET `lori` = '" . $ot . "'
		WHERE `f` = '1'
		" );
		mysql_close( $podkluchenie );
	} else if ( $kod_straniczy == true ) {
		preg_match_all( "/<a href=\"\/search\/images\/.*<\/a>/", $kod_straniczy, $stroka );
		$stroka = $stroka[0];
		for ( $i = 0; $i < count( $stroka ); $i ++ ) {
			$stroka[ $i ] = preg_replace( "/<\/a>/", "", $stroka[ $i ] );
			$stroka[ $i ] = trim( preg_replace( "/<.*>/", "", $stroka[ $i ] ) );
			if ( ! preg_match( "/[a-z]+/i", $stroka[ $i ] ) ) {
				$stroka_kir[ $i ] = $stroka[ $i ];
			}
		}
		if ( count( $stroka_kir ) > 0 ) {
			$stroka = array_values( array_unique( $stroka_kir ) );
		}
		if ( count( $stroka ) > 0 ) {
			$vr_nabora = time();
			$ses       = 'lori';
			mysql_query( "  
				INSERT INTO `k-tn` (`vr`, `ses`)  
				VALUES ('" . $vr_nabora . "', '" . $ses . "')
				" );
			for ( $i = 0; $i < count( $stroka ); $i ++ ) {
				mysql_query( "  
					INSERT IGNORE INTO `k-ts` (`s`)
					VALUES ('" . $stroka[ $i ] . "')
					" );
				mysql_query( "  
					INSERT INTO `k-t_s` (`id_n`, `id_s`)  
					VALUES ((SELECT `idn` FROM `k-tn` WHERE `vr` = '" . $vr_nabora . "' AND `ses` = '" . $ses . "'),  
							(SELECT `ids` FROM `k-ts` WHERE `s` = '" . $stroka[ $i ] . "'))  
					" );
			}
			mysql_query( "
				UPDATE `tyrki`
				SET `lori` = '" . $ot . "'
				/*WHERE `f` = '1'*/
				" );
		}
		$stroka = implode( "; ", $stroka );
		print_r( $stroka );
		echo( "<br>" );
		print_r( $ot );
		echo( "<hr>" );
		flush();
		unset(
			$kod_straniczy,
			$stroka,
			$stroka_kir );
		mysql_close( $podkluchenie );
	}
}
?>