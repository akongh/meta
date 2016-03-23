<?php
include('bd.php');

////////////////////пользовательские слова и наборы/////////////////////////////////////////
$kol_slov_zapros_pol = mysql_query("SELECT COUNT(DISTINCT `id_s`) FROM `" . $id_pol . "--t_s`");
$kol_slov_otvet_pol = mysql_fetch_row($kol_slov_zapros_pol);//var_dump($kol_slov_pol);
$kol_slov_pol = $kol_slov_otvet_pol[0];

$kol_naborov_zapros_pol = mysql_query("SELECT COUNT(DISTINCT `id_n`) FROM `" . $id_pol . "--t_s`");
$kol_naborov_otvet_pol = mysql_fetch_row($kol_naborov_zapros_pol);//var_dump($kol_naborov_pol);
$kol_naborov_pol = $kol_naborov_otvet_pol[0];

mysql_close($podkluchenie);
?>