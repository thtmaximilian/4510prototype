<html>
<?php 

session_start();

?>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Join event</title>
</head>
<body id="homepage">
    <div class="content" id="content_homepage">
    <a href="index.php" class="indexlink"><h1 style="float:left;margin-left:10%;">UNIR</h1></a><br>
    <br><br><br>
    <hr>
    <h3 class="mid">Details<br></h3>

    <form method="POST" action="session.php">
    <hr>
    <div class="resultarea">
        <?php
        if ($_SESSION['UID'] < 1) {
            $_SESSION['logmsg'] = "<b class=\"remind\"> Notice: Please login before join event.</b>";
            header('Location: login.php');
        } else {
            $dbmsg="";
            include_once "db.php";
            $joinId = $_GET['eid'];
            $_SESSION['eventSelected'] = $joinId;
            $slstmt = "SELECT * FROM Events WHERE EID ='$joinId'";
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
                        " <b>Description: </b>" . $row["Description"] . "<br>" . 
                        "<input type=\"submit\" style=\"float: right; margin-right: 3%\" name=\"join\" value=\"Join this event\" /> 
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
            if (isset ($_SESSION['joinmsg']) ) {
                echo $_SESSION['joinmsg'];
                $_SESSION['joinmsg'] = '';
            }
        }
        ?>
        <div class="mid">
        <input type="submit" name="back" id="btn-back" value="Back"/>
        </div>
    </div>
    </div>
    </form>
</body>
</html>