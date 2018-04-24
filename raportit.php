<?php
session_start();

	require_once('sql_handler.php');
	if (empty($_SESSION['userid'])) {

			header("Location: index.php"); /* Redirect browser */;
	}elseif($_SESSION['admin']!=true){
		header("Location: seuranta.php"); /* Redirect browser */;

	}else{
	    echo "Kirjautunut käyttäjä: " .$_SESSION['username'];
	}
	getNames();


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['check'])){
        $today = date("Y-m-d");
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $tables=1;
        
        if (count($_POST['names']) == 0) {
            echo "Valitse ainakin yksi henkilö";
        }else {
            $names = $_POST['names'];
        }
        if(isset($_POST['person_info']) && isset($_POST['other_info'])){
            $arguments = array_merge($_POST['person_info'], $_POST['other_info']);
            $tables ++;
        } else if (isset($_POST['person_info'])==true && isset($_POST['other_info'])==false){
            $arguments = array_merge($_POST['person_info']);
            
        } else if (isset($_POST['person_info'])==false && isset($_POST['other_info'])==true){
            $arguments = array_merge($_POST['other_info']);
            $tables ++;
        } else {
            echo "Valitse ainakin yksi näytettävä tieto henkilötaulusta";
        }
        
        if($tables == 2){
            if($start_date ==''){
                $start_date = $today;
            } 
            if($end_date ==''){
                $end_date = $today;
                
            }
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Henkilon lisäys</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  
</head>
<body>
<div class="mb-2 bg-primary text-white"> <!-- container -->
<div class="jumbotron text-center" style="background-color:inherit">
  <h2 class="mb-2 bg-primary text-white">Timanttityö Lindh Oy</h2>
</div>

<div class="row">
    <div class="col-sm-2 text-center">
    <form action="logout.php" method="post">
    <div class="btn-group-vertical">
		<button type="button" class="btn btn-success" onclick="openKayttajat()">Lisää työntekijä</button>
		<button type="button" class="btn btn-success" onclick="openRaportit()">Raporttien haku ja tulostus</button>
		<button type="button" class="btn btn-success" onclick="openSeuranta()">Tunti- ja ajopäiväkirjan täyttö</button>
		<button type="submit" name="logout" class="btn btn-danger">Kirjaudu ulos ja sulje</button>
	</div>	
	</form>
	</div>
    <div class="col-md-8" style="background-color:#f2f2f2" >
    	<h2 class="text-primary">Työntekijäraportit: </h2>
    	<p class="text-info"> <small>(Shift tai CTRL nappi pohjassa voit valita useamman)</small></p>

	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  		<div class="form-row">
    		<div class="form-group col-md-4">
  				<label for="sel1"><h4 class="text-primary"> Valitse henkilö:</h4> <p class="text-info"> <small>(Haettava henkilö(t))</small></p></label>
      			<select name="names[]" multiple class="form-control" id="sel1" style="height:160px">
        		<?php echo $_SESSION['populate_drop_down']?>
      			</select>
    		</div>
  
    		<div class="form-group col-md-4">
    			<label for="sel2"><h4 class="text-primary">Tulostettavat henkilötiedot:</h4>  <p class="text-info"> <small>(Työntekijätiedot)</small></p></label>
      			<select name="person_info[]" multiple class="form-control" id="sel2" style="height:160px">
      			<option value="'sukunimi'">Sukunimi</option>
      			<option value="'etunimi'">Etunimi</option>
      			<option value="'syntaika'">Syntymäaika</option>
      			<option value="'tuntipalkka'">Tuntipalkka</option>
      			<option value="'lahiosoite'">Osoite</option>
      			<option value="'postinro'">PostiNro</option>
      			<option value="'kaupunki'">Kaupunki</option>
      			<option value="'puhnro'">Puhelinnumero</option>
      			<option value="'veronro'">Veronumero</option>
      			<option value="'email'">Email</option>
      			</select>
    		</div>
    		<div class="form-group col-md-4">
    			<label for="sel3"><h4 class="text-primary"> Tulostettavat palkkatiedot: </h4> <p class="text-info"> <small>(Tunnit, kohteet, km)</small></p></label>
      			<select name= "other_info[]" multiple class="form-control" id="sel3" style="height:160px">>
      			<option value="'pvm'">Päivämäärä</option>
      			<option value="'tyokohde'">Työkohde</option>
      			<option value="'tunnit'">Työtunnit</option>
      			<option value="'ylityo'">Ylityöt</option>
      			<option value="'km'">Ajokilometrit</option>
      			<option value="'kmselite'">KM selite</option>
      			</select>
    		</div>
    	</div>
    	<div class="form-row">
    	<div class="form-group col-md-3">
    	<label for = "aloituspvm" class="text-primary">Jakson alku</label>
    	<input type="date" class="form-control" id="alku" name="start_date" placeholder="MM/DD/YYYY">
    	</div>
    	<div class="form-group col-md-3">
    	<label for = "lopetuspvm" class="text-primary">Jakson loppu</label>
    	<input type="date" class="form-control" id="loppu" name="end_date" placeholder="MM/DD/YYYY">
    	</div>
    	<div class="form-group col-md-3"><br>
    		<button type="submit" class="btn btn-success btn-block" style="height:40px">Tyhjennä</button>
    	</div>
    	<div class="form-group col-md-3"><br>
 			<button type="submit" name="check" class="btn btn-success btn-block" style="height:40px">Näytä Raportti</button>
		</div>
		</div>
	</form>
</div>
<div class="col-md-2 text-center"></div>
</div>
<div class="row">

<div class="col-md-1 text-center"></div>
<div class="col-md-10 text-center"> <br><br><br><br>
	<?php
	if (isset($arguments) && isset($names) && isset($start_date) && isset($end_date) && $tables==2){   
	    echo $html_table= get_personal_and_working_info($arguments, $names, $start_date, $end_date);
            //$html_table= get_personal_info($arguments, $names);
	} else if(isset($arguments) && isset($names) && $tables ==1){
	    echo $html_table = get_personal_info($arguments, $names);
	}
        
    ?>
    </div>
    <div class="col-md-1 text-center"></div>
    </div>
</div>
 <div> <!-- container --> 
</body>
<script type='text/javascript' src="js/menu.js"></script>
</html>
