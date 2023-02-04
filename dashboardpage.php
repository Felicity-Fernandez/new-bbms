<?php
session_start();
@include 'db_link.php';
@include 'signup.php';
$userdata = check_login($conn);


?>
<?php
				if (isset($_GET['id'])) {
					$id=$_GET['id'];
					$sel = "UPDATE borrowing_acts SET req_sent = '1' WHERE stud_num='{$_SESSION["stud_num"]}' AND id='$id'";
					$res = mysqli_query($conn, $sel);
					header("location:dashboardpage.php");
					die();
				}
				?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/dstyle.css">
</head>
<body>
	<div class="wrapper">
		<div class="sidebar-header">
			<div class="sidebar">
				<div class="icn"><img src="book.png"></div>
			<center>
			<img src="imagesfold/<?php echo $userdata["pic"]; ?>" width= "100px" height= "100px" alt="">
			<br>
			<h2><?php echo $userdata['first_name'], ' ', $userdata['last_name'];?> </h2>
			<br>
				<a href="profile.php" class="edit">Edit Profile</a>
		</center>
		<br>
		<ul>
		<li><i class="las la-id-badge"></i><a href="#"><?php echo $userdata['stud_num'];?></a></li>
		<li><i class="las la-id-badge"></i><a href="#"><?php echo $userdata['year'], '-', $userdata['section'];?> </a></li>
		<li><i class="las la-id-badge"></i><a href="#"><?php echo $userdata['course'];?></a></li>
		<li><i class="las la-id-badge"></i><a href="#"><?php echo $userdata['department'];?></a></li>
		<li><i class="las la-sign-out-alt"></i><a href="logout.php">Logout</a></li>
		</ul>
		<span class="backicn"><i class="las la-angle-left"></i></span>		
			</div>
			<div class="backdrop"></div>
			<?php
				$sel = "SELECT*FROM borrowing_acts WHERE stud_num='{$_SESSION["stud_num"]}'";
				$res = mysqli_query($conn, $sel);
				if (mysqli_num_rows($res) > 0) {
					$sel = "SELECT*FROM borrowing_acts WHERE stud_num='{$_SESSION["stud_num"]}' AND status=0";
					$res = mysqli_query($conn, $sel);
					$count = mysqli_num_rows($res);
				}else{
					$count = '0';
				}
				
			?>
			<div class="content">
				
				<header>
					<div id="mobile" class="profilebtn">
						<i class="las la-user-circle"></i>
					</div>
					<div id="desktop" class="profilebtn">
						<i class="las la-user-circle"></i>
					</div>
					<h1>Book Borrowing System</h1>
					<div class="notif" onclick="toggleNotif()">
						<i class="las la-bell"><span class="las la-exclamation" id="count"><?php echo $count ?></span></i>
					</div>
					<?php
				//if (isset($_GET['id'])) {
					//$ids=$_GET['id'];
					//$sel = "UPDATE borrowing_acts SET status = '1' WHERE stud_num='{$_SESSION["stud_num"]}' AND id='$ids'";
					//$res = mysqli_query($conn, $sel);
					//header("location:dashboardpage.php");
					//die();
				//}
				?>
					<div class="notifbox" id="box">
						<h2>Notifications  <a href='#' class='las la-times'></a></h2>
						<div class="notifitem">
							<div class="text">
								
								<?php
								$sel = "SELECT*FROM borrowing_acts WHERE stud_num='{$_SESSION["stud_num"]}' AND noti=0 AND status=0 AND status=0 ORDER BY return_date ASC";
	$res = mysqli_query($conn, $sel);
	//$row = mysqli_fetch_array($res);
	if (mysqli_num_rows($res) > 0) {
		while ($row = $res->fetch_assoc()) {
			date_default_timezone_set('Asia/Manila');
			
                        $curdate = date('Y-m-d');
			 if ($curdate <= $row['return_date']) {
					echo '
					<hr>
			<li>
			<a href="#" class="text">
			<h4>
			<strong>You have book(s) to return before the due date.</strong><br>
			<small><em>Hello ' . $row["b_first_name"] . ', you have borrowed ' . $row["book_title"] . ' to return only until ' . $row["return_date"] . '</em></small>
			</h4></a>
			</li>';
			//}elseif ($DDT < $CD) {
				//echo "<hr><li style='color: red;'>Past due date <a href='dashboardpage.php?id=".$row['id']."' class='las la-times'></a></li>";
			//}
                        }elseif ($curdate > $row['return_date']) {
                        	
						echo "<hr><li style='color: red;'>Past due date</li>";
			}
		}
	}else{
		echo '
		<li><a href="#" class="text">No Notifications Found</a></li>';
	}
								?>
							</div>
						</div>
					</div>
				</header>
				
				<div class="data">
					<h2>Dashboard</h2>
					<div class="listtable">
					<div class="list">
						<h1>Currently Borrowed Books</h1>
						<table class="tab">
							<thead>
								<tr>
									<th>Book Title</th>
									<th>Date Borrowed</th>
									<th>Due Date</th>
									<th>Request Renewal</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sel = "SELECT*FROM borrowing_acts WHERE stud_num='{$_SESSION["stud_num"]}' AND status=0 AND req_sent=0";
								$res = mysqli_query($conn, $sel);
								if (mysqli_num_rows($res) > 0) {
								while ($row = $res->fetch_assoc()) {
									echo "<tr>
									<td data-label='Book Title'>" . $row['book_title'] . "</td>
									<td data-label='Date Borrowed'>" . $row['date_borrowed'] . "</td>
									<td data-label='Due Date'>" . $row['return_date'] . "</td>
									<td data-label='Request Renewal'>
										<a href='dashboardpage.php?id=".$row['id']."'class='ren' >Renew</a>
									</td>
								</tr>";
								}
							}else{
								echo '
								<td><h5>No </h5></td>
								<td><h5>Currently </h5></td>
								<td><h5>Borrowed </h5></td>
								<td><h5>Books</h5></td>';
							}
								
								
								?>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="listtable">
					<div class="list">
						<h1>Violations</h1>
						<table class="tab">
							<thead>
								<tr>
									<th>Violation</th>
									<th>Book Title</th>
									<th>Return Date</th>
									<th>Penalty Fee P5/day</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sel = "SELECT*FROM violators WHERE stud_num='{$_SESSION["stud_num"]}' AND returned = 0";
								$res = mysqli_query($conn, $sel);
								if (mysqli_num_rows($res) > 0) {
								while ($row = $res->fetch_assoc()) {
									$d= strtotime($row['Return_date']);
									$c= strtotime(date("Y-m-d"));
									$diff= $c-$d;

									if($diff>=0){
										$day= floor($diff/(60*60*24));
									}
									echo "<tr>";
									if ($row['Lost'] == 1) {
               	 						echo "<td data-label='Violation'>Damaged/Lost</td>
               	 						<td data-label='Book Title'>". $row['Book_title'] . "</td>
               	 						<td data-label='Return Date'>". $row['Return_date']."</td>";

            						} else {
                						echo "<td data-label='Violation'>Late Return</td>
                						<td data-label='Book Title'>". $row['Book_title'] . "</td>
                						<td data-label='Return Date'>". $row['Return_date']."</td>
                						<td data-label='Penalty Fee P5/day'> P ".($day*5)."</td>";
            						}
								}
							}else{
								echo '
								<td data-label="Violation"><h5>No Violations</h5></td>';
							}

								
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="listtable">
					<div class="list">
						<h1>Renewal Request</h1>
						<table class="tab">
							<thead>
								<tr>
									<th>Student Number</th>
									<th>Student Name</th>
									<th>Book Title</th>
									<th>Due Date</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sel = "SELECT*FROM borrowing_acts WHERE stud_num='{$_SESSION["stud_num"]}' AND req_sent = '1'";
								$res = mysqli_query($conn, $sel);
								if (mysqli_num_rows($res) > 0) {
								while ($row = $res->fetch_assoc()) {
									echo "<tr>
									<td data-label='Student Number'>" . $row['stud_num'] . "</td>
									<td data-label='Student Name'>" . $row['b_first_name'] . " ".$row['b_last_name']."</td>
									<td data-label='Book Title'>" . $row['book_title'] . "</td>
									<td data-label='Due Date'>" . $row['return_date'] . "</td>
								</tr>";
								}
							}else{
								echo '
								<td><h5>No Request</h5></td>';
							}

								
								?>
							</tbody>
						</table>
					</div>
				</div>
				</div>
				
				</div>
				
			</div>
		</div>
	</div>
	<script src="index.js"></script>
</body>
</html>