<?php
//задайте название бд, имя, пароль, адрес.
$dbName = "down";
$dbUserName = "root";
$dbPass = "root";
$host="localhost";
$upload_dir = "uploads";


$db = mysql_connect($host, $dbUserName, $dbPass) or die ("Could not connect");
mysql_select_db($dbName,$db);
?>
