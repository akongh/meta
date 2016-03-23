<?php
session_start();
require_once ('bd.php');
$regulyar_imya = "/[А-я-]+/i";
$regulyar_el_pochta = "/^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,6}$/i";
$regulyar_parol = "|^[А-я0-9]+$|i";
$regulyar_parol_2 = "|^[А-я0-9]+$|i";
if (isset($_POST["vojti"])) {
    $el_pochta_vxod = trim(htmlspecialchars(stripslashes($_POST["el_pochta_vxod"])));
    $parol_vxod = trim(htmlspecialchars(stripslashes($_POST["parol_vxod"])));
    if (empty($el_pochta_vxod)) {
        $pusto_el_pochta_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите адрес эл. почты.</span>";
    } else {
        if (!preg_match($regulyar_el_pochta, $el_pochta_vxod)) {
            $oshibka_el_pochta_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Неверный формат адреса эл. почты.</span>";
        } else {
            $proverka_el_pochty_vxod = mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '$el_pochta_vxod'");
            $otvet_proverka_el_pochty_vxod = mysql_fetch_array($proverka_el_pochty_vxod);
            if (!empty($otvet_proverka_el_pochty_vxod['el_p'])) {
                $status_el_pochta_vxod = TRUE;
            }
            unset($oshibka_el_pochta_vxod);
        }
    }
    if (empty($parol_vxod)) {
        $pusto_parol_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите пароль.</span>";
    } else {
        if (!preg_match($regulyar_parol, $parol_vxod)) {
            $oshibka_parol_vxod = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только кирилица и цифры.</span>";
        } else {
            $status_parol_vxod = TRUE;
            unset($$oshibka_parol_vxod);
        }
    }
    if (($status_el_pochta_vxod == TRUE) && ($status_parol_vxod == TRUE)) {
        $parol_vxod_md5 = md5($parol_vxod);
        $proverka_parol_vxod_md5 = mysql_query("SELECT `par` FROM `tp` WHERE `el_p` = '$el_pochta_vxod'");
        $otvet_proverka_parol_vxod_md5 = mysql_fetch_array($proverka_parol_vxod_md5);
        $parol_vxod_md5_2 = $otvet_proverka_parol_vxod_md5['par'];
        if ($parol_vxod_md5 == $parol_vxod_md5_2) {
            $aktiv = mysql_query("SELECT `aktiv` FROM `tp` WHERE `el_p` = '$el_pochta_vxod'");
            $otvet_aktiv = mysql_fetch_array($aktiv);
            $aktiv = $otvet_aktiv['aktiv'];
            if ($aktiv == 1) {
                $id_pol = mysql_query("SELECT `idp` FROM `tp` WHERE `el_p` = '$el_pochta_vxod'");
                $otvet_id_pol = mysql_fetch_array($id_pol);
                $id_pol = $otvet_id_pol['idp'];
                $imya_pol = mysql_query("SELECT `imya` FROM `tp` WHERE `el_p` = '$el_pochta_vxod'");
                $otvet_imya_pol = mysql_fetch_array($imya_pol);
                $imya_pol = $otvet_imya_pol['imya'];
                $el_p_pol = mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '$el_pochta_vxod'");
                $otvet_el_p_pol = mysql_fetch_array($el_p_pol);
                $el_p_pol = $otvet_el_p_pol['el_p'];
                $_SESSION['id_pol'] = $id_pol;
                $_SESSION['imya_pol'] = $imya_pol;
                $_SESSION['el_p_pol'] = $el_p_pol;
                require_once ('shag_1.php');
            } else {
				$_SESSION["el_pochta_vxod"] = $_POST["el_pochta_vxod"];
                $oshibka_aktiv = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Вы ещё не активировались.<br>
				Активируйтесь, перейдя по ссылке, отправленой вам ранее<br>
				или <a href=\"reg_pismo_povtor.php\">получите ссылку для активации</a> ещё раз.</span>";
                require_once ('index.php');
            }
        } else {
            $oshibka_dostup = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Комбинация данных не существует.</span>";
            require_once ('index.php');
        }
    } else {
        $oshibka_dostup = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Комбинация данных не существует.</span>";
        require_once ('index.php');
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
            $proverka_el_pochty = mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '$el_pochta'");
            $otvet_proverka_el_pochty = mysql_fetch_array($proverka_el_pochty);
            if (!empty($otvet_proverka_el_pochty['el_p'])) {
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
        if (!preg_match($regulyar_parol_2, $parol_2)) {
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
            INSERT INTO `tp` (`imya`, `el_p`, `par`, `vr_reg`, `kod`) VALUES ('" . $imya . "', '" . $el_pochta . "', '" . $parol . "', '" . $vr_reg . "', '" . $kod . "') 
            ");
        $tema_pisma = "Подтвердите регистрацию на slova.sferagrafiki.ru";
        $tekst_pisma = "Подтвердите регистрацию, перейдя по ссылке:\n 
http://slova.sferagrafiki.ru/proverka_koda.php?el_pochta=" . $el_pochta . "&kod=" . $kod;
        $dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
        $dop_zagolovok = 'From: slova.by <admin@andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        mail($el_pochta, $tema_pisma, $tekst_pisma, $dop_zagolovok); //здесь письмо отправить
        require_once ('_reg_pismo.html');
    }
    unset($pusto_imya, $pusto_el_pochta, $pusto_parol, $pusto_parol_2, $imya, $el_pochta, $parol, $parol_2);
}
?>