<?php //error_reporting(0);
$podkluchenie = mysql_connect("by114", "andrej", "ss4TU0BH");
mysql_query("SET character_set_database=utf8");
mysql_query("SET NAMES utf8");
mysql_select_db("webart_200slov_p", $podkluchenie);
?>