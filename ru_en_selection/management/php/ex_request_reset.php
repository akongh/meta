<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

$zayavka_na_perevod = "
update `k-ts`
set `k-ts`.`f` = 0
where `k-ts`.`f` = 7
";
mysqli_query($mysqli, $zayavka_na_perevod);
mysqli_close($mysqli);
header("Location: " . $_SERVER["DOCUMENT_ROOT"] . "/management/add_related_in_request.php");
