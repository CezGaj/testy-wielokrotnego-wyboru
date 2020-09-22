<?php
$host="localhost";
$user="id14932264_id7875961_admin";
$pass="jTK(RXPx/-hrP7H(";
$dbname="id14932264_wyniki";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
?>