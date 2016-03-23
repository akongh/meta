<?php
$podkluchenie = mysql_connect("by114", "andrej", "ss4TU0BH") or die("MySQL сервер недоступен!<br>" . mysql_error());
mysql_query("SET character_set_database=utf8");
mysql_query("SET NAMES utf8");
mysql_select_db("webart_servis_k_s", $podkluchenie) or die("MySQL сервер недоступен!<br>" . mysql_error());
?>