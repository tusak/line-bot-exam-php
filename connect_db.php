<?php
$Setup_Server = "119.59.104.28";
$Setup_User = "mkictne1_testbot";
$Setup_Pwd = "testbot";
$Setup_Database = "mkictne1_testbot";
mysql_connect($Setup_Server,$Setup_User,$Setup_Pwd);
mysql_query("use $Setup_Database");
mysql_query("SET NAMES UTF8");
?>