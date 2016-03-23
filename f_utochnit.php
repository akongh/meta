<?php
session_start();

unset(
$_SESSION["kol_slov_itog"],
$_SESSION["massiv_itog"],
$_SESSION['dopolnenie_unikalnoe']
);

header("Location: http://200slov.andrej.by");

?>