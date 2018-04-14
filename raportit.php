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
	
	//$_SESSION['populate_drop_down'] = 
	getNames();
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Henkilon lisäys</title>
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
    <div class="col-md-2"></div>
    <div class="col-md-9" style="background-color:#f2f2f2">
    	<h2 class="text-primary">Työntekijäraportit: </h2>
    	<p class="text-info"> <small>(Shift tai CTRL nappi pohjassa voit valita useamman)</small></p>

	<form action="tallennus.php" method="post">
  		<div class="form-row">
    		<div class="form-group col-md-4">
  				<label for="sel1"><h4 class="text-primary"> Valitse henkilö:</h4> <p class="text-info"> <small>(Haettava henkilö(t))</small></p></label>
      			<select name="names[]" multiple class="form-control" id="sel1">
        		<?php echo $_SESSION['populate_drop_down']?>
      			</select>
    		</div>
  
    		<div class="form-group col-md-4">
    		<label for="sel2"><h4 class="text-primary">Tulostettavat henkilötiedot:</h4>  <p class="text-info"> <small>(Työntekijätiedot)</small></p></label>
      		<select multiple class="form-control" id="sel2">
      		<option value="'syntymaaika'">Syntymäaika</option>
      		<option value="'osoite'">Osoite</option>
      		<option value="'postinumero'">PostiNro</option>
      		<option value="'kaupunki'">Kaupunki</option>
      		<option value="'puhnro'">Puhelinnumero</option>
      		<option value="'veronro'">Veronumero</option>
      		<option value="'ktunnus'">Email</option>
      		</select>
    		</div>
    		<div class="form-group col-md-4">
    		<label for="sel3"><h4 class="text-primary"> Tulostettavat palkkatiedot: </h4> <p class="text-info"> <small>(Tunnit, kohteet, kilometrit)</small></p></label>
      		<select multiple class="form-control" id="sel3">
      		
      		<option value="'idtuntiseuranta'">TapahtumaNro</option>
      		<option value="'pvm'">Päivämäärä</option>
      		<option value="'tyokohde'">Työkohde</option>
      		<option value="'tunnit'">Työtunnit</option>
      		<option value="'ylityo'">Ylityöt</option>
      		<option value="'viikonloppu'">LA/SU työt</option>
      		<option value="'kilometrit'">Ajokilometrit</option>
      		<option value="'kmselite'">KM selite</option>
      		<option value="'palkka'">Palkka</option>
      		</select>
    		</div>
    		</div>
    	<div class="form-row">
    	
    	<div class="form-group col-md-4">
 			<button type="submit" class="btn btn-danger btn-block" style="height:40px">Tallenna työntekijätiedot</button>
		</div>
		</div>
	</form>
	
	
</div>
<div class="col-md-1"></div>

  
</body>
</html>
