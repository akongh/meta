<?php

declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

header("Location: //{$_SERVER["HTTP_HOST"]}/keyword_selection/step_1.php");
