<?php //error_reporting(0);
session_start();

include ('/home/webart/www/_upravlyalka.200slov.andrej.by/bd.php');
$zayavka_na_perevod = "
update `k-ts`
set `k-ts`.`f` = 0
where `k-ts`.`f` = 7
";
mysql_query($zayavka_na_perevod);
mysql_close($podkluchenie);

header("Location: http://upravlyalka.200slov.andrej.by/ne_xvataet_perevoda.php");

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>