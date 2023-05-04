<html>
<?php 

session_start();

?>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title><?php if ($_SESSION['UID'] == 1) echo "Manage All Event"; else echo "Manage Created Event";  ?></title>
</head>
<body id="homepage">
    <div class="content" id="content_homepage">
    <a href="index.php" class="indexlink"><h1 style="float:left;margin-left:10%;">UNIR</h1></a><br>
    <br><br><br>
    <h3 class="mid"><?php if ($_SESSION['UID'] == 1) echo "Manage All Event"; else echo "Manage Created Event";  ?><br></h3>
    <hr>

    <form method="POST" action="session.php">
    <div class="resultarea">
        <?php
        $dbmsg="";
        include_once "db.php";
        $slsuid = $_SESSION['UID'];
        if ($slsuid == 1) {
            $slstmt = "SELECT * FROM Events ORDER BY eid ASC";
        } else {
            $slstmt = "SELECT * FROM Events WHERE UID = '$slsuid' ORDER BY uid ASC";
        }
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

                $dbmsg = $dbmsg . "<br><a href=\"session.php?removeeid=" . $row["Eid"] ."\" name=\"remove\" class=\"link\"> 
                    Remove this event</a><br><hr></div>";

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
        <input type="submit" name="heldeventback" id="btn-heldeventback" value="Back"/>
        </div>
    </div>
    </form>
</body>
</html>