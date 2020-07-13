<html>
<head>
<meta charset="utf-8">
<title>Test ABCD</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
</head>
<body>
<form action="test.php" method="post" autocomplete="off">
<div class="container">
    <br><h2 style="text-align: center;">Panel logowania</h2>
        <hr>
             <div id="start">
                  <input type="text" class="form-control" id="id" name="id" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="login" disabled/>
                  <input type="password" class="form-control" id="pass" name="pass" placeholder="hasło" disabled/><br><br><br>
                  <input type="submit" class="btn btn-primary mb-2" id="rozpo" name="test" value="Przejdź dalej" disabled/><br>
             </div>
        </hr>
</div>
<script>
document.getElementById("id").disabled = false;   
document.getElementById("pass").disabled = false;   
document.getElementById("rozpo").disabled = false;    
</script> 
<noscript>
<center><b>Włącz JavaScript</b></center>
</noscript>
</form>
</body>
</html>
