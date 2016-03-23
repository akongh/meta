<?php
session_start();
unset($_POST, $_SESSION);
session_destroy();
header("Location: http://slova2.sferagrafiki.ru");
?>
