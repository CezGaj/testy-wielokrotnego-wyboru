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
<script>
var lista = [];    
</script>
<form action="edytor.php" method="post" autocomplete="off">
<fieldset>
<?php
require 'connect.php';
if(isset($_POST["deleteall"]))
{
$stmt = $pdo->exec('TRUNCATE TABLE wyniki');
$stmt->closeCursor();	
}
$stmt = $pdo->query('SELECT * FROM wyniki ORDER BY nr_indeksu asc');
if ($stmt->execute() > 0) 
{
    $li=0;
    echo '<table class="table"><tr><th>numer indeksu</th><th>wynik</th></table>';
while($row = $stmt->fetch()) 
{
    $usuniete=false;
    if(isset($_POST["delet"])) 
    {
        $x=$row["nr_indeksu"];
        if(isset($_POST["$x"]))
        {
            $y=$_POST["$x"];
            $stmt = $pdo->exec("DELETE FROM wyniki WHERE nr_indeksu=$x AND wynik=$y");
            if($stmt==0) echo 'Błąd usuwania: <br>';
            else $usuniete=true; 
        }
    }
    if($usuniete==false) 
    {
        echo '<div><input type="checkbox" id="'.$li.'" name="'.$row["nr_indeksu"].'" value="'.$row["wynik"].'"/><label for="'.$li.'"><table class="table"><tr><td>'.$row["nr_indeksu"].'</td><td>'.$row["wynik"].'</td></tr></table></label></div>';
        echo '<script>lista.push([json_encode($row["nr_indeksu"]),json_encode($row["wynik"])]);</script>';
    }
    $li++;
}

}

$stmt->closeCursor();	
?>
</fieldset>
<br>
<div class="container-flush">
    <div class="row justify-content-center">  
        <div class="col-md-4"><center><input type="submit" class="btn btn-primary mb-2" name="deleteall" value="Usuń wszystko"/></center></div>
        <div class="col-md-4"><center><input type="submit" class="btn btn-primary mb-2" name="delet" value="Usuń zaznaczone"/></center></div>
        <div class="col-md-4"><center><input type="button" class="btn btn-primary mb-2" name="sav" value="Zapisz do pliku" onclick="zapisz();"/></center></div>
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
    a.download = fileName;
    a.click();
    window.URL.revokeObjectURL(url);
}


</script>
</body>
</html>
