<?php
session_start();

$slovo_original = $_SESSION["slovo_original"];
$slovo_k = $_POST["slovo"];
$perevod = $_POST["perevod"];
$znachenie = $_POST["znachenie"];

if(isset($perevod))
{
	for ($i = 0; $i < count($perevod); $i++)
	{
		$perevod[$i] = trim($perevod[$i]);
		$perevod[$i] = preg_replace("/ {2,}/", " ", $perevod[$i]);
		$perevod[$i] = preg_replace("/'/", "\'", $perevod[$i]);
		}
	}

if(isset($znachenie))
{
	for ($i = 0; $i < count($znachenie); $i++)
	{
		$znachenie[$i] = trim($znachenie[$i]);
		$znachenie[$i] = preg_replace("/ {2,}/", " ", $znachenie[$i]);
		$znachenie[$i] = preg_replace("/'/", "\'", $znachenie[$i]);
		}
	}

include ('/home/webart/www/_z/bd.php');

if($slovo_original != $slovo_k)
{
	$proverka_nalichiya_slova = mysql_query("  
	SELECT `s` FROM `k-ts` WHERE `s` = '".$slovo_k."'
	");
	
	$n = 0;
	while ($data = mysql_fetch_array($proverka_nalichiya_slova))
	{
		$proverka_nalichiya[$n] = $data['s'];
		$n++;
		}
		
	if(!isset($proverka_nalichiya))
	{
		mysql_query("
		UPDATE `k-ts`
		SET `s` = '".$slovo_k."'
		WHERE `s` = '".$slovo_original."' 
		");
		}
		else if(isset($proverka_nalichiya))
		{
			/////////////////////////////////////////////////////////////////////
			
			$ids_original = mysql_query("
			SELECT `ids` FROM `k-ts` WHERE `s` = '".$slovo_original."'
			");
			
			$n = 0;
			while ($data = mysql_fetch_array($ids_original))
			{
				$ids_orig[$n] = $data['ids'];
				$n++;
				}
			
			$ids_original = $ids_orig[0];
			
			//////////////////////////////////////////////////////////////////////
			
			$ids_ispravlennogo = mysql_query("
			SELECT `ids` FROM `k-ts` WHERE `s` = '".$slovo_k."'
			");
			
			$n = 0;
			while ($data = mysql_fetch_array($ids_ispravlennogo))
			{
				$ids_ispr[$n] = $data['ids'];
				$n++;
				}
			
			$ids_ispravlennogo = $ids_ispr[0];
			
			//////////////////////////////////////////////////////////////////////
			
			mysql_query("
			UPDATE LOW_PRIORITY IGNORE `k-t_s`
			SET `id_s` = '".$ids_ispravlennogo."'
			WHERE `id_s` = '".$ids_original."' 
			");
			
			mysql_query("
			UPDATE LOW_PRIORITY IGNORE `k_l`
			SET `idk` = '".$ids_ispravlennogo."'
			WHERE `idk` = '".$ids_original."' 
			");
			
			mysql_query("
			DELETE FROM `k-ts` WHERE `s` = '".$slovo_original."'
			");
			
			mysql_query("
			DELETE FROM `k-t_s` WHERE `id_s` = '".$ids_original."'
			");
			
			mysql_query("
			DELETE FROM `k_l` WHERE `idk` = '".$ids_original."'
			");
			}
	}

if(isset($perevod))
{
	$b = 0;
	for($i = 0; $i < count($perevod); $i++)
	{
		mysql_query("  
		INSERT IGNORE INTO `l-ts` (`s`)
		VALUES ('".$perevod[$i]."')
		");
		mysql_query(" 
		INSERT IGNORE INTO `tz` (`z`)
		VALUES ('".$znachenie[$i]."')
		");
		mysql_query("  
		INSERT INTO `k_l` (`idk`, `idl`, `idz`)
		VALUES ((SELECT `ids` FROM `k-ts` WHERE `s` = '".$slovo_k."'),  
				(SELECT `ids` FROM `l-ts` WHERE `s` = '".$perevod[$i]."'),
				(SELECT `idz` FROM `tz` WHERE `z` = '".$znachenie[$i]."'))  
		");
		$b++;
		}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	//for($i = 0; $i < count($perevod); $i++)
//	{
//		mysql_query("  
//		INSERT IGNORE INTO `l-ts` (`s`)
//		VALUES ('".$perevod[$i]."')
//		");
//		mysql_query(" 
//		INSERT IGNORE INTO `tz` (`z`)
//		VALUES ('".$znachenie[$i]."')
//		");
//		$kontrol = mysql_query("  
//		INSERT INTO `k_l` (`idk`, `idl`, `idz`)
//		VALUES ((SELECT `ids` FROM `k-ts` WHERE `s` = '".$slovo_k."'),  
//				(SELECT `ids` FROM `l-ts` WHERE `s` = '".$perevod[$i]."'),
//				(SELECT `idz` FROM `tz` WHERE `z` = '".$znachenie[$i]."'))  
//		");
//		$b++;
//		}
//		file_put_contents('kontrol.txt',$kontrol, FILE_APPEND);
	///////////////////////file_put_content('kontrol.txt',$kontrol, FILE_APPEND)/////////////////////////////
	/////////////////////////
	$_SESSION["aaa"] = $b;
	/////////////////////////
	
	mysql_query("
	UPDATE `k-ts`
	SET `f` = 1
	WHERE `s` = '".$slovo_k."' 
	");
	}
	//else if (!isset($perevod))
//	{
//		mysql_query("
//		UPDATE `k-ts`
//		SET `f` = 6
//		WHERE `s` = '".$slovo_k."' and `f` = 0
//		");
//		}
	else if (!isset($perevod) && ($slovo_original == $slovo_k)) //простопомечаем слово переведённым, если ничего не меняли с ним (предполагается, что слово имеет уже переводы)
	{
		mysql_query("
		UPDATE `k-ts`
		SET `f` = 1
		WHERE `s` = '".$slovo_k."'
		");
		}

mysql_close($podkluchenie);

$_SESSION['slovo_k'] = $slovo_k;

header("Location: http://up.meta.afoteris.com/perevod_prosmotr_po_zayavke.php");

?>