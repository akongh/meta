<?php
session_start();
include ('metka_vxoda.php');
include ('regularnye_vyrazheniya.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];
$vvod_slov = $_POST["vvod_slov"];//var_dump($vvod_slov);

include('slova_nabory.php');
include('slova_nabory_pol.php');

//помещаем в переменную опорные слова строкой
$vvod_slov = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($vvod_slov))), "utf-8"));//var_dump($vvod_slov);
//$vvod_slov = preg_replace("/^(the )|( the )|( the)$/", "", $vvod_slov);//var_dump($vvod_slov);
$vvod_slov = preg_replace("/ {2,}/", " ", $vvod_slov);//var_dump($vvod_slov);
//разбиваем строку опорных слов на части и заносим их в массив(есть лишние пробелы)
$oporn_slova = preg_split("[\n|,|;]", $vvod_slov, -1, PREG_SPLIT_NO_EMPTY);//var_dump($oporn_slova);
//перебираем массив из строки в новый массив (без лишних пробелов)
for ($i = 0;$i < count($oporn_slova);$i++)
{
	//удаляем лишние пробелы и обрезаем
	$oporn_slova_bez_probelov[$i] = trim($oporn_slova[$i]);
    }//var_dump($oporn_slova_bez_probelov);
//возвращаем последовательность индексам, удаляем дубликаты
//var_dump(isset($oporn_slova_bez_probelov));
if (isset($oporn_slova_bez_probelov))
{
	//возвращаем последовательность индексам, удаляем дубликаты
	$oporn_slova_bez_probelov = array_values(array_unique((array_diff($oporn_slova_bez_probelov, array('')))));//var_dump($oporn_slova_bez_probelov);
	if (count($oporn_slova_bez_probelov) > 0)
	{
		//готовим опорные слова для проверки на соответствие регулярному выраженияю
        $oporn_slova = implode("", $oporn_slova_bez_probelov);//var_dump($oporn_slova);
		if (preg_match($regulyar_slova, $oporn_slova))
		{
			//готовим опорные слова для запроса
            $oporn_slova = implode("','", $oporn_slova_bez_probelov);//var_dump($oporn_slova);
			//количество опорных слов
            $kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov);//var_dump($oporn_slova_bez_probelov);
			include ('2_SQL_zapros_podbor.php');//var_dump(isset($rezultat_podbora));
			//номера ячеек $massiv_rezultata
			$n = 0;
			while ($data = mysql_fetch_array($rezultat_podbora))//$rezultat_podbora  в файле 2_SQL_zapros_podbor.php
			{
				//массив для вывода результата подбора строкой
				$massiv_rezultata[$n] = $data['s'];
				$n++;//var_dump($data);
				}//var_dump($massiv_rezultata);
			if ($massiv_rezultata != NULL)
			{
				//объединяем массивы, удаляем дубликаты и переписываем индексы
				$massiv_rezultata = array_values(array_unique(array_merge($oporn_slova_bez_probelov, $massiv_rezultata))); //print_r ($massiv_rezultata);
				}
				else
				{
					$massiv_rezultata = $oporn_slova_bez_probelov;//print_r ($massiv_rezultata);
					}
			$_SESSION["massiv_rezultata"] = $massiv_rezultata;
			$_SESSION["kolichestvo_opornyx_slov"] = $kolichestvo_opornyx_slov;
			// РИСУЕМ СПИСОК ПОДБОРА С ФЛАЖКАМИ ###############################################
			for ($i = 0;$i < count($massiv_rezultata);$i++)
			{
				//сколько первых слов (первыми пойдут те, которые ввёл пользователь) отметить птичкой
				if ($i < $kolichestvo_opornyx_slov)
				{
					//начинаем вывод результата подбора списком с флажками и сразу отмечаем те, которые ввёл пользователь
					$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
				    }
					else
					{
						//продолжаем вывод результата подбора списком с флажками без отметок
						$spisok[$i] = "<input type=\"checkbox\" name=\"slova_s_flagom[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
						}
				}//echo "spisok — "; var_dump($spisok);
			$vyvod_spiska = implode("<br>\n", $spisok) . "<hr class=\"otbivka_24\">";//var_dump($vyvod_spiska);
			// ЗАКОНЧИЛИ РИСОВАТЬ СПИСОК ПОДБОРА С ФЛАЖКАМИ ##################################
			include ('shag_2.html');	
			}
			else
			{
				//var_dump($oporn_slova_bez_probelov);
				if ($oporn_slova_bez_probelov)
				{
					$vvod_slov = implode("\n", array_unique($oporn_slova_bez_probelov));//var_dump($vvod_slov);
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