<?php //error_reporting(0);
include ('bd.php');

$kir_kol_slov_zapros = mysql_query("SELECT COUNT(*) FROM `ts` WHERE `s` REGEXP '[а-пр-яё]'");
$kir_kol_slov_otvet = mysql_fetch_row($kir_kol_slov_zapros);
$_SESSION["kir_kol_slov"] = $kir_kol_slov_otvet[0];

$kir_kol_naborov_zapros = mysql_query("
SELECT COUNT(distinct `t_s`.`id_n`)
FROM `t_s`
join `ts` on `t_s`.`id_s` = `ts`.`ids`
where `ts`.`s` regexp '[а-пр-яё]'
");
$kir_kol_naborov_otvet = mysql_fetch_row($kir_kol_naborov_zapros);
$_SESSION["kir_kol_naborov"] = $kir_kol_naborov_otvet[0];

$lat_kol_slov_zapros = mysql_query("SELECT COUNT(*) FROM `ts` WHERE `s` REGEXP '[a-z]'");
$lat_kol_slov_otvet = mysql_fetch_row($lat_kol_slov_zapros);
$_SESSION["lat_kol_slov"] = $lat_kol_slov_otvet[0];

$lat_kol_naborov_zapros = mysql_query("
SELECT COUNT(distinct `t_s`.`id_n`)
FROM `t_s`
join `ts` on `t_s`.`id_s` = `ts`.`ids`
where `ts`.`s` regexp '[a-z]'
");
$lat_kol_naborov_otvet = mysql_fetch_row($lat_kol_naborov_zapros);
$_SESSION["lat_kol_naborov"] = $lat_kol_naborov_otvet[0];

mysql_close($podkluchenie);
?>