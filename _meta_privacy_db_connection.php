<?php

declare(strict_types=1);
error_reporting(-1);

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/../_meta_privacy/db_connection.php")) {
    require($_SERVER["DOCUMENT_ROOT"] . "/../_meta_privacy/db_connection.php");
} elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . "/_meta_privacy/db_connection.php")) {
    require($_SERVER["DOCUMENT_ROOT"] . "/_meta_privacy/db_connection.php");
} else {
    echo "Database connection settings were not found.";
    exit;
}
