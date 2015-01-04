<?php

$urls = explode("\r\n", $_POST['url_box']);

$username = "root";
$password = "toor";
$hostname = "localhost"; 
$dbname = "pythia";

//connection to the database
$conn = mysqli_connect($hostname, $username, $password, $dbname) 
  or die("Unable to connect to MySQL");

mysqli_select_db($conn, $dbname) or die(mysql_error());
?>
