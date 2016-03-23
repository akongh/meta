<?php
session_start();
require_once ('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];
require_once ('bd.php');
require_once ('regularnye_vyrazheniya.php');
if (isset($_POST["smen_parol"])) {
    $parol = trim(htmlspecialchars(strip_tags(stripslashes($_POST["nov_parol"]))));
    $parol_2 = trim(htmlspecialchars(strip_tags(stripslashes($_POST["nov_parol_2"]))));
    if (empty($parol)) {
        $pusto_parol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите новый пароль.</span>";
    } else {
        if (!preg_match($regulyar_parol, $parol)) {
            $oshibka_parol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только цифры (5—12).</span>";
        } else {
            unset($$oshibka_parol);
        }
    }
    if (empty($parol_2)) {
        $pusto_parol_2 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Повторите новый пароль.</span>";
    } else {
        if (!preg_match($regulyar_parol, $parol_2)) {
            $oshibka_parol_2 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только цифры (5—12).</span>";
        } else {
            unset($$oshibka_parol_2);
        }
    }
    if ((!empty($parol) && !empty($parol_2)) && ($parol != $parol_2)) {
        $oshibka_raznye_paroli = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Пароли не совпадают.</span>";
    } else {
        unset($oshibka_raznye_paroli);
    }
    if ($oshibka_parol or $oshibka_parol_2 or $oshibka_raznye_paroli or $pusto_parol or $pusto_parol_2) {
        require_once ('kabinet.html');
    } else {
        $kod = md5(rand());
        $parol = md5($parol);
        mysql_query("  
        UPDATE `tp` SET `nov_par` = '" . $parol . "', `kod` = '" . $kod . "' 
        WHERE `el_p` = '" . $el_p_pol . "' 
        ");
        $tema_pisma = "Подтвердите смену пароля на slova2.sferagrafiki.ru";
        $tekst_pisma = "Подтвердите смену пароля, перейдя по ссылке:\n  
http://slova2.sferagrafiki.ru/proverka_koda_smen_par.php?el_pochta=" . $el_p_pol . "&kod=" . $kod;
        //$dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
        $dop_zagolovok = 'From: slova.by <admin@andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        mail($el_p_pol, $tema_pisma, $tekst_pisma, $dop_zagolovok); //здесь письмо отправить
        require_once ('smen_par_pismo.html');
    }
}
else
{
	require_once ('kabinet.html');
	}
?>