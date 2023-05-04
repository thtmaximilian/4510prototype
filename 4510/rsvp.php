<?php 
    session_start();
?>
<html>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>RSVP</title>
</head>
<body id="event">
<div class="content" id="content_event">
    <h1>RSVP</h1>
    <hr>
    <h3 class="remind">* All options must be filled in.</h3>
    <form method="POST" action="index.php">
        <input type="hidden" name="rsvpeid" value="<?php echo $_GET['eid'];?>">

        <label for="rsvpname">Your Name: </label>
        <input id="rsvpname" type="text" name="rsvpname" placeholder="Your Name"/>
        <br><br>

        <label for="rsvpmail">Your Email: </label>
        <input id="rsvpmail" type="email" name="rsvpmail" placeholder="Your Email"/>
        <br><br>

        <label>Your status: </label>
        <label><input type="radio" name="status" value="Attending" checked>Attending</label>
        <label><input type="radio" name="status" value="Not_attending">Not Attending</label>
        <label><input type="radio" name="status" value="Considering">Considering</label>
        <br><br>

        <label>You can copy this RSVP link to invite people: </label>
        <label><input type="text" value="<?php echo "http://localhost/4510/rsvp.php?eid=" . $_GET['eid'];?>" size="30"></label>
        <br><br>
        <!-- form action type field -->

        <div class="mid">
        <input type="button" name="btnclose" id="btn-close" value="Close" onclick="window.close();"/>
        <input type="submit" name="btnsubmit" id="btn-submit" value="Submit" />


        </div>
        </div>
    </form>
    </div>
</body>
</html>