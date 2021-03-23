<?php

// Local Connection
// $serverName = "localhost";
// $dBUsername = "root";
// $dBPassword = "";
// $dBName = "phpEZdriveDB";

// Remote Connection
$serverName = "mydbinstance.caljktyiwpcp.us-east-2.rds.amazonaws.com";
$dBUsername = "master";
$dBPassword = "password";
$dBName = "ezdrive";

$serverName = "localhost";
$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Conncection failed: " . mysqli_connect_error());
}