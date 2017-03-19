<?php error_reporting(0);
include ('/home/webart/www/meta_access/db_connect.php');

$_SQL_zapros_ochered = "SELECT * FROM `k-ts` WHERE `f` = 7 order by `kol` desc";

$_SQL_rezultat_ochered = mysql_query($_SQL_zapros_ochered);
mysql_close($podkluchenie);
?>