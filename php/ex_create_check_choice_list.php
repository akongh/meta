<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
require( $_SERVER["DOCUMENT_ROOT"] . '/php/regexp.php' );

unset(
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_of_kws_amount"],
    $_SESSION["additional_kws"],
    $_SESSION["total_untranslated_ru_kws"]
);

if ( isset( $_POST["abv"] ) ) {
    $abv = $_POST["abv"];
}
if ( isset( $_POST["slova_s_flagom"] ) ) {
    $slova_s_flagom = $_POST["slova_s_flagom"];
}
$arr_of_result = $_SESSION["arr_of_result"];
//обеспробеливаем массив отмеченных слов
if ( isset( $slova_s_flagom ) && $slova_s_flagom != null ) {
    for ( $i = 0; $i < count( $slova_s_flagom ); $i ++ ) {
        $slova_s_flagom_bez_probelov[ $i ] = trim( $slova_s_flagom[ $i ] );
    }
}
//рисуем массив результата с отмеченными словами
for ( $i = 0; $i < count( $arr_of_result ); $i ++ ) {
    if ( isset( $slova_s_flagom_bez_probelov ) ) {
        if ( in_array( $arr_of_result[ $i ], $slova_s_flagom_bez_probelov ) ) {
            $spisok[ $i ] = "<label class='label-highlight'><input type='checkbox' name='slova_s_flagom[]' checked value = '" . $arr_of_result[ $i ] . "'> " . $arr_of_result[ $i ] . "</label>";
        } else {
            $spisok[ $i ] = "<label class='label-highlight'><input type='checkbox' name='slova_s_flagom[]' value = '" . $arr_of_result[ $i ] . "'> " . $arr_of_result[ $i ] . "</label>";
        }
    } else {
        $spisok[ $i ] = "<label class='label-highlight'><input type='checkbox' name='slova_s_flagom[]' value = '" . $arr_of_result[ $i ] . "'> " . $arr_of_result[ $i ] . "</label>";
    }
}
if ( isset( $spisok ) && $spisok != null ) {
    $output_marked_kws_list             = implode( "<br>", $spisok ) . "
    <br>
    <br>
    ";
    $_SESSION["output_marked_kws_list"] = $output_marked_kws_list;
}
//делаем массив из дополнительных слов
$vvod_dop_slov    = $_POST["vvod_dop_slov"];
$vvod_dop_slov    = trim( mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $vvod_dop_slov ) ) ), "utf-8" ) );
$vvod_dop_slov = preg_replace(["/ {2,}/", "/-{2,}/"], [" ", "-"], $vvod_dop_slov);
$_MASSIV_dop_slov = preg_split( "/[\n,;]/", $vvod_dop_slov, - 1, PREG_SPLIT_NO_EMPTY );

for ( $i = 0; $i < count( $_MASSIV_dop_slov ); $i ++ ) {
    $_MASSIV_dop_slov[ $i ] = trim( $_MASSIV_dop_slov[ $i ] );
}

$_MASSIV_dop_slov = array_values( array_unique( ( array_diff( $_MASSIV_dop_slov, array( "" ) ) ) ) );
//удаляем из дополнительных слов те, которые отмечены флажком в подборе
if ( isset( $slova_s_flagom_bez_probelov ) && isset( $_MASSIV_dop_slov ) ) {
    for ( $i = 0; $i < count( $_MASSIV_dop_slov ); $i ++ ) {
        if ( ! in_array( $_MASSIV_dop_slov[ $i ], $slova_s_flagom_bez_probelov ) ) {
            $dopolnenie_unikalnoe[ $i ] = $_MASSIV_dop_slov[ $i ];
        }
    }
} else if ( ! isset( $slova_s_flagom_bez_probelov ) && isset( $_MASSIV_dop_slov ) ) {
    $dopolnenie_unikalnoe = $_MASSIV_dop_slov;
}
//делаем строку с переносами из массива уникального дополненния
if ( isset( $dopolnenie_unikalnoe ) ) {
    $additional_kws             = implode( "\n", $dopolnenie_unikalnoe );
    $_SESSION["additional_kws"] = $additional_kws;
}

//делаем вывод ошибки символа, если она есть
if ( isset( $dopolnenie_unikalnoe ) && count( $dopolnenie_unikalnoe ) > 0 ) {
    $proverka_simvola = implode( "", $dopolnenie_unikalnoe );
    if ( ! preg_match( $regex_check_ru_basis_kws, $proverka_simvola ) ) {
        $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
    }
}
//итоговый массив из подбора, дополнения и состояния
if ( isset( $slova_s_flagom_bez_probelov ) && isset( $dopolnenie_unikalnoe ) ) {
    $resulting_arr = array_values( array_unique( array_merge( $slova_s_flagom_bez_probelov, $dopolnenie_unikalnoe ) ) );
} else if ( isset( $slova_s_flagom_bez_probelov ) && ! isset( $dopolnenie_unikalnoe ) ) {
    $resulting_arr = $slova_s_flagom_bez_probelov;
} else if ( ! isset( $slova_s_flagom_bez_probelov ) && isset( $dopolnenie_unikalnoe ) ) {
    $resulting_arr = $dopolnenie_unikalnoe;
}

if ( isset( $_SESSION["arr_state_of_kws_set"] ) && $resulting_arr != null ) {
    $arr_state_of_kws_set = $_SESSION["arr_state_of_kws_set"];
    $resulting_arr               = array_values( array_unique( array_merge( $arr_state_of_kws_set, $resulting_arr ) ) );
} else if ( isset( $_SESSION["arr_state_of_kws_set"] ) && $resulting_arr == null ) {
    $resulting_arr = $_SESSION["arr_state_of_kws_set"];
}
//ещё одна проверка на смесь кирилицы и латиницы
if ( isset( $resulting_arr ) ) {
    $resulting_arr = array_values( array_unique( ( array_diff( $resulting_arr, array( "" ) ) ) ) );
    if ( count( $resulting_arr ) > 0 ) {
        $proverka_simvola = implode( "", $resulting_arr );
        if ( ! preg_match( $regex_check_ru_basis_kws, $proverka_simvola ) ) {
            $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
        }
    }
}
//остаёмся исправлять ошибки
if ( isset( $err_msg_illegal_char ) ) {
    header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php" );
    exit;
}
//переходим к третьему шагу, если нет ошибок
$total_kws_amount             = count( $resulting_arr );
$_SESSION["total_kws_amount"] = $total_kws_amount;

for ( $i = 0; $i < count( $resulting_arr ); $i ++ ) {
    $assembled_kws_set[ $i ] = "<label class='label-highlight'><input type='checkbox' name='resulting_arr[]' checked value = '" . $resulting_arr[ $i ] . "'> " . $resulting_arr[ $i ] . "</label>";
}
if ( isset( $assembled_kws_set ) ) {
    //сортировать или нет по алфавиту
    if ( isset( $abv ) && $abv == "on" ) {
        sort( $assembled_kws_set, SORT_STRING );
    }
    unset( $abv );
    $assembled_kws_set = implode( "<br>\n", $assembled_kws_set );
}
if ( isset( $assembled_kws_set ) ) {
    $_SESSION["assembled_kws_set"] = $assembled_kws_set;
}
if ( isset( $resulting_arr ) ) {
    $_SESSION["resulting_arr"] = $resulting_arr;
}
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php" );