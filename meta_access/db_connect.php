<?php

//На удалённом сервере

//$db_server = "by114.atservers.net";
//$db_user = "andrej";
//$db_password = "ss4TU0BH";
//$db_name = "webart_meta";


//На внутреннем сервере

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
};