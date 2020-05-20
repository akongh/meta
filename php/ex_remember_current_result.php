<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

$sost_nab = $_SESSION["resulting_arr"];
/*sort($sost_nab, SORT_STRING);*/
$_SESSION["state_of_kws_set"] = implode("; ", $sost_nab) . "
<span class='counter'>{$_SESSION["total_kws_amount"]}</span>
<br>
<br>
";

$_SESSION["kws_state"] = $_SESSION["resulting_arr"];

unset(
    $_SESSION["additional_kws"],
    $_SESSION["output_marked_kws_list"],
    $_SESSION["kws_query"],
    $_SESSION["err_msg_of_kws_amount"]
);

header("Location: //{$_SERVER["HTTP_HOST"]}/step_1.php");
