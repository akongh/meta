<?php
session_start();

include ('/home/webart/www/_upravlyalka.200slov.andrej.by/bd.php');

mysql_query("
	UPDATE `k-ts` SET `k-ts`.`kol` = (SELECT COUNT(*) FROM `k-t_s` WHERE `k-t_s`.`id_s` = `k-ts`.`ids`)
	");
	
//mysqli_query($link, "UPDATE `k-ts` SET `k-ts`.`kol` = (SELECT COUNT(*) FROM `k-t_s` WHERE `k-t_s`.`id_s` = `k-ts`.`ids`)");
//printf("Обновлено строк: %d\n", mysqli_affected_rows($link));

mysql_close($podkluchenie);

header("Location: http://upravlyalka.200slov.andrej.by/upravlyalka.php");

?>