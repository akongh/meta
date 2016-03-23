<?php
session_start();

include ('regularnye_vyrazheniya.php');
$vvod_slov = $_POST["vvod_slov"];

include('slova_nabory.php');

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
	$_SESSION["vvod_slov_utochnit"] = implode("\n", $oporn_slova_bez_probelov);
	
	if (count($oporn_slova_bez_probelov) > 0)
	{
        $oporn_slova = implode("", $oporn_slova_bez_probelov);
		if (preg_match($regulyar_slova, $oporn_slova))
		{
            $oporn_slova = implode("','", $oporn_slova_bez_probelov);
            $kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov);
			include ('2_SQL_zapros_podbor.php');
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
			$_SESSION["kolichestvo_opornyx_slov"] = $kolichestvo_opornyx_slov;
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
			include ('shag_2.html');	
			}
			else
			{
				if ($oporn_slova_bez_probelov)
				{
					$vvod_slov = implode("\n", array_unique($oporn_slova_bez_probelov));
					}
				$oshibka_simvol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кириллица или только латиница, пробел и дефис.</span>";
                include ('shag_1.html');
				}
		}
		else
		{
			unset($vvod_slov);
			$oshibka_net_slov = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Нет значимых ключевых слов для подбора.</span>";
            include ('shag_1.html');
			}
	}
	else
	{
		unset($vvod_slov);
		$oshibka_net_slov = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Нет значимых ключевых слов для подбора.</span>";
        include ('shag_1.html');
		}
?>