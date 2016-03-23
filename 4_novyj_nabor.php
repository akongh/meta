<?php
session_start();
require_once('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

require_once ('bd.php');
$imya_nabora = time();
$massiv_itog = $_SESSION["SESSION_massiv_itog"];

if ($massiv_itog) {
    //%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    mysql_query("  
INSERT INTO `".$id_pol."--tn` (`n`)  
VALUES ('".$imya_nabora."')");
    for ($i = 0;$i < count($massiv_itog);$i++) {
        //делаем повторяющуюся часть запроса
        $slovo = mysql_fetch_array(mysql_query(" 
SELECT `s` FROM `ts` WHERE `s` = '".$massiv_itog[$i]."' 
"));
        if ($slovo == FALSE) {
            mysql_query("  
INSERT INTO `ts` (`s`)  
VALUES ('".$massiv_itog[$i]."')");
        }
        mysql_query("  
INSERT INTO `".$id_pol."--t_s` (`id_n`, `id_s`)  
VALUES ((SELECT `idn` FROM `".$id_pol."--tn` WHERE `n` = '".$imya_nabora."'),  
        (SELECT `ids` FROM `ts` WHERE `s` = '".$massiv_itog[$i]."'))  
");
    }
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
}
mysql_close($podkluchenie);
unset($_SESSION["SESSION_massiv_itog"]);
header("Location: /1_vvod_slov.php");
?>