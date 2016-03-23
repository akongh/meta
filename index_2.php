<!doctype html> 

<html> 
<head> 
<meta charset="utf-8"> 
<title>Подбор ключевых слов</title> 
<link href="stili.css" rel="stylesheet" type="text/css"> 
</head> 

<body> 
<div class="korobka"> 
  <div class="zamechaniya_2">Версия…</div> 
  <hr class="otbivka_12"> 
  <div class="zagolovok">2/3<br><br>Уточните и дополните подбор своими ключевыми словами.</div> 
  <hr class="otbivka_48"> 
   
  <form method = "post" action="index_3.php"> 
   
  <?php
if ($_POST["vvod_slov"]) {
    $podkluchenie = mysql_connect("by114", "andrej", "ss4TU0BH") or die("MySQL сервер недоступен!" . mysql_error());
    mysql_query("SET character_set_database=utf8");
    mysql_query("SET NAMES utf8");
    mysql_select_db("webart_servis_k_s", $podkluchenie) or die("MySQL сервер недоступен!" . mysql_error());
    $vvod_slov = strip_tags(stripslashes($_POST["vvod_slov"])); //помещаем в переменную опорные слова строкой
    $oporn_slova = preg_split("[\n|,|;]", $vvod_slov, -1, PREG_SPLIT_NO_EMPTY); //разбиваем строку опорных слов на части и заносим их в массив(есть лишние пробелы)
    if ($oporn_slova) {
        for ($i = 0;$i < count($oporn_slova);$i++) //перебираем массив из строки в новый массив (без лишних пробелов)
        {
            $oporn_slova_bez_probelov[$i] = substr(trim($oporn_slova[$i]),0,60); //удаляем лишние пробелы и обрезаем
        }
        $oporn_slova_bez_probelov = array_values(array_unique((array_diff($oporn_slova_bez_probelov, array(''))))); //возвращаем последовательность индексам
        $oporn_slova = implode("','", $oporn_slova_bez_probelov); //готовим опорные слова для запроса
        $kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov); //количество опорных слов
        //########################################################################
        //%%%%%%%% SQL_zapros %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //echo "<br>";
        $SQL_zapros = "select ts.s, count(*) 
from ( 
  select t_s.id_n 
  from  ts 
  join t_s on t_s.id_s = ts.ids 
  where ts.s in ('" . $oporn_slova . "') 
  group by t_s.id_n having count(/*distinct*/ t_s.id_s) = " . $kolichestvo_opornyx_slov . " 
  ) g 
join t_s on t_s.id_n = g.id_n 
join ts on ts.ids = t_s.id_s 
group by t_s.id_s, ts.s 
order by count(*) desc, ts.s 
; 
";
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //############################################################################
        $rezultat_podbora = mysql_query($SQL_zapros);
    }
    mysql_close($podkluchenie);
}
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
    //#################################################################################
    // РИСУЕМ СПИСОК ПОДБОРА С ФЛАЖКАМИ ###############################################
    for ($i = 0;$i < count($massiv_rezultata);$i++) {
        if ($i < $kolichestvo_opornyx_slov) //сколько первых слов (первыми пойдут те, которые ввёл пользователь) отметить птичкой
        {
            //начинаем вывод результата подбора списком с флажками и сразу отмечаем те, которые ввёл пользователь
            echo "<input type=\"checkbox\" name=\"flazhok[]\" checked value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i] . "<br>\n";
        } else {
            //продолжаем вывод результата подбора списком с флажками без отметок
            echo "<input type=\"checkbox\" name=\"flazhok[]\" value = '" . $massiv_rezultata[$i] . "'> " . $massiv_rezultata[$i] . "<br>\n";
        }
    }
    // ЗАКОНЧИЛИ РИСОВАТЬ СПИСОК ПОДБОРА С ФЛАЖКАМИ ##################################
    //################################################################################
    echo "<hr class=\"otbivka_24\">";
}
?> 
   
  <!--продолжение формы--> 
  <textarea name="dopolnenie" wrap="off" class="dopolnenie" placeholder="" autofocus></textarea> 
  <div class="zamechaniya">Справка по сервису</div> 
  <hr class="otbivka_24"> 
  <input name="sobrat" type="submit" class="knopka" value="Собрать"> 
  <hr class="otbivka_48"> 
  <div class="sbros"><a href="index.php">Сбросить и сначала</a></div> 
  </form> 
</div> 
</body> 
</html>