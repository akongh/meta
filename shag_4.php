<?php
session_start();

$id_pol = $_SESSION['id_pol'];

require_once('bd.php');

$imya_nabora = time();
$massiv_itog = $_SESSION["SESSION_massiv_itog"];
if ($massiv_itog) {
    //########################################################################
    //%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    mysql_query(" 
INSERT INTO `$id_pol--tn` (`n`) 
VALUES ('" . $imya_nabora . "')");
    for ($i = 0; $i < count($massiv_itog); $i++) {
        //делаем повторяющуюся часть запроса
        mysql_query(" 
INSERT IGNORE INTO `ts` (`s`) 
VALUES ('" . $massiv_itog[$i] . "')");
        mysql_query(" 
INSERT INTO `$id_pol--t_s` (`id_n`, `id_s`) 
VALUES ((SELECT `idn` FROM `$id_pol--tn` WHERE `n` = '" . $imya_nabora . "'), 
        (SELECT `ids` FROM `ts` WHERE `s` = '" . $massiv_itog[$i] . "')) 
");
    }
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //############################################################################
}
mysql_close($podkluchenie);
unset($_SESSION["SESSION_massiv_itog"]);

require_once('shag_1.php');
?>