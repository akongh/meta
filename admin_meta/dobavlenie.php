<?php
session_start();

include ('/home/webart/www/access_meta/db_connect.php');

$perevedeno_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysql_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

$propustit_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'");
$propustit_otvet = mysql_fetch_row($propustit_zapros);
$propustit = $propustit_otvet[0];

$slovo_kolichestvo = mysql_query("
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` = 5
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	");
	
$n = 0;
while ($data = mysql_fetch_array($slovo_kolichestvo))
{
	$slovo[$n] = $data['slovo'];
	$kol[$n] = $data['kol'];
	$n++;
	}
	
mysql_close($podkluchenie);

$slovo = $slovo[0];//var_dump($slovo);
$kol = $kol[0];//var_dump($kol);
$_SESSION["slovo_original"] = $slovo;



include ('dobavlenie.html');
?>