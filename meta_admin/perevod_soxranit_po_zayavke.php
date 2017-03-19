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

include ('/meta/meta_config_db.php');

if($slovo_original != $slovo_k)
{
	$proverka_nalichiya_slova = mysqli_query( $db_connect, "  
	SELECT `s` FROM `k-ts` WHERE `s` = '".$slovo_k."'
	");
	
	$n = 0;
	while ($data = mysqli_fetch_array($proverka_nalichiya_slova))
	{
		$proverka_nalichiya[$n] = $data['s'];
		$n++;
		}
		
	if(!isset($proverka_nalichiya))
	{
		mysqli_query( $db_connect, "
		UPDATE `k-ts`
		SET `s` = '".$slovo_k."'
		WHERE `s` = '".$slovo_original."' 
		");
		}
		else if(isset($proverka_nalichiya))
		{
			/////////////////////////////////////////////////////////////////////
			
			$ids_original = mysqli_query( $db_connect, "
			SELECT `ids` FROM `k-ts` WHERE `s` = '".$slovo_original."'
			");
			
			$n = 0;
			while ($data = mysqli_fetch_array($ids_original))
			{
				$ids_orig[$n] = $data['ids'];
				$n++;
				}
			
			$ids_original = $ids_orig[0];
			
			//////////////////////////////////////////////////////////////////////
			
			$ids_ispravlennogo = mysqli_query( $db_connect, "
			SELECT `ids` FROM `k-ts` WHERE `s` = '".$slovo_k."'
			");
			
			$n = 0;
			while ($data = mysqli_fetch_array($ids_ispravlennogo))
			{
				$ids_ispr[$n] = $data['ids'];
				$n++;
				}
			
			$ids_ispravlennogo = $ids_ispr[0];
			
			//////////////////////////////////////////////////////////////////////
			
			mysqli_query( $db_connect, "
			UPDATE LOW_PRIORITY IGNORE `k-t_s`
			SET `id_s` = '".$ids_ispravlennogo."'
			WHERE `id_s` = '".$ids_original."' 
			");
			
			mysqli_query( $db_connect, "
			UPDATE LOW_PRIORITY IGNORE `k_l`
			SET `idk` = '".$ids_ispravlennogo."'
			WHERE `idk` = '".$ids_original."' 
			");
			
			mysqli_query( $db_connect, "
			DELETE FROM `k-ts` WHERE `s` = '".$slovo_original."'
			");
			
			mysqli_query( $db_connect, "
			DELETE FROM `k-t_s` WHERE `id_s` = '".$ids_original."'
			");
			
			mysqli_query( $db_connect, "
			DELETE FROM `k_l` WHERE `idk` = '".$ids_original."'
			");
			}
	}

if(isset($perevod))
{
	$b = 0;
	for($i = 0; $i < count($perevod); $i++)
	{
		mysqli_query( $db_connect, "  
		INSERT IGNORE INTO `l-ts` (`s`)
		VALUES ('".$perevod[$i]."')
		");
		mysqli_query( $db_connect, " 
		INSERT IGNORE INTO `tz` (`z`)
		VALUES ('".$znachenie[$i]."')
		");
		mysqli_query( $db_connect, "  
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
//		mysqli_query( $db_connect, "
//		INSERT IGNORE INTO `l-ts` (`s`)
//		VALUES ('".$perevod[$i]."')
//		");
//		mysqli_query( $db_connect, "
//		INSERT IGNORE INTO `tz` (`z`)
//		VALUES ('".$znachenie[$i]."')
//		");
//		$kontrol = mysqli_query( $db_connect, "
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
	
	mysqli_query( $db_connect, "
	UPDATE `k-ts`
	SET `f` = 1
	WHERE `s` = '".$slovo_k."' 
	");
	}
	//else if (!isset($perevod))
//	{
//		mysqli_query( $db_connect, "
//		UPDATE `k-ts`
//		SET `f` = 6
//		WHERE `s` = '".$slovo_k."' and `f` = 0
//		");
//		}
	else if (!isset($perevod) && ($slovo_original == $slovo_k)) //просто помечаем слово переведённым, если ничего не меняли с ним (предполагается, что слово имеет уже переводы)
	{
		mysqli_query( $db_connect, "
		UPDATE `k-ts`
		SET `f` = 1
		WHERE `s` = '".$slovo_k."'
		");
		}

mysqli_close($db_connect);

$_SESSION['slovo_k'] = $slovo_k;

header("Location: http://meta.afoteris.com/meta_admin/perevod_prosmotr_po_zayavke.php");

?>