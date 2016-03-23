<?php
session_start();
include('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

if (isset($_POST["otprav_soobsshenie"]))
{
	$soobsshenie = trim($_POST["soobsshenie"]);
	if (isset($soobsshenie) && !empty($soobsshenie))
	{
		$tema_pisma = "Обратная связь: №".$id_pol.", ".$el_p_pol.".";
		$tema_pisma = "=?utf-8?b?". base64_encode($tema_pisma) ."?=";
		$tekst_pisma = trim(htmlspecialchars(strip_tags(stripslashes($soobsshenie))));
		include('pismo_soobsshenie.php');
		
		include('bd.php');
		$vr_s = time();
		$vstav_soob = mysql_query("
		INSERT INTO `soob` (`el_p`, `vr_s`, `soob`)  
		VALUES ('".$el_p_pol."', '".$vr_s."', '".$tekst_pisma."')
		");
		mysql_close($podkluchenie);

		header("Location: /soobssh_otpravleno.php");
		}
		else
		{
			$pustoe_soob = "<span class=\"oshibka\">Вы ничего не написали.</span><br>";
			}
	}

include('obratnaya_svyaz.html');
?>