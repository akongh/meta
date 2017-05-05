<?php error_reporting( - 1 );

//--[meta.afoteris.com]--
//$db_server = "by122.atservers.net";
//$db_user = "user2031505";
//$db_password = "813p9VQSHSc6";
//$db_name = "user2031505_meta";

//--[meta]--
$db_server = "127.0.0.1";
$db_user = "root";
$db_password = "root";
$db_name = "_meta";

$db_connect = mysqli_connect( $db_server, $db_user, $db_password, $db_name );
mysqli_query( $db_connect, "SET character_set_database=utf8" );
mysqli_query( $db_connect, "SET NAMES utf8" );

if ( ! $db_connect ) {
	echo "MySQL-сервер недоступен." . PHP_EOL;
	exit;
}