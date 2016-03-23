<?php
session_start();
require_once('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];

if ($_POST["vvod_slov"]) {
    require_once ('bd.php');
    $vvod_slov = strip_tags(stripslashes($_POST["vvod_slov"])); //помещаем в переменную опорные слова строкой
    $oporn_slova = preg_split("[\n|,|;]", $vvod_slov, -1, PREG_SPLIT_NO_EMPTY); //разбиваем строку опорных слов на части и заносим их в массив(есть лишние пробелы)
    if ($oporn_slova) {
        for ($i = 0;$i < count($oporn_slova);$i++) //перебираем массив из строки в новый массив (без лишних пробелов)
        {
            $oporn_slova_bez_probelov[$i] = substr(trim($oporn_slova[$i]), 0, 60); //удаляем лишние пробелы и обрезаем
            
        }
        $oporn_slova_bez_probelov = array_values(array_unique((array_diff($oporn_slova_bez_probelov, array(''))))); //возвращаем последовательность индексам
        $oporn_slova = implode("','", $oporn_slova_bez_probelov); //готовим опорные слова для запроса
        $kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov); //количество опорных слов
        //%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $SQL_zapros = "select `ts`.`s`, count(*)   
from (   
  select `".$id_pol."--t_s`.`id_n`   
  from  `ts`   
  join `".$id_pol."--t_s` on `".$id_pol."--t_s`.`id_s` = `ts`.`ids`   
  where `ts`.`s` in ('".$oporn_slova."')   
  group by `".$id_pol."--t_s`.`id_n` having count(/*distinct*/ `".$id_pol."--t_s`.`id_s`) = '".$kolichestvo_opornyx_slov."'   
  ) `g`  
join `".$id_pol."--t_s` on `".$id_pol."--t_s`.`id_n` = `g`.`id_n`   
join `ts` on `ts`.`ids` = `".$id_pol."--t_s`.`id_s`   
group by `".$id_pol."--t_s`.`id_s`, `ts`.`s`   
order by count(*) desc, `ts`.`s` 
;   
";
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $rezultat_podbora = mysql_query($SQL_zapros);
    }
    mysql_close($podkluchenie);
    if ($rezultat_podbora) {
        $n = 0; //номера ячеек $massiv_rezultata
        while ($data = mysql_fetch_array($rezultat_podbora)) //если в $rezultat_podbora нет ни одной записи, то цикл не выполняется
        {
            $massiv_rezultata[$n] = $data['s']; //массив для вывода результата подбора строкой
            $n++;
        };
        if ($massiv_rezultata) {
            $massiv_rezultata = array_values(array_unique(array_merge($oporn_slova_bez_probelov, $massiv_rezultata))); //объединяем массивы, удаляем дубликаты и переписываем индексы
            
        } else {
            $massiv_rezultata = $oporn_slova_bez_probelov;
        }
        // РИСУЕМ СПИСОК ПОДБОРА С ФЛАЖКАМИ ###############################################
        for ($i = 0;$i < count($massiv_rezultata);$i++) {
            if ($i < $kolichestvo_opornyx_slov) //сколько первых слов (первыми пойдут те, которые ввёл пользователь) отметить птичкой
            {
                //начинаем вывод результата подбора списком с флажками и сразу отмечаем те, которые ввёл пользователь
                $spisok[$i] = "<input type=\"checkbox\" name=\"flazhok[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
            } else {
                //продолжаем вывод результата подбора списком с флажками без отметок
                $spisok[$i] = "<input type=\"checkbox\" name=\"flazhok[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i];
            }
        }
        // ЗАКОНЧИЛИ РИСОВАТЬ СПИСОК ПОДБОРА С ФЛАЖКАМИ ##################################
        $vyvod_spiska = implode("<br>\n", $spisok) . "<hr class=\"otbivka_24\">";
    }
}
require_once ('shag_2.html');
?>