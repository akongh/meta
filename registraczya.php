<?php
session_start();
require_once ('bd.php');
require_once('regul_imya.php');
require_once('regul_pochta_parol.php');

if (isset($_POST["zaregistrirovatsya"])) {
    $imya = trim(htmlspecialchars(stripslashes($_POST["reg_imya"])));
    $el_pochta = trim(htmlspecialchars(stripslashes($_POST["reg_el_pochta"])));
    $parol = trim(htmlspecialchars(stripslashes($_POST["reg_parol"])));
    $parol_2 = trim(htmlspecialchars(stripslashes($_POST["reg_parol_2"])));
    if (empty($imya)) {
        $pusto_imya = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите имя.</span>";
    } else {
        if (!preg_match($regulyar_imya, $imya)) {
            $oshibka_imya = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кирилица и дефис.</span>";
        } else {
            unset($oshibka_imya);
        }
    }
    if (empty($el_pochta)) {
        $pusto_el_pochta = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите адрес эл. почты.</span>";
    } else {
        if (!preg_match($regulyar_el_pochta, $el_pochta)) {
            $oshibka_el_pochta = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Неверный формат адреса эл. почты.</span>";
        } else {
            $proverka_el_pochty = mysql_fetch_array(mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '".$el_pochta."'"));
            if (!empty($proverka_el_pochty['el_p'])) {
                $zareg_el_pochta = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Этот адрес уже зарегистрирован.</span>";
            } else {
                unset($zareg_el_pochta);
            }
            unset($oshibka_el_pochta);
        }
    }
    if (empty($parol)) {
        $pusto_parol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите пароль.</span>";
    } else {
        if (!preg_match($regulyar_parol, $parol)) {
            $oshibka_parol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кирилица и цифры.</span>";
        } else {
            unset($$oshibka_parol);
        }
    }
    if (empty($parol_2)) {
        $pusto_parol_2 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Повторите пароль.</span>";
    } else {
        if (!preg_match($regulyar_parol, $parol_2)) {
            $oshibka_parol_2 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кирилица и цифры.</span>";
        } else {
            unset($$oshibka_parol_2);
        }
    }
    if ((!empty($parol) && !empty($parol_2)) && ($parol != $parol_2)) {
        $oshibka_raznye_paroli = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Пароли не совпадают.</span>";
    } else {
        unset($oshibka_raznye_paroli);
    }
    if ($oshibka_imya or $oshibka_el_pochta or $oshibka_parol or $oshibka_parol_2 or $oshibka_raznye_paroli or $pusto_imya or $pusto_el_pochta or $pusto_parol or $pusto_parol_2 or $zareg_el_pochta) {
        require_once ('index.php');
    } else {
        $vr_reg = time();
        $kod = md5(rand());
        $parol = md5($parol);
        mysql_query(" 
            INSERT INTO `tp` (`imya`, `el_p`, `par`, `vr_reg`, `kod`) VALUES ('".$imya."', '".$el_pochta."', '".$parol."', '".$vr_reg."', '".$kod."') 
            ");
        $tema_pisma = "Подтвердите регистрацию на slova.sferagrafiki.ru";
        $tekst_pisma = "Подтвердите регистрацию, перейдя по ссылке:\n 
http://slova.sferagrafiki.ru/proverka_koda.php?el_pochta=" . $el_pochta . "&kod=" . $kod;
        require_once('pismo.php');
        require_once ('reg_pismo.html');
    }
    unset($pusto_imya, $pusto_el_pochta, $pusto_parol, $pusto_parol_2, $imya, $el_pochta, $parol, $parol_2);
}
?>