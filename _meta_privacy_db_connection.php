<?php

declare(strict_types=1);
error_reporting(-1);

$patch_to_db_connection = $_SERVER["DOCUMENT_ROOT"] . "/../_meta_privacy/db_connection";

if (file_exists($patch_to_db_connection)) {
    $db_connection_data = file($patch_to_db_connection, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (4 === count($db_connection_data)) {
        $server = $db_connection_data[0];
        $user = $db_connection_data[1];
        $password = $db_connection_data[2];
        $name = $db_connection_data[3];
    } else {
        echo "Count of DB connection data is wrong.";
        exit;
    }

    $mysqli = new mysqli($server, $user, $password, $name);

    if ($mysqli->connect_errno) {
        echo PHP_EOL . $mysqli->errno . PHP_EOL . $mysqli->error . PHP_EOL;
        exit;
    }

    $mysqli->set_charset('utf8');
    $mysqli->query("SET character_set_database=utf8");
    $mysqli->query("SET NAMES utf8");
    $mysqli->query("SET CHARACTER SET utf8");
} else {
    echo "Database connection settings were not found.";
    exit;
}
