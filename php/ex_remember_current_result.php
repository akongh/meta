<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

$_SESSION["kws_state"] = $_SESSION["resulting_arr"];

unset(
    $_SESSION["additional_kws"],
    $_SESSION["output_marked_kws_list"],
    $_SESSION["kws_query"],
    $_SESSION["err_msg_of_kws_amount"]
);

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
