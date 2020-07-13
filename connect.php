<?php
$servername = "ec2-46-137-124-19.eu-west-1.compute.amazonaws.com";
$username = "atortuulxmovtg";
$password = "85f9b2b3be752b8c59218a1dd28c19f026488750c4a77d18054a95627f66810b";
$dbname = "d79rdvlg8o4982";
$conn = new mysqli($servername, $username, $password, $dbname, '5432');
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
?>
