<html>
<?php 

session_start();
$UID = isset($_SESSION['UID']) ? $_SESSION['UID'] : '';
?>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Joined event"</title>
</head>
<body id="homepage">
    <div class="content" id="content_homepage">
    <a href="index.php" class="indexlink"><h1 style="float:left;margin-left:10%;">UNIR</h1></a><br>
    
    <?php if ($UID > 1) {
        echo "<div class=\"username\">Welcome, " . $_SESSION['username'] . "!</div><br>";
    } else if ($UID == 1) {
        echo "<div class=\"username\">Welcome, Admin!</div><br>";
    } ?>
    <br>
    <?php if ($_SESSION['UID'] >  1) {
        echo "<a href=\"management_heldevent.php\" class=\"link\">Manage created event</a>";
    } else if ($_SESSION['UID'] ==  1) {
        echo "<a href=\"management_heldevent.php\" class=\"link\">Manage all event</a>";
    }
    ?>
    <br><br>
    <h3 class="mid">Joined event<br></h3>
    <hr>

    <form method="POST" action="session.php">
    <div class="resultarea">
        <?php
        $dbmsg="";
        include_once "db.php";
        $slsuid = $_SESSION['UID'];

            $slstmt = "SELECT Events.* FROM Events INNER JOIN Records ON Events.EID = Records.EID
                    WHERE Records.UID = '$slsuid' ORDER BY eid ASC";

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
                    "<input type=\"hidden\" name=\"hid\" value=\"" . $row["Eid"] . "\">" . 
                    "<b>EventID: </b>" . $row["Eid"] . "<br>" . 
                    " <b>Event Name: </b>" . $row["EName"] . "<br>" .  
                    " <b>Host: </b>" . $row["Host"] . "<br>" .
                    " <b>Location: </b>" . $row["Location"] . "<br>" . 
                    " <b>Attendance: </b>" . $totalattend . "/" . $row["Capacity"] .  "&nbsp&nbsp&nbsp&nbsp".
                    " <b>Cost: </b>HKD$ " . $row["Cost"] . "<br>"  .
                    " <b>External link: </b>" . $row["Externallink"] . "<br>" .  
                    " <b>Description: </b>" . $row["Description"] . "<br>";

                $dbmsg = $dbmsg . "<br><a href=\"session.php?quiteid=" . $row["Eid"] ."\" name=\"quit\" class=\"link\">
                    Quit from this event</a><br><hr></div>";
                

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
        <div class="mid">
        <input type="submit" name="back" id="btn-back" value="Back"/>
        </div>
    </div>
    </form>
</body>
</html>