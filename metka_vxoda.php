<?php

if (!isset($_SESSION['metka_vxoda']) or $_SESSION['metka_vxoda'] != TRUE)
{
header("Location: http://200slov.andrej.by");
    exit;
}

?>