<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "book_borrowing_system";
if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
	die("Failed to connect");
}

?>