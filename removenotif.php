<?php
session_start();
@include 'db_link.php';
@include 'signup.php';
	$sel = "SELECT*FROM borrowing_acts WHERE stud_num='{$_SESSION["stud_num"]}' AND status=0";
	$res = mysqli_query($conn, $sel);
	if (mysqli_num_rows($res) > 0) {
		$sel = "UPDATE borrowing_acts SET status=1 WHERE stud_num='{$_SESSION["stud_num"]}' AND status=0";
		$res = mysqli_query($conn, $sel);
		header('location: dashboardpage.php');
	}
	header('location: dashboardpage.php');
?>