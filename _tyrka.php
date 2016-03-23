<?php
//уже стырили с 1000000 до 1001507
$ot = $_POST["ot"];
$do = $_POST["do"];
for($ot; $ot <= $do; $ot++)
{
	sleep(1);
	include ('bd.php');
	$kod_straniczy = file_get_contents('http://lori.ru/'.$ot);
	if($kod_straniczy == false)
	{
		mysql_close($podkluchenie);
		print_r($ot);
		echo ("<hr>");
		flush();
		}
		else if ($kod_straniczy == true)
		{
			preg_match_all("/<a href=\"\/search\/images\/.*<\/a>/", $kod_straniczy, $stroka);
			$stroka = $stroka[0];
			for($i=0; $i<count($stroka); $i++)
			{
				$stroka[$i] = preg_replace("/<\/a>/", "", $stroka[$i]);
				$stroka[$i] = trim(preg_replace("/<.*>/", "", $stroka[$i]));
				if(!preg_match("/[a-z0-9]+/i", $stroka[$i]))
				{
					$stroka_kir[$i] = $stroka[$i];
					}
				}
			if(count($stroka_kir) > 0)
			{
				$stroka = array_values(array_unique($stroka_kir));
				}
			if(count($stroka) > 0)
			{
				$vr_nabora = time();
				$ses = 1;
				mysql_query("  
				INSERT INTO `tn` (`vr`, `ses`)  
				VALUES ('".$vr_nabora."', '".$ses."')
				");
				for ($i = 0;$i < count($stroka);$i++)
				{
					mysql_query("  
					INSERT IGNORE INTO `ts` (`s`)
					VALUES ('".$stroka[$i]."')
					");
					mysql_query("  
					INSERT INTO `t_s` (`id_n`, `id_s`)  
					VALUES ((SELECT `idn` FROM `tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
							(SELECT `ids` FROM `ts` WHERE `s` = '".$stroka[$i]."'))  
					");
					}
				}
			$stroka = implode("; ", $stroka);
			print_r($stroka);
			echo ("<br>");
			print_r($ot);
			echo ("<hr>");
			flush();
			unset(
			$kod_straniczy,
			$stroka,
			$stroka_kir);
			mysql_close($podkluchenie);
			}
	}
?>