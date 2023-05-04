<?php 
    session_start();

    $allValid = true;
    if (isset($_POST['submit'])) {
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['phone'] = $_POST['phone'];
        $_SESSION['otp'] = $_POST['otp'];

        $noempty = true;
        foreach($_POST as $value) {
            if(empty($value)) {
                $noempty = false;
            }
        }

        $validInput = true;
        if (strlen($_POST['otp']) < 4) {
                $validInput = false;
        }

        if (($noempty == false || $validInput == false)) {
                $allValid = false;
        }
    }
?>
<html>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Preview</title>
</head>
<body id="event">
<div class="content" id="content_event">
    <h1>Preview</h1>
    <hr>
    <form method="POST" action="session.php" class="mid">
    <h4 class="remind">If the information are correct, please click "Confirm" to submit. <br>
    If there are incorrect information, please click "Edit" for edit.</h4> .
    <?php

        if ($_SESSION['image'] == "noimg") {
            echo '<img src="img_uploads/0.jpg" width="128" height="128" class="mid"><br>';
        } else {
            echo '<img src="' . $_SESSION['image'] . '" width="128" height="128" class="mid"><br>';
        }

        echo "<b>Event name:</b> " . $_SESSION['ename'] . "<br>" .
        "<b>Host:</b> " . $_SESSION['host'] . "<br>" .
        "<b>Location</b> " . $_SESSION['location'] . "<br>" .
        "<b>Capacity:</b> " . $_SESSION['capacity'] . "<br>" .
        "<b>Cost:</b> " . $_SESSION['cost'] . "<br>" .
        "<b>External Link:</b> " . $_SESSION['external'] . "<br>" .
        "<b>Description:</b> " . $_SESSION['description'] . "<br>";
        if (($allValid == true || $_SESSION['UID']>=1) && isset($_POST['submit'])) {

                 include_once("db.php");
                 $name = $_SESSION['name'];
                 $phone = $_SESSION['phone'];
                 $otp = $_SESSION['otp'];
                 
                 $checkReged = "SELECT * FROM Users WHERE name = '$name'";
                 $crresult = mysqli_query ($conn, $checkReged);
                 if (mysqli_num_rows ($crresult) > 0) {
                    $_SESSION['regmsg'] = "<b class=\"remind\"> Notice: This username already exists.</b>";
                    header("Location: register.php");
                 } else {
                    $regsql = "INSERT INTO Users (Name, Phone, OTP) VALUES ('". $name . "','". $phone . "','" . $otp .  "' )";
                    $result = mysqli_query($conn, $regsql);
                    $uidsql = "SELECT UID FROM Users WHERE Name = '$name'";
                    $uidresult = mysqli_query ($conn, $uidsql);
                    $row = mysqli_fetch_array($uidresult, MYSQLI_NUM);
				    $_SESSION['UID'] = $row[0];
                 }
                 mysqli_close($conn);
        } else if (isset($_POST['back'])) {
            header("Location: createEvent.php");
        }
        else if ($allValid != true) {
            $_SESSION['regmsg'] = "<b class=\"remind\"> Notice: All field should not be empty, 
                                    and the length of password should be 4 or more.</b>";
            header("Location: register.php");
        }
    ?>
    <br>
    <input type="submit" name="backtoEve" value="Edit"/>
    <input type="submit" name="confirm" value="Confirm"/>
    <hr>
    </form>
    </div>
</body>
</html>