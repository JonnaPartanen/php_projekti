<?php
session_start();
	require_once('sql_handler.php');
	if (empty($_SESSION['userid'])) {

			header("Location: index.php"); /* Redirect browser */;
	}elseif($_SESSION['admin']!=true){
		header("Location: seuranta.php"); /* Redirect browser */;

	}else{
		echo "Tervetuloa " .$_SESSION['username'];
	}
	

	

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body class ="mb-2 bg-primary text-white" >

<div class="jumbotron text-center" style="background-color:inherit">
  <h2 class="mb-2 bg-primary text-white">Timanttityö Lindh Oy</h2>
  
</div>
  
<div class="row">
  <div class="col-sm-4 text-center"><h3>Valitse toiminto:</h3>
  <form action="logout.php" method="post">
	<div class="btn-group-vertical">
		<button type="button" class="btn btn-success" onclick="openKayttajat()">Lisää työntekijä</button>
		<button type="button" class="btn btn-success" onclick="openRaportit()">Raporttien haku ja tulostus</button>
		<button type="button" class="btn btn-success" onclick="openSeuranta()">Tunti- ja ajopäiväkirjan täyttö</button>
		<button type="submit" name="logout" class="btn btn-danger">Kirjaudu ulos ja sulje</button>
		
	</div> 
	</form>
  </div>
  <div class="col-sm-8">.col-sm-4</div>
  
</div> 

</body>
<script type='text/javascript' src="menu.js"></script>
</html>
