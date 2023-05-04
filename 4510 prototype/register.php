<?php 
    session_start();

    // This part is used for handle function on createEvent.php.

    $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
    $otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : '';
    $UID = isset($_SESSION['UID']) ? $_SESSION['UID'] : '';

    if ((isset($_POST['gotoReg']) || isset($_POST['backtoHome']))) {
        $_SESSION['ename'] = $_POST['ename'];
        $_SESSION['host'] = $_POST['host'];
        $_SESSION['location'] = $_POST['location'];
        $_SESSION['capacity'] = $_POST['capacity'];
        $_SESSION['cost'] = $_POST['cost'];
        $_SESSION['external'] = $_POST['external'];
        $_SESSION['description'] = $_POST['description'];

        if($_FILES["image"]["size"] == 0 ) {
            $_SESSION['image'] = "noimg" ;
        } else {
            $temp_name = uniqid("IMG_", true) . "." . strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $target_file = "img_uploads/". $temp_name;
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            $_SESSION['image'] = $target_file;
        }



        if (isset($_POST['gotoReg']) && $UID >= 1) {     // check if user logined, if so, skip this page by using header
            header("Location: preview.php");
        } 
        else if (isset($_POST['backtoHome'])) {
            header("Location: homepage.php"); 
        }
    }


?>
<html>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Register as an user</title>
</head>
<body id="event">
<div class="content" id="content_event">
    <h1>Register as an user</h1>
    <hr>
    <h3 class="remind">**Fields other than should not be empty and the length of password must be 4 or more.</h3>
    <form method="POST" action="preview.php">
        <label for="name">Name: </label>
        <input id="name" type="text" name="name" placeholder="Your Name" value="<?php echo($name);?>"/>
        <br><br>

        <label for="phone">Phone No.: </label>
        <input id="phone" type="number" name="phone" placeholder="Your Phone No." max="99999999" value="<?php echo($phone);?>"/>
        <br><br>

        <label for="otp">One-time password: </label>
        <input id="otp" type="password" name="otp" placeholder="Your password" value="<?php echo($otp);?>"/>
        <br><br>

        <!-- form action type field -->

        <div class="mid">
        <input type="submit" name="back" id="btn-back" value="Back"/>
        <input type="submit" name="submit" id="btn-submit" value="Next Step"/>

        </div>
        <hr>
        <div class="msg">
        <?php
        if (isset($_POST['gotoReg'])) {
        $noempty = true;
        if (empty($_POST['ename']) || empty($_POST['host']) || empty($_POST['location']) ||
            empty($_POST['capacity']) || ($_POST['cost']) < 0 || empty($_POST['description']))
            $noempty = false;


        if ($noempty == false && isset($_POST['gotoReg'])) {
            $_SESSION['evemsg'] = "<b class=\"remind\"> Notice: All field should not be empty except External Link and Image.</b>";
            header("Location: createEvent.php"); 
        }
        }

        if (isset ($_SESSION['regmsg']) ) {
            echo $_SESSION['regmsg'];
            $_SESSION['regmsg'] = '';
        }
        ?>
        </div>
    </form>
    </div>
</body>
</html>