<?php error_reporting( - 1 );
session_start();
session_unset();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

unset( $_POST );

include( 'sql/SQL_translation_queue.php' );
$_SQL_rezultat_ochered = mysqli_query( $db_connect, $_SQL_zapros_ochered );

$n = 0;
while ( $data = mysqli_fetch_array( $_SQL_rezultat_ochered ) ) {
    $_MASSIV_ochered[ $n ] = $data['s'];
    $n ++;
}

if ( isset($_MASSIV_ochered) && $_MASSIV_ochered != null ) {
    $_MASSIV_spisok_ochered       = implode( "<br>", $_MASSIV_ochered );
    $_SESSION["kol_slov_ochered"] = "
    <span class=\"counter\">" . count( $_MASSIV_ochered ) . "</span>
    ";
} else {
    $_MASSIV_spisok_ochered = "Заявок на перевод пока нет.";
}

mysqli_close( $db_connect );
include( 'html/translation_request.html' );