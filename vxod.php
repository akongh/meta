<?php
session_start();
include('slova_nabory.php');
include ('bd.php');
include('regularnye_vyrazheniya.php');

if (isset($_POST["vojti"]))
{
	sleep(1);
    $el_pochta_vxod = trim(htmlspecialchars(strip_tags(stripslashes($_POST["el_pochta_vxod"]))));
    $parol_vxod = trim(htmlspecialchars(strip_tags(stripslashes($_POST["parol_vxod"]))));
    if (empty($el_pochta_vxod)) {
        $pusto_el_pochta_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите адрес эл. почты.</span>";
    } else {
        if (!preg_match($regulyar_el_pochta, $el_pochta_vxod)) {
            $oshibka_el_pochta_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Неверный формат адреса эл. почты.</span>";
        } else {
            $proverka_el_pochty_vxod = mysql_fetch_array(mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '".$el_pochta_vxod."'"));
            if (!empty($proverka_el_pochty_vxod['el_p'])) {
                $status_el_pochta_vxod = TRUE;
            }
            unset($oshibka_el_pochta_vxod);
        }
    }
    if (empty($parol_vxod)) {
        $pusto_parol_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите пароль.</span>";
    } else {
        if (!preg_match($regulyar_parol, $parol_vxod)) {
            $oshibka_parol_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только цифры (5—12).</span>";
        } else {
            $status_parol_vxod = TRUE;
            unset($$oshibka_parol_vxod);
        }
    }
    if (($status_el_pochta_vxod == TRUE) && ($status_parol_vxod == TRUE)) {
        $parol_vxod_md5 = md5($parol_vxod);
        $proverka_parol_vxod_md5 = mysql_fetch_array(mysql_query("SELECT `par` FROM `tp` WHERE `el_p` = '".$el_pochta_vxod."'"));
        $parol_vxod_md5_2 = $proverka_parol_vxod_md5['par'];
        if ($parol_vxod_md5 == $parol_vxod_md5_2) {
            $aktiv = mysql_fetch_array(mysql_query("SELECT `aktiv` FROM `tp` WHERE `el_p` = '".$el_pochta_vxod."'"));
            $aktiv = $aktiv['aktiv'];
            if ($aktiv == 1) {
                $id_pol = mysql_fetch_array(mysql_query("SELECT `idp` FROM `tp` WHERE `el_p` = '".$el_pochta_vxod."'"));
                $id_pol = $id_pol['idp'];
                $imya_pol = mysql_fetch_array(mysql_query("SELECT `imya` FROM `tp` WHERE `el_p` = '".$el_pochta_vxod."'"));
                $imya_pol = $imya_pol['imya'];
				$el_p_pol = $el_pochta_vxod;
                $_SESSION['metka_vxoda'] = TRUE;
                $_SESSION['id_pol'] = $id_pol;
                $_SESSION['imya_pol'] = $imya_pol;
                $_SESSION['el_p_pol'] = $el_p_pol;
				header("Location: /1_vvod_slov.php");
            } else {
				$_SESSION["el_pochta_vxod"] = trim(htmlspecialchars(strip_tags(stripslashes($_POST["el_pochta_vxod"]))));
                $oshibka_aktiv = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Вы ещё не подтвердили регистрацию.<br>
				Подтвердите регистрацию, перейдя по ссылке, отправленой вам ранее<br>
				или <a href=\"reg_pismo_povtor.php\" title=\"Получить ссылку для подтверждения регистрации\">получите ссылку для подтверждения регистрации</a> ещё раз.</span>";
				include('_index.html');
            }
        } else {
            $oshibka_dostup = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Комбинация данных не существует.</span>";
            include('_index.html');
        }
    } else {
        $oshibka_dostup = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Комбинация данных не существует.</span>";
        include('_index.html');
    }
}
else
{
	header("Location: http://200slov.andrej.by");
	}
?>