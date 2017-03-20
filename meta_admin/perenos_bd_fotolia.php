<?php error_reporting(E_ALL ^E_NOTICE);
for($i = 6175; $i <= 6175; $i++)
{
	sleep(1);
	
	$vr_nabora = time();
	$ses = "lori";
	
	include ($_SERVER['DOCUMENT_ROOT'].'/meta_access/db_connect.php');

	$slova = mysqli_query( $db_connect, "
	select `s`
	from `l-ts`
	join `l-t_s` on `l-ts`.`ids` = `l-t_s`.`id_s` and `l-t_s`.`id_n` = '" . $i . "'
	");
	
	mysqli_close($db_connect);
	
	$n = 0;
	while ($data = mysqli_fetch_array($slova))
	{
		$slova2[$n] = $data['s'];
		$n++;
		}
		
	if($slova2 != NULL)
	{
		$db_connect2 = mysqli_connect("by114", "andrej", "ss4TU0BH");
		mysqli_query( $db_connect, "SET character_set_database=utf8");
		mysqli_query( $db_connect, "SET NAMES utf8");
		mysqli_select_db("webart_200slov", $db_connect2);
		
		$stroka_slov = implode("", $slova2);
		
		if(!preg_match("/[а-яё]+/i", $stroka_slov))
		{
			mysqli_query( $db_connect, "  
			INSERT INTO `l-tn` (`vr`, `ses`)  
			VALUES ('".$vr_nabora."', '".$ses."')
			");
			
			for ($j = 0; $j < count($slova2); $j++)
			{
				mysqli_query( $db_connect, "  
				INSERT IGNORE INTO `l-ts` (`s`)
				VALUES ('".$slova2[$j]."')
				");
				mysqli_query( $db_connect, "  
				INSERT INTO `l-t_s` (`id_n`, `id_s`)  
				VALUES ((SELECT `idn` FROM `l-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
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
				mysqli_query( $db_connect, "  
				INSERT INTO `k-tn` (`vr`, `ses`)  
				VALUES ('".$vr_nabora."', '".$ses."')
				");
				
				for ($h = 0; $h < count($slova2); $h++)
				{
					mysqli_query( $db_connect, "  
					INSERT IGNORE INTO `k-ts` (`s`)
					VALUES ('".$slova2[$h]."')
					");
					mysqli_query( $db_connect, "  
					INSERT INTO `k-t_s` (`id_n`, `id_s`)  
					VALUES ((SELECT `idn` FROM `k-tn` WHERE `vr` = '".$vr_nabora."' AND `ses` = '".$ses."'),  
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
				
		mysqli_close($db_connect2);
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