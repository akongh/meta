<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

$slovo_original = $_SESSION["slovo_original"];//разбиваемое слово

$novoe_slovo_razbit = $_POST["novoe_slovo_razbit"];
$novoe_slovo_razbit = trim( mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $novoe_slovo_razbit ) ) ), "utf-8" ) );
$novoe_slovo_razbit = preg_replace( "/ {2,}/", " ", $novoe_slovo_razbit );
$novoe_slovo_razbit = preg_replace( "/-{2,}/", "-", $novoe_slovo_razbit );

$_MASSIV_novoe_slovo_razbit = preg_split( "[\n|,|;]", $novoe_slovo_razbit, - 1, PREG_SPLIT_NO_EMPTY );

for ( $i = 0; $i < count( $_MASSIV_novoe_slovo_razbit ); $i ++ ) {
    $_MASSIV_novoe_slovo_razbit[ $i ] = trim( $_MASSIV_novoe_slovo_razbit[ $i ] );
}
$_MASSIV_novoe_slovo_razbit = array_values( array_unique( ( array_diff( $_MASSIV_novoe_slovo_razbit, array( '' ) ) ) ) );
for ( $i = 0; $i < count( $_MASSIV_novoe_slovo_razbit ); $i ++ ) {
    $_MASSIV_novoe_slovo_razbit[ $i ] = preg_replace( "/'/", "\'", $_MASSIV_novoe_slovo_razbit[ $i ] );//массив новых слов вместо разбиваемого для вставки в бд
}
$_SQL_stroka_novoe_slovo_razbit = implode( "','", $_MASSIV_novoe_slovo_razbit );//строка новых слов для запросов

//$nomera_naborov_s_originalom = mysqli_query( $db_connect, "
//	SELECT `k-t_s`.`id_n`
//	from `k-t_s` LEFT JOIN  `k-ts` on `k-t_s`.`id_s` = `k-ts`.`ids`
//	where `k-ts`.`s`  = '" . $slovo_original . "'
//	" );
//$n                           = 0;
//while ( $data = mysqli_fetch_array( $nomera_naborov_s_originalom ) ) {
//    $MASSIV_nomera_naborov_s_originalom[ $n ] = $data['id_n'];//массив номеров наборов с оригиналом
//    $n ++;
//}
//mysqli_query( $db_connect, "
//	delete `k-t_s`
//	FROM `k-t_s` LEFT JOIN `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
//	WHERE `k-ts`.`s` = '" . $slovo_original . "'
//	" );//удаляем оригинальное слово из наборов
mysqli_query( $db_connect, "
	delete FROM `l-ts` WHERE `l-ts`.`s` = '" . $slovo_original . "'
	" );//удаляем оригинальное слово из слов
for ( $i = 0; $i < count( $_MASSIV_novoe_slovo_razbit ); $i ++ ) {
    mysqli_query( $db_connect, "  
	INSERT IGNORE INTO `l-ts` (`s`)
	VALUES ('" . $_MASSIV_novoe_slovo_razbit[ $i ] . "')
	" );//вставляем в бд новые слова
}
mysqli_query( $db_connect, "
	update `l-ts`
	set `f` = 7
	where `s` in ('" . $_SQL_stroka_novoe_slovo_razbit . "')
	" );//помечаем новые слова в заявку на перевод
//$nomera_novyx_slov = mysqli_query( $db_connect, "
//	SELECT `ids`
//	from `l-ts`
//	where `s` in ('" . $_SQL_stroka_novoe_slovo_razbit . "')
//	" );
//$n                 = 0;
//while ( $data = mysqli_fetch_array( $nomera_novyx_slov ) ) {
//    $MASSIV_nomera_novyx_slov[ $n ] = $data['ids'];//массив номеров новых слов
//    $n ++;
//}
//if ( isset( $MASSIV_nomera_naborov_s_originalom ) ) {
//    for ( $i = 0; $i < count( $MASSIV_nomera_naborov_s_originalom ); $i ++ )//добавляем в наборы с оригинальным словом новые слова
//    {
//        for ( $j = 0; $j < count( $MASSIV_nomera_novyx_slov ); $j ++ ) {
//            mysqli_query( $db_connect, "
//		INSERT INTO `k-t_s` (`id_n`, `id_s`)
//		VALUES ('" . $MASSIV_nomera_naborov_s_originalom[ $i ] . "','" . $MASSIV_nomera_novyx_slov[ $j ] . "')
//		" );
//        }
//    }
//};

mysqli_close( $db_connect );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/translation_hint.php" );