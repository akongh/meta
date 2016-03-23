<?php
session_start();
$podkluchenie = mysql_connect("by114", "andrej", "ss4TU0BH") or die("MySQL сервер недоступен!<br>" . mysql_error());
mysql_query("SET character_set_database=utf8");
mysql_query("SET NAMES utf8");
mysql_select_db("webart_servis_k_s", $podkluchenie) or die("MySQL сервер недоступен!<br>" . mysql_error());
$imya_nabora = time();
$massiv_itog = $_SESSION["SESSION_massiv_itog"];
if ($massiv_itog) {
    //########################################################################
    //%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    mysql_query(" 
INSERT INTO tn (n) 
VALUES ('" . $imya_nabora . "')");
    for ($i = 0;$i < count($massiv_itog);$i++) {
        //делаем повторяющуюся часть запроса
        mysql_query(" 
INSERT IGNORE INTO ts (s) 
VALUES ('" . $massiv_itog[$i] . "')");
        mysql_query(" 
INSERT INTO t_s (id_n, id_s) 
VALUES ((SELECT idn FROM tn WHERE n = '" . $imya_nabora . "'), 
        (SELECT ids FROM ts WHERE s = '" . $massiv_itog[$i] . "')) 
");
    }
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //############################################################################
    
}
mysql_close($podkluchenie);
session_destroy();
?> 

<?php require_once ('index.php'); ?>