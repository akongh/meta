<?php

//$dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
$dop_zagolovok = 'From: slova.by <admin@andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
mail("ak.inforeg@yandex.ru", $tema_pisma, $tekst_pisma, $dop_zagolovok); //здесь письмо отправить

?>