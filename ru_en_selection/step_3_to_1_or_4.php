<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_POST);

if (isset($_POST["order"])) {
    require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/step_3_to_4.php');
} elseif (isset($_POST["remember"])) {
    require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/step_3_to_1_remember.php');
}
