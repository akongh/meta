<?php
declare(strict_types=1);
error_reporting(-1);

$db_server   = "127.0.0.1";
$db_user     = "root";
$db_password = "root";
$db_name     = "_meta";

$mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($mysqli->connect_errno) {
    echo "<b>MySQL-server is not available…</b><br/>" . PHP_EOL .
        $mysqli->connect_errno . "<br/>" . PHP_EOL .
        $mysqli->connect_error;
    exit;
}

$mysqli->query("SET character_set_database=utf8");
$mysqli->query("SET NAMES utf8");
