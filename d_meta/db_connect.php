<?php

$db_server = "127.0.0.1";//by114.atservers.net

$db_user = "root";//andrej

$db_password = "root";//ss4TU0BH

$db_name = "_meta";//webart_meta


$db_connect = mysqli_connect( $db_server, $db_user, $db_password, $db_name );
mysqli_query( $db_connect, "SET character_set_database=utf8" );
mysqli_query( $db_connect, "SET NAMES utf8" );

if ( ! $db_connect ) {
	echo "MySQL-сервер недоступен." . PHP_EOL;
	exit;
};