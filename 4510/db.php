<?php

$dbhost = "localhost"; // Host name
$dbusername = "root"; // User name
$dbpassword = ""; // User password
$databasename = "UNIR4510"; // Database name

// mysqli (procedure) - start
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $databasename);

// Check connection
if (!$conn) {
      die("Sorry! Error occured: " . mysqli_connect_error());
}

// Code for Create Database and Create Table, and insert some test data (If needed)
/*
    DROP SCHEMA IF EXISTS UNIR4510;

    CREATE SCHEMA UNIR4510;
    USE UNIR4510;

    CREATE TABLE Users (
        Uid INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(50) NOT NULL,
        Phone CHAR(8) NOT NULL,
        OTP VARCHAR(50) NOT NULL,
        PRIMARY KEY(Uid)
    );

    CREATE TABLE Events (
        Eid INT NOT NULL AUTO_INCREMENT,
        EName VARCHAR(50) NOT NULL,
        Host VARCHAR(50) NOT NULL,
        Location VARCHAR(100) NOT NULL,
        Capacity INT(4) NOT NULL,
        Cost INT(5) NOT NULL,
        Externallink VARCHAR(500) DEFAULT "No external link provided.",
        Description VARCHAR(500) NOT NULL,
        Uid INT NOT NULL,
        Iid INT NOT NULL,
        PRIMARY KEY(Eid),
        FOREIGN KEY(Uid) REFERENCES Users(Uid)
    );

    CREATE TABLE Records (
        Rid INT NOT NULL AUTO_INCREMENT,
        Uid INT NOT NULL,
        Eid INT NOT NULL,
        PRIMARY KEY(Rid),
        FOREIGN KEY(Uid) REFERENCES Users(Uid),
        FOREIGN KEY(Eid) REFERENCES Events(Eid)
    );

    CREATE TABLE Invitations (
        Invid INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(50) NOT NULL, 
        Email VARCHAR(100) NOT NULL,
        Status ENUM('Attending', 'Not_attending', 'Considering') NOT NULL,
        Eid INT NOT NULL,
        PRIMARY KEY(Invid)
    );

    INSERT INTO Users (Name, Phone, OTP) VALUES 
    ("Admin", "99999999", "pass"),
    ("Max", "87654321", "pass"),
    ("Leon", "12345678", "pass"),
    ("Chris", "55554321", "pass");

    INSERT INTO Events (EName, Host, Location, Capacity, Cost, Externallink, Description, Uid, Iid) VALUES
    ("Birthday party", "Max", "My home", 10, 100, "https://www.youtube.com/watch?v=dQw4w9WgXcQ", "Actually, it is not my birthday yet. The cake is a lie.", 2, 1),
    ("Spain party", "Leon", "Some village", 50, 10000, "https://www.youtube.com/watch?v=CjnPHlIei48", "I heard that even the daughter of the US President came!", 3, 2);

    INSERT INTO Events (EName, Host, Location, Capacity, Cost, Description, Uid, Iid) VALUES
    ("Racoon city tours", "Albert", "Racoon city", 2, 0, "Albert invited us to join his party, what a generous man.", 4, 3);

    INSERT INTO Records (Uid, Eid) VALUES (2, 1);
    INSERT INTO Records (Uid, Eid) VALUES (2, 2);
    INSERT INTO Records (Uid, Eid) VALUES (3, 1);
    INSERT INTO Records (Uid, Eid) VALUES (4, 3);

    INSERT INTO Invitations (Name, Email, Status, Eid) VALUES ("Jacky", "jacky111@fakemail.com", "Attending", 2);
    INSERT INTO Invitations (Name, Email, Status, Eid) VALUES ("Mary", "mary999@fakemail.com", "Attending", 3);


*/

?>