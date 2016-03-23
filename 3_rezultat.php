<?php
session_start();
require_once('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];

$slova_flazhkov = $_POST["flazhok"];
if ($slova_flazhkov) {
    for ($i = 0;$i < count($slova_flazhkov);$i++) {
        $slova_flazhkov_bez_probelov[$i] = trim($slova_flazhkov[$i]); //удаляем лишние пробелы
    }
}
if ($_POST["dopolnenie"]) {
	$dopolnenie = strip_tags(stripslashes($_POST["dopolnenie"]));
    //разбиваем строку дополнительных слов на части и заносим их в массив(есть лишние пробелы)
    $dopolnitelnye_slova = preg_split("[\n|,|;]", $dopolnenie, -1, PREG_SPLIT_NO_EMPTY);
    for ($i = 0;$i < count($dopolnitelnye_slova);$i++) //перебираем массив из строки в новый массив (без лишних пробелов)
    {
        $dopolnitelnye_slova_bez_probelov[$i] = substr(trim($dopolnitelnye_slova[$i]),0,60); //удаляем лишние пробелы и обрезаем
    }
    $dopolnitelnye_slova_bez_probelov = array_values(array_unique(array_diff($dopolnitelnye_slova_bez_probelov, array('')))); //возвращаем последовательность индексам
}
if ($slova_flazhkov_bez_probelov && $dopolnitelnye_slova_bez_probelov) {
    $massiv_itog = array_values(array_unique(array_merge($slova_flazhkov_bez_probelov, $dopolnitelnye_slova_bez_probelov)));
} else if ($slova_flazhkov_bez_probelov && !$dopolnitelnye_slova_bez_probelov) {
    $massiv_itog = $slova_flazhkov_bez_probelov;
} else if (!$slova_flazhkov_bez_probelov && $dopolnitelnye_slova_bez_probelov) {
    $massiv_itog = $dopolnitelnye_slova_bez_probelov;
}
if ($massiv_itog) {
	$_SESSION["SESSION_massiv_itog"] = $massiv_itog; //добавляем в сессию массив всех итоговых слов
    $stroka_itog = implode("; ", $massiv_itog);
    $stroka_itog = $stroka_itog . "<hr class=\"otbivka_24\">";
}

require_once('shag_3.html');
?>