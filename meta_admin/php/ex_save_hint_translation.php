<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

$original_kw = $_SESSION["original_kw"];
if ( isset( $_POST["slovo"] ) ) {
    $kw_en = $_POST["slovo"];
};
if ( isset( $_POST["perevod"] ) ) {
    $perevod = $_POST["perevod"];
};
if ( isset( $_POST["znachenie"] ) ) {
    $znachenie = $_POST["znachenie"];
};

if ( isset( $perevod ) ) {
    for ( $i = 0; $i < count( $perevod ); $i ++ ) {
        $perevod[ $i ] = trim( $perevod[ $i ] );
        $perevod[$i] = preg_replace(["/ {2,}/", "/'/"], [" ", "\'"], $perevod[$i]);
    }
}

if ( isset( $znachenie ) ) {
    for ( $i = 0; $i < count( $znachenie ); $i ++ ) {
        $znachenie[ $i ] = trim( $znachenie[ $i ] );
        $znachenie[$i] = preg_replace(["/ {2,}/", "/'/"], [" ", "\'"], $znachenie[$i]);
        if ( $znachenie[ $i ] == "" ) {
            $znachenie[ $i ] = $perevod[ $i ];
        } else {
            $znachenie[ $i ] = $perevod[ $i ] . ' (' . $znachenie[ $i ] . ')';
        }
    }
}

if ( $original_kw != $kw_en ) {
    $proverka_nalichiya_slova = mysqli_query( $mysqli, "  
	SELECT `s` FROM `l-ts` WHERE `s` = '" . preg_replace( "/'/", "\'", $kw_en) . "'
	" );

    $n = 0;
    while ( $data = mysqli_fetch_array( $proverka_nalichiya_slova ) ) {
        $proverka_nalichiya[ $n ] = $data['s'];
        $n ++;
    }

    if ( ! isset( $proverka_nalichiya ) ) {
        mysqli_query( $mysqli, "
		UPDATE `l-ts`
		SET `s` = '" . preg_replace( "/'/", "\'", $kw_en) . "', `f` = 1
		WHERE `s` = '" . preg_replace( "/'/", "\'", $original_kw) . "' 
		" );
    } else if ( isset( $proverka_nalichiya ) ) {


        $ids_original = mysqli_query( $mysqli, "
			SELECT `ids` FROM `l-ts` WHERE `s` = '" . preg_replace( "/'/", "\'", $original_kw) . "'
			" );

        $n = 0;
        while ( $data = mysqli_fetch_array( $ids_original ) ) {
            $ids_orig[ $n ] = $data['ids'];
            $n ++;
        }

        $ids_original = $ids_orig[0];


        $ids_ispravlennogo = mysqli_query( $mysqli, "
			SELECT `ids` FROM `l-ts` WHERE `s` = '" . preg_replace( "/'/", "\'", $kw_en) . "'
			" );

        $n = 0;
        while ( $data = mysqli_fetch_array( $ids_ispravlennogo ) ) {
            $ids_ispr[ $n ] = $data['ids'];
            $n ++;
        }

        $ids_ispravlennogo = $ids_ispr[0];


//        mysqli_query( $mysqli, "
//			UPDATE LOW_PRIORITY IGNORE `k-t_s`
//			SET `id_s` = '" . $ids_ispravlennogo . "'
//			WHERE `id_s` = '" . $ids_original . "'
//			" );

        mysqli_query( $mysqli, "
			UPDATE LOW_PRIORITY IGNORE `k_l`
			SET `idl` = '" . $ids_ispravlennogo . "'
			WHERE `idl` = '" . $ids_original . "' 
			" );

        mysqli_query( $mysqli, "
			DELETE FROM `l-ts` WHERE `s` = '" . preg_replace( "/'/", "\'", $original_kw) . "'
			" );

//        mysqli_query( $mysqli, "
//			DELETE FROM `k-t_s` WHERE `id_s` = '" . $ids_original . "'
//			" );

        mysqli_query( $mysqli, "
			DELETE FROM `k_l` WHERE `idl` = '" . $ids_original . "'
			" );
    }
}

if ( isset( $perevod ) ) {
    for ( $i = 0; $i < count( $perevod ); $i ++ ) {
        mysqli_query( $mysqli, "  
		INSERT IGNORE INTO `k-ts` (`s`)
		VALUES ('" . $perevod[ $i ] . "')
		" );
        mysqli_query( $mysqli, "
		UPDATE `k-ts`
		SET `f` = 1
		WHERE `s` = '" . $perevod[ $i ] . "'
		" );
        mysqli_query( $mysqli, " 
		INSERT IGNORE INTO `tz` (`z`)
		VALUES ('" . $znachenie[ $i ] . "')
		" );
        mysqli_query( $mysqli, "  
		INSERT INTO `k_l` (`idk`, `idl`, `idz`)
		VALUES ((SELECT `ids` FROM `k-ts` WHERE `s` = '" . $perevod[ $i ] . "'),
		        (SELECT `ids` FROM `l-ts` WHERE `s` = '" . preg_replace( "/'/", "\'", $kw_en) . "'),  
				(SELECT `idz` FROM `tz` WHERE `z` = '" . $znachenie[ $i ] . "'))  
		" );
    }

    mysqli_query( $mysqli, "
	UPDATE `l-ts`
	SET `f` = 1
	WHERE `s` = '" . preg_replace( "/'/", "\'", $kw_en) . "' 
	" );

} else if ( ! isset( $perevod ) && ( $original_kw == $kw_en ) ) //просто помечаем слово переведённым, если ничего не меняли с ним (предполагается, что слово имеет уже переводы)
{
    mysqli_query( $mysqli, "
		UPDATE `l-ts`
		SET `f` = 1
		WHERE `s` = '" . preg_replace( "/'/", "\'", $kw_en) . "'
		" );
}
$_SESSION['kw_en'] = $kw_en;

mysqli_close( $mysqli );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/review_translation_hint.php" );