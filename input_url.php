<?php
include 'connect.php';

foreach($urls as $val) {
	echo $val . "<br/>";
	$val = mysqli_real_escape_string($conn, $val);
	echo $val . "<br/>";
	$query = "INSERT INTO `pictures` (`url`) VALUES ('$val')";
	mysqli_query($conn, $query) or die(mysql_error() . "frick");
}
header("Location: pictures.php");
die();
?>
