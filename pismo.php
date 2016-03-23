<?php

$dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
$dop_zagolovok .= 'From: 200slov.andrej.by <pochta@200slov.andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
mail($el_p_pol, $tema_pisma, $tekst_pisma, $dop_zagolovok);

?>