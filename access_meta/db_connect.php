<?php error_reporting( - 1 );

$db_server   = "127.0.0.1";
$db_user     = "root";
$db_password = "root";
$db_name     = "_meta";

$db_connect = mysqli_connect( $db_server, $db_user, $db_password, $db_name );
mysqli_query( $db_connect, "SET character_set_database=utf8" );
mysqli_query( $db_connect, "SET NAMES utf8" );

if ( ! $db_connect ) {
	echo "MySQL-server is not available." . PHP_EOL;
	exit;
}
