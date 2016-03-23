<?php
for($i = 538754; $i <= 538754; $i++)
{
	//sleep(1);
	
	$vr_nabora = time();
	$ses = "lori—".$i;//print_r($ses);
	
	include ('/home/webart/www/_upravlyalka.200slov.andrej.by/bd_p.php');

	$slova = mysql_query("
	select `s`
	from `k-ts`
	join `k-t_s` on `k-ts`.`ids` = `k-t_s`.`id_s` and `k-t_s`.`id_n` = '" . $i . "'
	");
	
	mysql_close($podkluchenie);
	
	$n = 0;
	while ($data = mysql_fetch_array($slova))
	{
		$slova2[$n] = $data['s'];
		$n++;
		}//var_dump($slova2);
		
	if($slova2 != NULL)
	{
		$podkluchenie2 = mysql_connect("by114", "andrej", "ss4TU0BH");
		mysql_query("SET character_set_database=utf8");
		mysql_query("SET NAMES utf8");
		mysql_select_db("webart_200slov", $podkluchenie2);
		
		$stroka_slov = implode("", $slova2);
		
		if(!preg_match("/[а-яё]+/i", $stroka_slov))
		{
			mysql_query("  
			INSERT INTO `l-tn` (`vr`, `ses`)  
			VALUES ('".$vr_nabora."', '".$ses."')
			");
			
			for ($j = 0; $j < count($slova2); $j++)
			{
				mysql_query("  
				INSERT IGNORE INTO `l-ts` (`s`)
				VALUES ('".$slova2[$j]."')
				");
				mysql_query("  
				INSERT INTO `l-t_s` (`id_n`, `id_s`)  
				VALUES ((SELECT `idn` FROM `l-tn` WHERE /*`vr` = '".$vr_nabora."' AND*/ `ses` = '".$ses."'),  
						(SELECT `ids` FROM `l-ts` WHERE `s` = '".$slova2[$j]."'))  
				");
				}
				
			$stroka_slov_vyvod = implode("; ", $slova2);
			
			echo $i . " — ENGLISH";
			echo "<br>";
			echo $stroka_slov_vyvod;
			echo "<hr>";
			flush();
			}
			else if(!preg_match("/[a-z]+/i", $stroka_slov))
			{
				mysql_query("  
				INSERT INTO `k-tn` (`vr`, `ses`)  
				VALUES ('".$vr_nabora."', '".$ses."')
				");
				
				for ($h = 0; $h < count($slova2); $h++)
				{
					mysql_query("  
					INSERT IGNORE INTO `k-ts` (`s`)
					VALUES ('".$slova2[$h]."')
					");
					mysql_query("  
					INSERT INTO `k-t_s` (`id_n`, `id_s`)  
					VALUES ((SELECT `idn` FROM `k-tn` WHERE /*`vr` = '".$vr_nabora."' AND*/ `ses` = '".$ses."'),  
							(SELECT `ids` FROM `k-ts` WHERE `s` = '".$slova2[$h]."'))  
					");
					}
					
				$stroka_slov_vyvod = implode("; ", $slova2);	
					
				echo $i . " — РУССКИЙ";
				echo "<br>";
				echo $stroka_slov_vyvod;
				echo "<hr>";
				flush();
				}
				
		mysql_close($podkluchenie2);	
		}
		else
		{
			echo "!!!";
			echo "<br>";
			echo "!!! Набор №" . $i . " не существует.";
			echo "<br>";
			echo "!!!";
			echo "<hr>";
			flush();
			}
	
	unset(
	$vr_nabora,
	$slova,
	$data,
	$slova2,
	$stroka_slov,
	$stroka_slov_vyvod
	);
	}
?>