<?php

$dop_zagolovok = "MIME-Version: 1.0\r\n";
$dop_zagolovok .= "Content-Type: text/plain; charset=UTF-8\r\n";
$dop_zagolovok .= "From: =?utf-8?B?" . base64_encode($imya_pol) . "?= <" . $el_p_pol . ">\r\n";
$dop_zagolovok .= "Reply-To: " . $el_p_pol . "\r\n";
$dop_zagolovok .= "X-Mailer: PHP/" . phpversion();
mail("pochta@200slov.andrej.by", $tema_pisma, $tekst_pisma, $dop_zagolovok);

?>