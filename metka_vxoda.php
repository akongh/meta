<?php

if (!isset($_SESSION['metka_vxoda']) or $_SESSION['metka_vxoda'] != TRUE)
{
header("Location: http://slova2.sferagrafiki.ru");
    exit;
}

?>