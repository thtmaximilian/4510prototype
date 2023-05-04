<?php 
    session_start();
    if (!empty($_SESSION['UID'])) {
        header("Location: management.php");
    }
?>
<html>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Login</title>
</head>
<body id="event">
<div class="content" id="content_event">
    <h1>Login</h1>
    <hr>
    <h3 class="remind"></h3>
    <form method="POST" action="session.php">
        <label for="name">User name: </label>
        <input id="name" type="text" name="logname" placeholder="Your Name"/>
        <br><br>

        <label for="otp">Password: </label>
        <input id="otp" type="password" name="logpass" placeholder="Your password"/>
        <br><br>

        <!-- form action type field -->

        <div class="mid">
        <input type="submit" name="btnlog" id="btn-submit" value="Login"/>
        <input type="submit" name="back" id="btn-back" value="Back"/>

        </div>
        <hr>
        <div class="msg">
        <?php

        if (isset ($_SESSION['logmsg']) ) {
            echo $_SESSION['logmsg'];
            $_SESSION['logmsg'] = '';
        }
        ?>
        </div>
    </form>
    </div>
</body>
</html>