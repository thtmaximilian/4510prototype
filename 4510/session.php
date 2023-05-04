<?php

// Handle session from multiple pages

session_start();
	
	// Do something after confirmed within prewview page
	if (isset($_POST['confirm'])) {

		// Add record to database
		include_once "db.php"; // Contains information of database and $conn

		$ename = $_SESSION["ename"]; $host = $_SESSION["host"]; $location = $_SESSION["location"];
		$capacity = $_SESSION["capacity"]; $cost = $_SESSION["cost"]; $external = $_SESSION["external"];
		$description = $_SESSION["description"]; $UID = $_SESSION["UID"];

		// INSERT INTO Events (EName, Host, Location, Capacity, Cost, Externallink, Description, Uid ,Iid)
		// Iid will temporarily be 0, indicating that using a default image.
		$stmt = "insert into Events(Ename,Host,Location,Capacity,Cost,Externallink,Description,Uid,Iid)
		values('" . $ename . "','" . $host . "','" . $location . "','" . $capacity . "','" . 
					$cost . "','" . $external . "','" . $description . "','" . $UID . "', 0)";

		$result = mysqli_query($conn, $stmt);


		// Update the Iid if user did upload an image
		if ($_SESSION['image'] != "noimg") {
			$eid = mysqli_insert_id($conn);

			$source_file = $_SESSION['image'];
			$target_dir = "img_uploads/";
			$target_file = $target_dir . $eid . ".jpg";
			rename($source_file, $target_file);
			
			$updatestmt = "UPDATE Events SET Iid = ". $eid ."  WHERE eid =" . $eid;
			mysqli_query($conn, $updatestmt);
		}

		mysqli_close($conn);

		// unset all session except UID (to remain login)
		unset($_SESSION["ename"], $_SESSION["host"], $_SESSION["location"], $_SESSION["capacity"],
			  $_SESSION["cost"], $_SESSION["external"], $_SESSION["description"],
			  $_SESSION["name"], $_SESSION["phone"], $_SESSION["otp"], $_SESSION["image"], $_SESSION['username']);
	} 

	if (isset($_GET['logout'])) {
		$_SESSION['UID'] = '';
		$_SESSION['username'] = '';
		header('Location: homepage.php');
	}

	// Go other page according to conditions, default: homepage
	// handle the Login function
	if (isset($_POST['backtoEve'])) header('Location: createEvent.php');
	else if(isset($_POST['btnlog'])) {
		include_once "db.php";
		$uname = $_POST['logname']; $upass = $_POST['logpass'];
		$checksql = "SELECT UID, Name FROM Users WHERE Name = '$uname' AND OTP = '$upass'";
		$checkresult = mysqli_query ($conn, $checksql);
		if (mysqli_num_rows ($checkresult) > 0) {
				$row = mysqli_fetch_array($checkresult, MYSQLI_NUM);
				$_SESSION['UID'] = $row[0];
				$_SESSION['username'] = $row[1];
				header('Location: homepage.php');
		 } else {
			$_SESSION['logmsg'] = "<b class=\"remind\"> Notice: Login name or password error.</b>";
			header('Location: login.php');
		 }
		mysqli_close($conn);
	} 
	// Use GET to remove record from Records, removing the record of specific user
	else if (isset($_GET['quiteid'])) {
		include_once "db.php";
		$uid = $_SESSION['UID'];
		$eid = $_GET['quiteid'];
		$quitsql = "DELETE FROM Records WHERE uid = '$uid' and eid = '$eid'";
		mysqli_query($conn, $quitsql);
		mysqli_close($conn);
		header('Location: management.php?eid=' . $eid);
	} 
	// Use GET to remove record from Events (and records), removeing the whole event
	else if (isset($_GET['removeeid'])) {
		include_once "db.php";
		$eid = $_GET['removeeid'];
		$removerecord = "DELETE FROM Records WHERE eid = '$eid'";
		$removeevent = "DELETE FROM Events WHERE eid = '$eid'";
		mysqli_query($conn, $removerecord);
		mysqli_query($conn, $removeevent);
		mysqli_close($conn);
		header('Location: management_heldevent.php?eid=' . $eid);
	} 
	// Join the event
	else if (isset($_POST['join'])) {
		$uid = $_SESSION['UID'];
		$eventSelected =  $_SESSION['eventSelected'];
		include_once "db.php";
		$checkJoined = "SELECT * FROM Records WHERE eid = '$eventSelected' and uid ='$uid'";
		$cjresult = mysqli_query ($conn, $checkJoined);

		$checkCapcity = "SELECT Capacity FROM Events WHERE eid = '$eventSelected' ";
		$ccresult = mysqli_query ($conn, $checkCapcity);
		$ccrow = mysqli_fetch_assoc($ccresult);
		$ccNum = $ccrow['Capacity'];

		$attendsql = "SELECT COUNT(DISTINCT UID) as count FROM Records WHERE Eid ='$eventSelected'";
		$attendnum = mysqli_query ($conn, $attendsql);
		$attendrow = mysqli_fetch_array($attendnum);

		$invitesql = "SELECT COUNT(DISTINCT InvID) as count FROM Invitations WHERE Status ='Attending' AND Eid = '$eventSelected'";
		$invitenum = mysqli_query ($conn, $invitesql);
		$inviterow = mysqli_fetch_array($invitenum);

		$totalattend = $attendrow['count'] + $inviterow['count'];

		if (mysqli_num_rows ($cjresult) > 0) {
			$_SESSION['joinmsg'] = "<b class=\"remind\"> Notice: You already joined this event.</b>";
			mysqli_close($conn);
			header('Location: joinevent.php?eid=' . $eventSelected);
		} else if (mysqli_num_rows ($cjresult) == 0 && ($totalattend >= $ccNum)) {
			$_SESSION['joinmsg'] = "<b class=\"remind\"> Notice: This event is already full.</b>";
			mysqli_close($conn);
			header('Location: joinevent.php?eid=' . $eventSelected);
		} else {
			$joinevent = "insert into Records (Uid, Eid) VALUES (". $uid .",". $eventSelected .")";
			$joinresult = mysqli_query($conn, $joinevent);
			mysqli_close($conn);
			header('Location: homepage.php');
		}
	}
	// Back to last page
	else if (isset($_POST['heldeventback'])) header('Location: management.php');
	else header('Location: homepage.php');

?>