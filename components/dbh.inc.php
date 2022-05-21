<?php

$serverName = "192.168.1.68";
$dBUsername = "ambroiselebs";
$dBPassword = "pipi";
$dBName = "arcadius";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
