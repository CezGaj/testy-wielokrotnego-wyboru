<?php
ob_start();
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
<meta charset="utf-8">
<title>Wynik testu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>    
<script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
</script>
<script type="text/javascript"
  src="js/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>    
</head>
<body>
<?php
if(isset($_POST["submit"]))
{
$godzina_koniec=date("H:i:s");    
$wynik = 0;
$ilosc_pytan = $_SESSION["nr_pytania"];
$nr_indeksu = $_SESSION["id"];
$values = array('A','B','C','D');
for($i=0;$i<$ilosc_pytan;$i++)
{
$niezaznaczone_zle[$i] = array('A','B','C','D');
$niezaznaczone_dobre[$i] = array();
$zaznaczone_dobre[$i] = array();   
$zaznaczone_zle[$i] = array();
$liczba = 1;
$zaznaczone = false;
if(isset($_POST["chkbox$i"]))
{
  if (is_array($_POST["chkbox$i"])) 
  {
    foreach($_POST["chkbox$i"] as $value) // segregowanie zaznaczonych odpowiedzi
	{
	  if((isset($_SESSION["odp$i"])&&$value==$_SESSION["odp$i"])||(isset($_SESSION["odp2$i"])&&$value==$_SESSION["odp2$i"])||(isset($_SESSION["odp3$i"])&&$value==$_SESSION["odp3$i"])||(isset($_SESSION["odp4$i"])&&$value==$_SESSION["odp4$i"]))
	  {
        if (($key = array_search($value, $niezaznaczone_zle[$i])) !== false) 
        {
            unset($niezaznaczone_zle[$i][$key]);
            array_push($zaznaczone_dobre[$i],$value); 
            $zaznaczone = true;
        }
	  }
	  else
	  {
        if (($key = array_search($value, $niezaznaczone_zle[$i])) !== false) 
        {
            unset($niezaznaczone_zle[$i][$key]);
            array_push($zaznaczone_zle[$i],$value); 
            if($liczba>0) 
            {
                if($_SESSION["poz_trud"]=='2') $liczba=0;
                else $liczba=$liczba-0.5;
            }        
        }
	  }
    }
  } 
}
for($j=0;$j<4;$j++) // segregowanie niezaznaczonych odpowiedzi
{
    if((isset($_SESSION["odp$i"])&&$values[$j]==$_SESSION["odp$i"])||(isset($_SESSION["odp2$i"])&&$values[$j]==$_SESSION["odp2$i"])||(isset($_SESSION["odp3$i"])&&$values[$j]==$_SESSION["odp3$i"])||(isset($_SESSION["odp4$i"])&&$values[$j]==$_SESSION["odp4$i"])) 
	{        
        if (($key = array_search($values[$j], $niezaznaczone_zle[$i])) !== false) 
        {
            unset($niezaznaczone_zle[$i][$key]);
            array_push($niezaznaczone_dobre[$i],$values[$j]);
            if($liczba>0) 
            {
                if($_SESSION["poz_trud"]=='2') $liczba=0;
                else $liczba=$liczba-0.5;
            }         
        }
    }
}
if($zaznaczone==false) $liczba=0;
$wynik=$wynik+$liczba;
//echo "$wynik<br>";
}
include 'connect.php';
$sql="INSERT INTO wyniki (nr_indeksu,wynik) VALUES ($nr_indeksu,$wynik)"; 

if (!$conn->query($sql)) 
{
    echo "Error:  $sql <br>" . $conn->error;
}
$conn->close();

echo "Numer indeksu: <b>$nr_indeksu</b><br>";
echo "Zdobyłeś $wynik na $ilosc_pytan pkt <br>";
$procent=($wynik/$ilosc_pytan)*100;
echo "Wynik: ".round($procent,2)."%<br>";
$czas_testu=(strtotime($godzina_koniec)-strtotime($_SESSION["godzina_s"]))-1;
$minuty=floor($czas_testu/60);
$sekundy=$czas_testu-($minuty*60);
echo "Czas rozwiazywania testu <b>$minuty m $sekundy s</b> <br><hr>";
$file=file($_SESSION["plik"]);
$nr_linii=0;
echo '<table class="table">';
for($i=0;$i<$ilosc_pytan;$i++) // wyswietlanie prawidłowych oraz zaznaczonych odpowiedzi
{
echo '<thead><tr><th>'.($i+1).'. '.$file[$nr_linii].'</th></tr></thead><tbody>';
for($j=0;$j<4;$j++)
{
	if (array_search($values[$j], $niezaznaczone_dobre[$i]) !== false) echo '<tr class="table-info"><td>'.$file[$nr_linii+$j+1].'</td></tr>';  
    elseif (array_search($values[$j], $niezaznaczone_zle[$i]) !== false) echo '<tr class="table-light"><td>'.$file[$nr_linii+$j+1].'</td></tr>';  
    elseif (array_search($values[$j], $zaznaczone_dobre[$i]) !== false) echo '<tr class="table-success"><td>'.$file[$nr_linii+$j+1].'</td></tr>';  
    elseif (array_search($values[$j], $zaznaczone_zle[$i]) !== false) echo '<tr class="table-danger"><td>'.$file[$nr_linii+$j+1].'</td></tr>';  
}    
echo '</tbody>';
$nr_linii=$nr_linii+6;
}
echo '</table>';
}
else
{
echo '<title>Błąd</title>';       
echo 'Nie zalogowałeś się i nie wypełniłeś testu.';
}
?>
<form action="index.php" method="post">
<center><input type="submit" class="btn btn-primary mb-2" value="Powrót"/></center>   
</form>
</body>
</html>
<?php
ob_end_flush();
?>
