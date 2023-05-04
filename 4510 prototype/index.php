<?php
	$noempty = true;
	foreach($_POST as $value) {
		if(empty($value)) {
			$noempty = false;
		}
	}

	// handle rsvp submission

	if (isset($_POST['btnsubmit']) && $noempty ){
		$rsvpname = $_POST['rsvpname'];
		$rsvpmail = $_POST['rsvpmail'];
		$rsvpstatus = $_POST['status'];
		$rsvpeid = $_POST['rsvpeid'];

		include_once("db.php");
		$sql = "INSERT INTO Invitations (Name, Email, Status, Eid) VALUES ('". $rsvpname . "','". $rsvpmail . "','" . $rsvpstatus . "','" . $rsvpeid . "' )";
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
	} else if (isset($_POST['btnsubmit']) && !$noempty) {
		header("Location: rsvp.php"); 
	}

?>
<html>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>UNIR</title>
</head>
<body id="homepage">
    <div class="content center" id="content_homepage">
	<h1>Welcome to UNIR</h1>
	<div>
		<button class="indexbtn" onclick="location.href='homepage.php'"><span>Homepage</span></button>
	</div>
	<div>
		<button class="indexbtn" onclick="location.href='login.php'"><span>User Information</span></button>
	</div>
	<div>
		<button class="indexbtn" onclick="location.href='https://www.linkedin.com/in/elvanyau/?originalSubdomain=hk'"><span>About Us</span></button>
    </div>
</div>
</body>
</html>