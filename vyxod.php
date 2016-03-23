<?php
session_start();
unset($_POST, $_SESSION);
session_destroy();
header("Location: http://200slov.andrej.by");
?>
