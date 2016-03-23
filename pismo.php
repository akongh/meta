<?php

$dop_zagolovok = "MIME-Version: 1.0\r\n";
$dop_zagolovok .= "Content-Type: text/html; charset=UTF-8\r\n";
$dop_zagolovok .= "From: =?utf-8?B?" . base64_encode("200slov.andrej.by") . "?= <pochta@200slov.andrej.by>\r\n";
$dop_zagolovok .= "Reply-To: pochta@200slov.andrej.by\r\n";
$dop_zagolovok .= "X-Mailer: PHP/" . phpversion();
mail($el_p_pol, $tema_pisma, $tekst_pisma, $dop_zagolovok);

?>