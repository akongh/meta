<?php //error_reporting(0);
session_start();

session_unset();
unset($_POST);

include ('sql/SQL_ochered_na_perevod.php');

$n = 0;
while ($data = mysql_fetch_array($_SQL_rezultat_ochered))
{
	$_MASSIV_ochered[$n] = $data['s'];
	$n++;
	}
	
if ($_MASSIV_ochered != NULL)
{
	$_MASSIV_spisok_ochered = implode("<br>", $_MASSIV_ochered);
	$_SESSION["kol_slov_ochered"] = "<div class=\"statistika\">Слов на заявке — <span class=\"statistika_czyfra\">" . count($_MASSIV_ochered) . "</span>. </div>";
	}
	else
	{
		$_MASSIV_spisok_ochered = "Заявок на перевод пока нет.";
		}

include('ochered_na_perevod.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>