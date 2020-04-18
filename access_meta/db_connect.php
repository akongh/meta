<?php
declare(strict_types=1);
error_reporting(-1);

$server = "127.0.0.1";
$user = "root";
$password = "root";
$name = "_meta";

$mysqli = new mysqli($server, $user, $password, $name);

if ($mysqli->connect_errno) {
    echo PHP_EOL . $mysqli->errno . " -> " . $mysqli->error . PHP_EOL;
    exit;
}

$mysqli->query("SET character_set_database=utf8");
$mysqli->query("SET NAMES utf8");
