<?php
ob_start();
session_start();
session_unset();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
<meta charset="utf-8">
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
<p id="demo"></p>
</head>
<body>
<script>
var s = 0;
var x = setInterval(function() 
{   
	s--;
    if(s < 0)
	{
		m--;
		if(m >= 0) s = 59;
	}
    if (m < 0 && s < 0) 
	{
        clearInterval(x);
        document.getElementById('click').click();
    }    
	if(s >= 10) document.getElementById("demo").innerHTML = "Pozostały czas: " + m + ":" + s;
	else document.getElementById("demo").innerHTML = "Pozostały czas: " + m + ":0" + s;
}, 1000);
</script>
<form action="wynik.php" method="post">
<?php
if(isset($_POST["test"])&&isset($_POST["id"])&&is_numeric($_POST["id"])&&$_POST["id"]>0&&isset($_POST["pass"]))
{
echo '<title>Użytkownik '.$_POST["id"].'</title>';    
$_SESSION["id"]=$_POST["id"];
$_SESSION["pass"]=$_POST["pass"];
$file=file("config.txt");
for($i=0;$i<count($file);$i=$i+5)
{
    $text=trim($file[$i]);
    if(strcmp($text,md5($_POST["pass"]))==0)
    {
        $plik=trim($file[$i+1]);
        $_POST["plik"]=$plik;
        $_SESSION["plik"]=$_POST["plik"];
        $poziom_trudnosci=trim($file[$i+2]);
        $_POST["poz_trud"]=$poziom_trudnosci;
        $_SESSION["poz_trud"]=$_POST["poz_trud"];
        $tryb=trim($file[$i+3]);
        $_POST["tryb"]=$tryb;
        $_SESSION["tryb"]=$_POST["tryb"];
        $czas=trim($file[$i+4]);
        settype($czas,"integer");
        echo '<script>';
        echo 'var m = '.json_encode($czas). ';';
        echo '</script>';
        break;
    }    
}
if(isset($plik)&&isset($poziom_trudnosci)&&isset($tryb)&&isset($czas)&&is_integer($czas))
{
    $fp = fopen($plik,"r");
    $nr_linii = 0;
    $nr_pytania = 0;
    if($_SESSION["tryb"]=="2") $typ="checkbox"; //test wielokrotnego wyboru
    elseif($_SESSION["tryb"]=="1") $typ="radio"; //test jednokrotnego wyboru    
    while(!feof($fp))
    {
        $linia = fgets($fp);
        if($nr_linii%6==0) echo '<table class="table"><tr class="table-active"><th>'.($nr_pytania+1).'. '.$linia.'</th></tr></table>';
        if($nr_linii%6==1) echo '<div><input type="'.$typ.'" id="'.$nr_linii.'" name="chkbox'.$nr_pytania.'[]" value="A" /><label for="'.$nr_linii.'"><table class="table"><tr><td>'.$linia.'</td></tr></table></label></div>';
        if($nr_linii%6==2) echo '<div><input type="'.$typ.'" id="'.$nr_linii.'" name="chkbox'.$nr_pytania.'[]" value="B" /><label for="'.$nr_linii.'"><table class="table"><tr><td>'.$linia.'</td></tr></table></label></div>';
        if($nr_linii%6==3) echo '<div><input type="'.$typ.'" id="'.$nr_linii.'" name="chkbox'.$nr_pytania.'[]" value="C" /><label for="'.$nr_linii.'"><table class="table"><tr><td>'.$linia.'</td></tr></table></label></div>';
        if($nr_linii%6==4) echo '<div><input type="'.$typ.'" id="'.$nr_linii.'" name="chkbox'.$nr_pytania.'[]" value="D" /><label for="'.$nr_linii.'"><table class="table"><tr><td>'.$linia.'</td></tr></table></label></div>';        
        if($nr_linii%6==5)
        {
            if(isset($linia[0]))
            {
                $_POST["odp$nr_pytania"]=$linia[0];
                $_SESSION["odp$nr_pytania"]=$_POST["odp$nr_pytania"];
            }
            if($_SESSION["tryb"]=="2") // w przypadku testu wielokrotnego wyboru
            {
                if(isset($linia[1]))
                {
                    $_POST["odp2$nr_pytania"]=$linia[1];
                    $_SESSION["odp2$nr_pytania"]=$_POST["odp2$nr_pytania"];
                }
                if(isset($linia[2]))
                {
                    $_POST["odp3$nr_pytania"]=$linia[2];
                    $_SESSION["odp3$nr_pytania"]=$_POST["odp3$nr_pytania"];
                }
                if(isset($linia[3]))
                {
                    $_POST["odp4$nr_pytania"]=$linia[3];
                    $_SESSION["odp4$nr_pytania"]=$_POST["odp4$nr_pytania"];
                }
            }
            $nr_pytania++;
        }
        $nr_linii++;
    }
    $_POST["nr_pytania"]=$nr_pytania;
    $_SESSION["nr_pytania"]=$_POST["nr_pytania"];
    echo '<center><br><input type="submit" class="btn btn-primary mb-2" name="submit" id="click" formmethod="post" value="Wyślij"/><br></center>';
    echo '</form>';
    $godzina_start=date("H:i:s");
    $_POST["godzina_s"]=$godzina_start;
    $_SESSION["godzina_s"]=$_POST["godzina_s"];
}
else echo 'Złe hasło. Jeśli jednak hasło było wpisane prawidłowo, zgłoś problem prowadzącemu.';
}
else
{
    echo '<title>Błąd</title>';
    echo '</form>Żeby się zalogować, naciśnij przycisk Powrót';
    echo '<noscript><b>Włącz JavaScript</b></noscript>';
    echo '<br>';
    echo '<form action="index.php" method="post"><center><input type="submit" class="btn btn-primary mb-2" value="Powrót"/></center></form>';
}
?>
</body>
</html>
<?php
ob_end_flush();
?>