<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

unset(
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_illegal_kws_query_amount"],
    $_SESSION["err_msg_of_kws_amount"],
    $_SESSION["arr_kws_selection"],
    $_SESSION["output_marked_kws_list"],
    $_SESSION["additional_kws"],
    $_SESSION["assembled_kws_set"],
    $_SESSION["resulting_arr"]
);

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
