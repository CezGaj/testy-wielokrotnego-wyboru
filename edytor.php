<html id="disp">
<head>
<meta charset="utf-8">
<title>Menedżer wyników</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<script>
var lista = [];
</script>
<form action="edytor.php" method="post" autocomplete="off">
<fieldset>
<?php
require 'connect.php';
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

$sql="SELECT * FROM wyniki ORDER BY login asc";
$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
    $li=0;
    echo '<table class="table"><tr><th>login</th><th>wynik</th></table>';
while($row = $result->fetch_assoc()) 
{
    $usuniete=false;
    if(isset($_POST["delet"])) 
    {
        $x=$row["login"];
        if(isset($_POST["$x"]))
        {
            $y=$_POST["$x"];
            $sql2="DELETE FROM wyniki WHERE login=$x AND wynik=$y";
            if($conn->query($sql2)!== TRUE) echo "Błąd usuwania: " . $conn->error.'<br>';
            else $usuniete=true; 
        }
    }
    if($usuniete==false) 
	{
		echo '<div><input type="checkbox" id="'.$li.'" name="'.$row["login"].'" value="'.$row["wynik"].'"/><label for="'.$li.'"><table class="table"><tr><td>'.$row["login"].'</td><td>'.$row["wynik"].'</td></tr></table></label></div>'; 
		echo '<script>lista.push(['.json_encode($row["login"]).','.json_encode($row["wynik"]).']);</script>';
	}
    $li++;
}

}

$conn->close();
?>
</fieldset>
<br>
<div class="container-flush">
    <div class="row justify-content-center">  
        <input type="submit" class="btn btn-primary mb-2 col-md-4" name="deleteall" value="Usuń wszystko"/>
        <input type="submit" class="btn btn-primary mb-2 col-md-4" name="delet" value="Usuń zaznaczone"/>
        <button class="btn btn-primary mb-2 col-md-4" name="sav" onclick="zapisz();">Zapisz do pliku</button>
    </div>
</div>
<br>
</form>
<script>
function zapisz()
{
    var tekst = "";
    for(var i=0;i<lista.length;i++)
    {
        tekst += lista[i][0] + " " + lista[i][1] + "\n";   
    }
    var a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";
    var json = JSON.stringify(tekst);
    var blob = new Blob([tekst], {type: "text/plain;charset=utf-8"});
    var url = window.URL.createObjectURL(blob);
    a.href = url;
    a.download = "wyniki.txt";
    a.click();
    window.URL.revokeObjectURL(url);
}


</script>
</body>
</html>