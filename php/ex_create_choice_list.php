<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include($_SERVER['DOCUMENT_ROOT'] . '/php/sql_prepared_statements.php');
include( $_SERVER['DOCUMENT_ROOT'] . '/php/regexp.php' );

unset(
    $_SESSION["oshibka_nichego_ne_vveli"],
    $_SESSION["oshibka_simvola"],
    $_SESSION["oshibka_mnogo_op_slov"],
    $_SESSION["_REZULTAT_russk_neperevedennye"]
);

if ( isset( $_POST["sposob321"] ) ) {
    $sposob321 = $_POST["sposob321"];
}
$granicza        = $_POST["granicza"];
$vvod_op_slov    = $_POST["vvod_op_slov"];
$vvod_op_slov    = trim( mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $vvod_op_slov ) ) ), "utf-8" ) );
$vvod_op_slov = preg_replace(["/ {2,}/", "/-{2,}/"], [" ", "-"], $vvod_op_slov);
$_MASSIV_op_slov = preg_split( "/[\n,;]/", $vvod_op_slov, - 1, PREG_SPLIT_NO_EMPTY );

for ( $i = 0; $i < count( $_MASSIV_op_slov ); $i ++ ) {
    $_MASSIV_op_slov[ $i ] = trim( $_MASSIV_op_slov[ $i ] );
}
$_MASSIV_op_slov           = array_values( array_unique( ( array_diff( $_MASSIV_op_slov, array( "" ) ) ) ) );
$opornye_slova             = implode( "\n", $_MASSIV_op_slov );
$_SESSION["opornye_slova"] = $opornye_slova;
if ( ! isset( $_SESSION["_MASSIV_sostoyanie_nabora"] ) && $opornye_slova == null ) {
    $oshibka_nichego_ne_vveli             = "<span class='error'>Необходимы опорные ключевые слова.</span><br>";
    $_SESSION["oshibka_nichego_ne_vveli"] = $oshibka_nichego_ne_vveli;
}
if ( count( $_MASSIV_op_slov ) > 8 ) {
    $oshibka_mnogo_op_slov             = "<span class='error'>Не более 8-ми опорных ключевых слов.</span><br>";
    $_SESSION["oshibka_mnogo_op_slov"] = $oshibka_mnogo_op_slov;
}
if ( count( $_MASSIV_op_slov ) > 0 ) {
    $proverka_simvola = implode( "", $_MASSIV_op_slov );
    if ( ! preg_match( $regulyar_slova, $proverka_simvola ) ) {
        $oshibka_simvola             = "<span class='error'>Только кириллица, цифры, пробел и&nbsp;дефис.</span><br>";
        $_SESSION["oshibka_simvola"] = $oshibka_simvola;
    }
}
if ( isset( $_SESSION["_MASSIV_sostoyanie_nabora"] ) && count( $_MASSIV_op_slov ) > 0 ) {
    $_MASSIV_sostoyanie_nabora = $_SESSION["_MASSIV_sostoyanie_nabora"];
    $proverka_simvola          = array_values( array_unique( array_merge( $_MASSIV_op_slov, $_MASSIV_sostoyanie_nabora ) ) );
    $proverka_simvola          = implode( "", $proverka_simvola );
    if ( ! preg_match( $regulyar_slova, $proverka_simvola ) ) {
        $oshibka_simvola             = "<span class='error'>Только кириллица, цифры, пробел и&nbsp;дефис.</span><br>";
        $_SESSION["oshibka_simvola"] = $oshibka_simvola;
    }
}
if ( isset( $oshibka_simvola ) or isset( $oshibka_mnogo_op_slov ) or isset( $oshibka_nichego_ne_vveli ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_1.php" );
    exit;
}

$_SQL_stroka_dlya_podbora = implode( "','", $_MASSIV_op_slov );
$kolichestvo_opornyx_slov = count( $_MASSIV_op_slov );

if ( isset( $sposob321 ) && $kolichestvo_opornyx_slov > 1 ) {
    for ( $i = $kolichestvo_opornyx_slov; $i > 0; $i -- ) {
        if (!($stmt = $mysqli->prepare(sql_zapr_podb($_SQL_stroka_dlya_podbora)))) {
            echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ii", $i, $granicza)) {
            echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->bind_result($data, $count);

        $n = 0;
        while ($stmt->fetch()) {
            $_MASSIV_rezultata[$n] = $data;
            $n++;
        }
        $stmt->close();
        if ( isset( $_MASSIV_rezultata ) && $_MASSIV_rezultata != null ) {
            $_MASSIV_rezultata = array_values( array_unique( array_merge( $_MASSIV_op_slov, $_MASSIV_rezultata ) ) );

            if ( $i == 1 ) {
                break;
            }
            if ( count( $_MASSIV_rezultata ) == $granicza ) {
                break;
            }
            if ( count( $_MASSIV_rezultata ) > $granicza ) {
                $_MASSIV_rezultata = array_slice( $_MASSIV_rezultata, 0, $granicza );
                break;
            }
        } else if ( $i == 1 ) {
            $_MASSIV_rezultata = $_MASSIV_op_slov;
        }
//        if ( isset( $_MASSIV_rezultata ) && $_MASSIV_rezultata != null ) {
//            $_MASSIV_rezultata = array_values( array_unique( array_merge( $_MASSIV_op_slov, $_MASSIV_rezultata ) ) );
//            if ( count( $_MASSIV_rezultata ) > $kolichestvo_opornyx_slov ) {
//                if ( count( $_MASSIV_rezultata ) > $granicza ) {
//                    $_MASSIV_rezultata = array_slice( $_MASSIV_rezultata, 0, $granicza );
//                }
//                break;
//            }
//        } else {
//            $_MASSIV_rezultata = $_MASSIV_op_slov;
//        }
    }
} else {
    if (!($stmt = $mysqli->prepare(sql_zapr_podb($_SQL_stroka_dlya_podbora)))) {
        echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ii", $i, $granicza)) {
        echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->bind_result($data, $count);

    $n = 0;
    while ($stmt->fetch()) {
        $_MASSIV_rezultata[$n] = $data;
        $n++;
    }
    $stmt->close();
    if ( isset( $_MASSIV_rezultata ) && $_MASSIV_rezultata != null ) {
        $_MASSIV_rezultata = array_values( array_unique( array_merge( $_MASSIV_op_slov, $_MASSIV_rezultata ) ) );
    } else {
        $_MASSIV_rezultata = $_MASSIV_op_slov;
    }
}

$_SESSION["_MASSIV_rezultata"] = $_MASSIV_rezultata;

for ( $i = 0; $i < count( $_MASSIV_rezultata ); $i ++ ) {
    if ( $i < $kolichestvo_opornyx_slov ) {
        $_MASSIV_spisok_podbora[ $i ] = "
        <label class='label-highlight'>
        <input type='checkbox' name='slova_s_flagom[]' checked value = '" . $_MASSIV_rezultata[ $i ] . "'>
        " . $_MASSIV_rezultata[ $i ] . "
        </label>";
    } else {
        $_MASSIV_spisok_podbora[ $i ] = "
        <label class='label-highlight'>
        <input type='checkbox' name='slova_s_flagom[]' value = '" . $_MASSIV_rezultata[ $i ] . "'>
        " . $_MASSIV_rezultata[ $i ] . "
        </label>";
    }
}
if ( isset( $_MASSIV_spisok_podbora ) ) {
    $vyvod_spiska_flagov             = implode( "<br>", $_MASSIV_spisok_podbora ) . "
        <br>
        <br>
        ";
    $_SESSION["vyvod_spiska_flagov"] = $vyvod_spiska_flagov;
}

$mysqli->close();
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php" );