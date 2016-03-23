<?php
session_start();
unset($_POST, $_SESSION);
session_destroy();
header("Location: http://slova.sferagrafiki.ru");
?>
