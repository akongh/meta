<?php

$ot = $_POST["ot"];
$do = $_POST["do"];
for($ot; $ot <= $do; $ot++)
{
	sleep(2);
	include ('/home/webart/www/_z/bd.php');
	$kod_straniczy = file_get_contents('http://fotolia.com/id/'.$ot);
	if($kod_straniczy == false)
	{
		print_r($ot);
		echo ("<hr>");
		flush();
		//mysql_query("
//		UPDATE `tyrki`
//		SET `fotolia` = '".$ot."'
//		WHERE `f` = '1'
//		");
		mysql_close($podkluchenie);
		}
		else if ($kod_straniczy == true)
		{
			preg_match_all("/<a class=\"tags.*<\/a>/", $kod_straniczy, $stroka);//var_dump($stroka);
			$stroka = $stroka[0];//print_r($stroka);
			if (!empty($stroka))
			{
				$stroka = implode("", $stroka);
				$stroka = preg_replace("/> </", ">;<", $stroka);
				$stroka = strip_tags($stroka);
				$stroka = explode(";", $stroka);
				for($i=0; $i<count($stroka); $i++)
				{
					$stroka[$i] = trim($stroka[$i]);
					if(!preg_match("/[а-яё]+/i", $stroka[$i]))
					{
						$stroka_lat[$i] = $stroka[$i];
						}
					}
				if(count($stroka_lat) > 0)
				{
					$stroka = array_values(array_unique($stroka_lat));
					}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				if(count($stroka) > 0)
				{
					$vr_nabora = time();
					$ses = 'fotolia';
					mysql_query("  
					INSERT INTO `l-tn` (`vr`, `ses`)  
					VALUES ('".$vr_nabora."', '".$ses."')
					");
					for ($i = 0;$i < count($stroka);$i++)
					{
						mysql_query("  
						INSERT IGNORE INTO `l-ts` (`s`)
						VALUES ('".$stroka[$i]."')
						");
						mysql_query("  
						INSERT INTO `l-t_s` (`id_n`, `id_s`)  
						VALUES ((SELECT `idn` FROM `l-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
								(SELECT `ids` FROM `l-ts` WHERE `s` = '".$stroka[$i]."'))  
						");
						}
					mysql_query("
					UPDATE `tyrki`
					SET `fotolia` = '".$ot."'
					/*WHERE `f` = '1'*/
					");
					}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$stroka = implode("; ", $stroka);
				print_r($stroka);
				echo ("<br>");
				print_r($ot);
				echo ("<hr>");
				flush();
				unset(
				$kod_straniczy,
				$stroka,
				$stroka_lat);
				mysql_close($podkluchenie);
				}
				else
				{
					print_r($ot);
					echo ("<hr>");
					flush();
					unset(
					$kod_straniczy,
					$stroka,
					$stroka_lat);
					mysql_close($podkluchenie);
					}
			}
			
	}
?>