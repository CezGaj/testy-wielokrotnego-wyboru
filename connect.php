<?php
$servername = parse_url(getenv('DATABASE_URL'));
$username = "atortuulxmovtg";
$password = "85f9b2b3be752b8c59218a1dd28c19f026488750c4a77d18054a95627f66810b";
$dbname = "d79rdvlg8o4982";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
?>
