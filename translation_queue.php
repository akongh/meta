<?php error_reporting(-1);
session_start();

session_unset();
unset($_POST);

include( 'sql/SQL_ochered_na_perevod.php' );
include( 'meta_config.php' );

$n = 0;
while ($data = mysqli_fetch_array($_SQL_rezultat_ochered))
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

include( 'translation_queue.html' );