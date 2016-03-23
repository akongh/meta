<?php
session_start();
unset(
$_SESSION["oshibka_net_slov"],
$_SESSION["oshibka_simvol"],
$_SESSION["vvod_slov"],
$_SESSION["massiv_rezultata"],
$_SESSION["vyvod_spiska"]
);

include ('regularnye_vyrazheniya.php');
include('SQL_slova_nabory.php');

$massiv_itog_zapom = $_SESSION["massiv_itog_zapom"];//для проверки на ошибку символов во втором и т. д. кругах
$vvod_slov = $_POST["vvod_slov"];
$vvod_slov = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($vvod_slov))), "utf-8"));
$vvod_slov = preg_replace("/ {2,}/", " ", $vvod_slov);
$oporn_slova = preg_split("[\n|,|;]", $vvod_slov, -1, PREG_SPLIT_NO_EMPTY);
for ($i = 0;$i < count($oporn_slova);$i++)
{
	$oporn_slova_bez_probelov[$i] = trim($oporn_slova[$i]);
    }
if (isset($oporn_slova_bez_probelov))
{
	$oporn_slova_bez_probelov = array_values(array_unique((array_diff($oporn_slova_bez_probelov, array('')))));
	
	
	
	
	
	if(isset($massiv_itog_zapom) && $oporn_slova_bez_probelov != NULL)
	{
		$proverka_simvol = array_merge($massiv_itog_zapom, $oporn_slova_bez_probelov);
		$proverka_simvol = implode("", $proverka_simvol);
		if (!preg_match($regulyar_slova, $proverka_simvol))
		{
			$vvod_slov = implode("\n", $oporn_slova_bez_probelov);
			$_SESSION["vvod_slov"] = $vvod_slov;
			
			$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
			$_SESSION["oshibka_simvol"] = $oshibka_simvol;
			header("Location: http://200slov.andrej.by");
			exit;
			}
		}
	
	
	
	

	if (count($oporn_slova_bez_probelov) > 0)
			{
				$oporn_slova = implode("", $oporn_slova_bez_probelov);
				if (preg_match($regulyar_slova, $oporn_slova))
				{
					$oporn_slova = implode("','", $oporn_slova_bez_probelov);
					$kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov);
					include ('SQL_zapros_podbor.php');
					$n = 0;
					while ($data = mysql_fetch_array($rezultat_podbora))
					{
						$massiv_rezultata[$n] = $data['s'];
						$n++;
						}
					if ($massiv_rezultata != NULL)
					{
						$massiv_rezultata = array_values(array_unique(array_merge($oporn_slova_bez_probelov, $massiv_rezultata)));
						}
						else
						{
							$massiv_rezultata = $oporn_slova_bez_probelov;
							}
				$_SESSION["massiv_rezultata"] = $massiv_rezultata;

	




			for ($i = 0;$i < count($massiv_rezultata);$i++)
			{
				if ($i < $kolichestvo_opornyx_slov)
				{
					$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
				    }
					else
					{
						$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
						}
				}
			$vyvod_spiska = implode("<br>\n", $spisok) . "<hr class=\"otbivka_24\">";
			$_SESSION["vyvod_spiska"] = $vyvod_spiska;
			header("Location: http://200slov.andrej.by/2_dopolnenie.php");
			}
			else
			{
				if (isset($oporn_slova_bez_probelov))
				{
					$vvod_slov = implode("\n", array_unique($oporn_slova_bez_probelov));
					$_SESSION["vvod_slov"] = $vvod_slov;
					}
				$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
				$_SESSION["oshibka_simvol"] = $oshibka_simvol;
                header("Location: http://200slov.andrej.by");
				}
		}
		else
		{
			if(isset($_SESSION["stroka_itog_zapom"]))
			{
				header("Location: http://200slov.andrej.by/2_dopolnenie.php");
				}
				else
				{
					$oshibka_net_slov = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Нет значимых ключевых слов для подбора.</span>";
					$_SESSION["oshibka_net_slov"] = $oshibka_net_slov;
					header("Location: http://200slov.andrej.by");
					}
			}
	}
	else
	{
		if(isset($_SESSION["stroka_itog_zapom"]))
			{
				header("Location: http://200slov.andrej.by/2_dopolnenie.php");
				}
				else
				{
					$oshibka_net_slov = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Нет значимых ключевых слов для подбора.</span>";
					$_SESSION["oshibka_net_slov"] = $oshibka_net_slov;
					header("Location: http://200slov.andrej.by");
					}
		}

?>