<?php
declare(strict_types=1);
error_reporting(-1);

$db_server   = "127.0.0.1";
$db_user     = "root";
$db_password = "root";
$db_name     = "_meta";

$db_connect = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($db_connect->connect_errno) {
    echo "<b>MySQL-server is not available…</b><br/>" . PHP_EOL .
        $db_connect->connect_errno . "<br/>" . PHP_EOL .
        $db_connect->connect_error;
    exit;
}

$db_connect->query("SET character_set_database=utf8");
$db_connect->query("SET NAMES utf8");
