<?php
$_host = "localhost";
$_user = "root";
$_pass = "admin";
$_db = "mongkolapp";
$conn = mysql_connect($_host, $_user, $_pass) or die("<h1>Connect server Fail</h1>");
mysql_select_db($_db) or die("Connect Fail");
mysql_query("SET NAMES UTF8");
?>