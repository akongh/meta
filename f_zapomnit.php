<?php
session_start();

$_SESSION["sostoyanie_nabora"] = $_SESSION["sobranny_nabor"];

unset(
$_SESSION["dopolnitelnye_slova"],
$_SESSION["opornye_slova"]
);

header("Location: http://proba.200slov.andrej.by");
?>