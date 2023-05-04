<html>
<?php 

session_start();
$UID = isset($_SESSION['UID']) ? $_SESSION['UID'] : '';
$_SESSION['EID'] = '';
?>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Homepage</title>
</head>
<body id="homepage">
    <div class="content" id="content_homepage">
    <a href="index.php" class="indexlink"><h1 style="float:left;margin-left:10%;">UNIR</h1></a><br><br>
    <?php if ($UID >=  1) {
        echo "<a href=\"session.php?logout=1\" class=\"link\">Log out</a>";
    }
    ?>
    <div id="Log"><?php 
        if ($UID >=  1) {
            echo "<a href=\"management.php\">Event management</a>";
        } 
        else 
            echo "<a href=\"login.php\">Login</a>";
    ?></div>
    <a href="createEvent.php" class="link">Create event</a>
    <br><br><br>
    <hr>
    <h3 class="mid">List of upcoming events<br></h3>

    <!-- Show the list of upcoming events -->
    <form method="POST" action="joinEvent.php">
    <hr>
    <div class="resultarea">
        <?php
        $dbmsg="";
        include_once "db.php";
        $slstmt = "SELECT * FROM Events ORDER BY eid ASC";
        $result = mysqli_query ($conn, $slstmt);

        // echo the results
        if (mysqli_num_rows ($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $attendsql = "SELECT COUNT(DISTINCT UID) as count FROM Records WHERE Eid =" . $row["Eid"];
                $attendnum = mysqli_query ($conn, $attendsql);
                $attendrow = mysqli_fetch_array($attendnum);

                $invitesql = "SELECT COUNT(DISTINCT InvID) as count FROM Invitations WHERE Status ='Attending' AND Eid = " . $row["Eid"];
                $invitenum = mysqli_query ($conn, $invitesql);
                $inviterow = mysqli_fetch_array($invitenum);

                $totalattend = $attendrow['count'] + $inviterow['count'];

                $imgid = 0; // 0 is default image
                if ($row["Iid"] > 0) {
                    $imgid = $row["Iid"];
                }
                $dbmsg = "";
                $dbmsg = $dbmsg . "<div class=\"shadow\">" . 
                    "<img src=\"img_uploads/" . $imgid .".jpg\" alt=\"Event picture\" width=\"128\" height=\"128\" style=\"float:left; margin-right:1%\">" .
                    "<b>EventID: </b>" . $row["Eid"] . "<br>" . 
                    " <b>Event Name: </b>" . $row["EName"] . "<br>" .  
                    " <b>Host: </b>" . $row["Host"] . "<br>" .
                    " <b>Location: </b>" . $row["Location"] . "<br>" . 
                    " <b>Attendance: </b>" . $totalattend . "/" . $row["Capacity"] .  "&nbsp&nbsp&nbsp&nbsp".
                    " <b>Cost: </b>HKD$ " . $row["Cost"] . "<br>"  .
                    " <b>External link: </b>" . $row["Externallink"] . "<br>" .  
                    // " <b>Externallink: </b> <a href =\"" . $row["Externallink"] . "\">External link</a><br>" . 
                    " <b>Description: </b>" . $row["Description"] . "<br>" . 

                    // Share btn
                    "<br> <a href='https://www.facebook.com' target='_blank'> <img src='icon/facebook.png' alt='Share through Facebook' class = 'iconbtn'> </a>".
                    "<a href='https://www.instagram.com' target='_blank'> <img src='icon/instagram.png' alt='Share through Instagram' class = 'iconbtn'> </a>".
                    "<a href='https://twitter.com/i/flow/login' target='_blank'> <img src='icon/twitter.png' alt='Share through Twitter' class = 'iconbtn'> </a>".
                    "<a href='rsvp.php?eid=". $row["Eid"] ."' target='_blank'> <img src='icon/mail.png' alt='Send a RSVP mail' class = 'iconbtn'> </a>".
                    "<br><a href=\"joinevent.php?eid=" . $row["Eid"] . "\" class=\"link\">Details</a>
                    <br><hr></div>";
                echo $dbmsg;
            } 
        }   
           else {
            $dbmsg = "<h3>There are no records.</h3>";
            echo $dbmsg;
        }

        // close connection
        mysqli_close($conn);
        ?>
    </div>
    </div>
    </form>
</body>
</html>