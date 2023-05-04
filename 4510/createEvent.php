<?php 
session_start();

    $ename = isset($_SESSION['ename']) ? $_SESSION['ename'] : '';
    $host = isset($_SESSION['host']) ? $_SESSION['host'] : '';
    $location = isset($_SESSION['location']) ? $_SESSION['location'] : '';
    $capacity = isset($_SESSION['capacity']) ? $_SESSION['capacity'] : '';
    $cost = isset($_SESSION['cost']) ? $_SESSION['cost'] : '';
    $external = isset($_SESSION['external']) ? $_SESSION['external'] : '';
    $description = isset($_SESSION['description']) ? $_SESSION['description'] : '';

    if(isset($_SESSION['image']) && $_SESSION['image'] != "noimg") {
        $temppath = $_SESSION['image'];
        unlink($temppath);
        $_SESSION['image'] = "";
    }
?>
<html>
<head>
<link rel="stylesheet" href="Style.css" type="text/css"/>
<title>Create Event</title>
</head>
<body id="event">
<div class="content" id="content_event">
    <h1>Create Event</h1>
    <hr>
    <h3 class="remind">**Fields other than External link and Image cannot be empty.</h3>
    <form method="POST" enctype="multipart/form-data" action="register.php">

        <label for="ename">Event Name: </label>
        <input id="ename" type="text" name="ename" placeholder="Event Name" value="<?php echo($ename);?>"/>
        <br><br>

        <label for="host">Host Name: </label>
        <input id="host" type="text" name="host" placeholder="Host Name" value="<?php echo($host);?>"/>
        <br><br>

        <label for="location">Location: </label>
        <input id="location" type="text" name="location" placeholder="Address" 
        size="50" value="<?php echo($location);?>"/>
        <br><br>

        <label for="capacity">Max Capacity: </label>
        <input id="capacity" type="number" name="capacity" maxlength="9999" 
        placeholder="Capacity" value="<?php echo($capacity);?>"/> 
        <br><br>

        <label for="cost">Cost: HKD$</label>
        <input id="cost" type="number" name="cost" max="99999" 
        placeholder="Can be 0" value="<?php echo($cost);?>"/>
        <br><br>

        <label for="external">External link: </label>
        <input id="external" type="text" name="external" 
        placeholder="Optional" value="<?php echo($external);?>"/>
        <br><br>

        <label for="image">Image: </label>
        <input type="file" name="image" accept=".jpg,.jpeg"/>
        <br><br>

        <label for="description">Description: </label>
        <input id="description" name="description" placeholder="Provide more information about the event" 
        size="50" value="<?php echo($description);?>"/>
        <br><br>

        <!-- form action type field -->

        <div class="mid">
        <input type="submit" name="backtoHome" id="btn-back" value="Back"/>
        <input type="submit" name="gotoReg" id="btn-submit" value="Next Step"/>
        </div>
        <br>

        <hr>
        <div class="msg">
        <?php
        if ( isset ($_SESSION['evemsg']) ) {
            echo $_SESSION['evemsg'];
            $_SESSION['evemsg'] = '';
        }
        ?>
        </div>
    </form>
    </div>
</body>
</html>