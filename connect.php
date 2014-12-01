<?php

$username = "root";
$password = "toor";
$hostname = "localhost"; 

//connection to the database
$db = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

mysql_select_db("phrasers") or die(mysql_error());

?>