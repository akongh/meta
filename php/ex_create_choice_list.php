<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');
require( $_SERVER["DOCUMENT_ROOT"] . '/php/regexp.php' );

unset(
    $_SESSION["err_msg_empty_input"],
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_illegal_basis_kws_amount"],
    $_SESSION["total_untranslated_ru_kws"]
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
$basis_kws             = implode( "\n", $_MASSIV_op_slov );
$_SESSION["basis_kws"] = $basis_kws;
if ( ! isset( $_SESSION["arr_state_of_kws_set"] ) && $basis_kws == null ) {
    $err_msg_empty_input             = "<span class='error'>Необходимы опорные ключевые слова.</span><br>";
    $_SESSION["err_msg_empty_input"] = $err_msg_empty_input;
}
if ( count( $_MASSIV_op_slov ) > 8 ) {
    $err_msg_illegal_basis_kws_amount             = "<span class='error'>Не более 8-ми опорных ключевых слов.</span><br>";
    $_SESSION["err_msg_illegal_basis_kws_amount"] = $err_msg_illegal_basis_kws_amount;
}
if ( count( $_MASSIV_op_slov ) > 0 ) {
    $proverka_simvola = implode( "", $_MASSIV_op_slov );
    if ( ! preg_match( $regulyar_slova, $proverka_simvola ) ) {
        $err_msg_illegal_char             = "<span class='error'>Только кириллица, цифры, пробел и&nbsp;дефис.</span><br>";
        $_SESSION["err_msg_illegal_char"] = $err_msg_illegal_char;
    }
}
if ( isset( $_SESSION["arr_state_of_kws_set"] ) && count( $_MASSIV_op_slov ) > 0 ) {
    $arr_state_of_kws_set = $_SESSION["arr_state_of_kws_set"];
    $proverka_simvola          = array_values( array_unique( array_merge( $_MASSIV_op_slov, $arr_state_of_kws_set ) ) );
    $proverka_simvola          = implode( "", $proverka_simvola );
    if ( ! preg_match( $regulyar_slova, $proverka_simvola ) ) {
        $err_msg_illegal_char             = "<span class='error'>Только кириллица, цифры, пробел и&nbsp;дефис.</span><br>";
        $_SESSION["err_msg_illegal_char"] = $err_msg_illegal_char;
    }
}
if ( isset( $err_msg_illegal_char ) or isset( $err_msg_illegal_basis_kws_amount ) or isset( $err_msg_empty_input ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_1.php" );
    exit;
}

$_SQL_stroka_dlya_podbora = implode( "','", $_MASSIV_op_slov );
$kolichestvo_opornyx_slov = count( $_MASSIV_op_slov );

if ( isset( $sposob321 ) && $kolichestvo_opornyx_slov > 1 ) {
    for ( $i = $kolichestvo_opornyx_slov; $i > 0; $i -- ) {
        if (!($mysqli_stmt = $mysqli->prepare(sql_zapr_podb($_SQL_stroka_dlya_podbora)))) {
            echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
        }
        if (!$mysqli_stmt->bind_param("ii", $i, $granicza)) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        $mysqli_stmt->bind_result($data, $count);

        $n = 0;
        while ($mysqli_stmt->fetch()) {
            $arr_of_result[$n] = $data;
            $n++;
        }
        $mysqli_stmt->close();
        if ( isset( $arr_of_result ) && $arr_of_result != null ) {
            $arr_of_result = array_values( array_unique( array_merge( $_MASSIV_op_slov, $arr_of_result ) ) );

            if ( $i == 1 ) {
                break;
            }
            if ( count( $arr_of_result ) == $granicza ) {
                break;
            }
            if ( count( $arr_of_result ) > $granicza ) {
                $arr_of_result = array_slice( $arr_of_result, 0, $granicza );
                break;
            }
        } else if ( $i == 1 ) {
            $arr_of_result = $_MASSIV_op_slov;
        }
//        if ( isset( $arr_of_result ) && $arr_of_result != null ) {
//            $arr_of_result = array_values( array_unique( array_merge( $_MASSIV_op_slov, $arr_of_result ) ) );
//            if ( count( $arr_of_result ) > $kolichestvo_opornyx_slov ) {
//                if ( count( $arr_of_result ) > $granicza ) {
//                    $arr_of_result = array_slice( $arr_of_result, 0, $granicza );
//                }
//                break;
//            }
//        } else {
//            $arr_of_result = $_MASSIV_op_slov;
//        }
    }
} else {
    if (!($mysqli_stmt = $mysqli->prepare(sql_zapr_podb($_SQL_stroka_dlya_podbora)))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("ii", $i, $granicza)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    $mysqli_stmt->bind_result($data, $count);

    $n = 0;
    while ($mysqli_stmt->fetch()) {
        $arr_of_result[$n] = $data;
        $n++;
    }
    $mysqli_stmt->close();
    if ( isset( $arr_of_result ) && $arr_of_result != null ) {
        $arr_of_result = array_values( array_unique( array_merge( $_MASSIV_op_slov, $arr_of_result ) ) );
    } else {
        $arr_of_result = $_MASSIV_op_slov;
    }
}

$_SESSION["arr_of_result"] = $arr_of_result;

for ( $i = 0; $i < count( $arr_of_result ); $i ++ ) {
    if ( $i < $kolichestvo_opornyx_slov ) {
        $_MASSIV_spisok_podbora[ $i ] = "
        <label class='label-highlight'>
        <input type='checkbox' name='slova_s_flagom[]' checked value = '" . $arr_of_result[ $i ] . "'>
        " . $arr_of_result[ $i ] . "
        </label>";
    } else {
        $_MASSIV_spisok_podbora[ $i ] = "
        <label class='label-highlight'>
        <input type='checkbox' name='slova_s_flagom[]' value = '" . $arr_of_result[ $i ] . "'>
        " . $arr_of_result[ $i ] . "
        </label>";
    }
}
if ( isset( $_MASSIV_spisok_podbora ) ) {
    $output_marked_kws_list             = implode( "<br>", $_MASSIV_spisok_podbora ) . "
        <br>
        <br>
        ";
    $_SESSION["output_marked_kws_list"] = $output_marked_kws_list;
}

$mysqli->close();
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php" );