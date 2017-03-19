<?php error_reporting(0);
include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');

$_SQL_zapros_ochered = "SELECT * FROM `k-ts` WHERE `f` = 7 order by `kol` desc";

$_SQL_rezultat_ochered = mysqli_query( $db_connect, $_SQL_zapros_ochered);
mysqli_close($db_connect);
?>