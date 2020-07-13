<html id="disp">
<head>
<meta charset="utf-8">
<title>Menadżer wyników</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<form action="edytor.php" method="post" autocomplete="off">
<fieldset>
<legend>Lista wynikowa:</legend>
<?php
$servername = "localhost";
$username = "id5804479_admin";
$password = "abcde";
$dbname = "id5804479_db";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST["deleteall"]))
{
$sql="TRUNCATE TABLE wyniki";
if ($conn->query($sql) === TRUE) 
{
    echo "Usunieto pomyslnie!".'<br>';
} 
else 
{
    echo "Błąd usuwania: " . $conn->error.'<br>';
}	
}

$sql="SELECT * FROM wyniki ORDER BY nr_indeksu asc";
$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
    $li=0;
    if(isset($_POST["sav"])) 
    {
        date_default_timezone_set('Europe/Warsaw');
        $t=date("Y-m-d-H-i-s");
        $plik=fopen("wyniki-$t.txt","w");
    }
    echo '<table class="table"><tr><th>numer indeksu</th><th>wynik</th></table>';
while($row = $result->fetch_assoc()) 
{
    $usuniete=false;
    if(isset($_POST["delet"])) 
    {
        $x=$row["nr_indeksu"];
        if(isset($_POST["$x"]))
        {
            $y=$_POST["$x"];
            $sql2="DELETE FROM wyniki WHERE nr_indeksu=$x AND wynik=$y";
            if($conn->query($sql2)!== TRUE) echo "Błąd usuwania: " . $conn->error.'<br>';
            else $usuniete=true; 
        }
    }
    if(isset($_POST["sav"])) fwrite($plik,$row["nr_indeksu"]." ".$row["wynik"]."\n");
    if($usuniete==false) echo '<div><input type="checkbox" id="'.$li.'" name="'.$row["nr_indeksu"].'" value="'.$row["wynik"].'"/><label for="'.$li.'"><table class="table"><tr><td>'.$row["nr_indeksu"].'</td><td>'.$row["wynik"].'</td></tr></table></label></div>'; 
    $li++;
}
    if(isset($_POST["sav"]))
    {
        fclose($plik);
        echo "<script>window.open('wyniki-$t.txt','_blank');</script>";
    }
}

$conn->close();
?>
</fieldset>
<br>
<div class="container-flush">
    <div class="row justify-content-center">  
        <div class="col-md-4"><center><input type="submit" class="btn btn-primary mb-2" name="deleteall" value="Usuń wszystko"/></center></div>
        <div class="col-md-4"><center><input type="submit" class="btn btn-primary mb-2" name="delet" value="Usuń zaznaczone"/></center></div>
        <div class="col-md-4"><center><input type="submit" class="btn btn-primary mb-2" name="sav" value="Zapisz do pliku"/></center></div>
    </div>
</div>
<br>
</form>
</body>
</html>