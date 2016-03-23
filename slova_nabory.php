<?php
include('bd.php');

////////////////////общие слова и наборы////////////////////////////////////////////////////
$kol_slov_zapros = mysql_query("SELECT COUNT(*) FROM `ts`");
$kol_slov_otvet = mysql_fetch_row($kol_slov_zapros);//var_dump($kol_slov);
$kol_slov = $kol_slov_otvet[0];

$kol_naborov_zapros = mysql_query("SELECT COUNT(*) FROM `tn`");
$kol_naborov_otvet = mysql_fetch_row($kol_naborov_zapros);//var_dump($kol_naborov);
$kol_naborov = $kol_naborov_otvet[0];

mysql_close($podkluchenie);
?>