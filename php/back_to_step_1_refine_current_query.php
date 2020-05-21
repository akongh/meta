<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

unset(
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_illegal_kws_query_amount"],
    $_SESSION["err_msg_of_kws_amount"]
);

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
