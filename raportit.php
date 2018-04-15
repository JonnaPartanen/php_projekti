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
        if($_POST['person_info'] !=false && $_POST['other_info']!=false){
            $arguments = array_merge($_POST['person_info'], $_POST['other_info']);
            $tables ++;
        } else if(count($_POST['person_info']) > 0 && count($_POST['other_info'])==0){
            $arguments = array_merge($_POST['person_info']);
            
        } else{
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</head>
<body class ="mb-2 bg-primary text-white" >

<div class="jumbotron text-center" style="background-color:inherit">
  <h2 class="mb-2 bg-primary text-white">Timanttityö Lindh Oy</h2>
</div>

<div class="row">
    <div class="col-sm-3 text-center">
    <form action="logout.php" method="post">
    <div class="btn-group-vertical">
		<button type="button" class="btn btn-success" onclick="openKayttajat()">Lisää työntekijä</button>
		<button type="button" class="btn btn-success" onclick="openRaportit()">Raporttien haku ja tulostus</button>
		<button type="button" class="btn btn-success" onclick="openSeuranta()">Tunti- ja ajopäiväkirjan täyttö</button>
		<button type="submit" name="logout" class="btn btn-danger">Kirjaudu ulos ja sulje</button>
		
	</div> </form></div>
    <div class="col-md-8" style="background-color:#f2f2f2">
    	<h2 class="text-primary">Työntekijäraportit: </h2>
    	<p class="text-info"> <small>(Shift tai CTRL nappi pohjassa voit valita useamman)</small></p>

	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  		<div class="form-row">
    		<div class="form-group col-md-4">
  				<label for="sel1"><h4 class="text-primary"> Valitse henkilö:</h4> <p class="text-info"> <small>(Haettava henkilö(t))</small></p></label>
      			<select name="names[]" multiple class="form-control" id="sel1" style="height:160px">>
        		<?php echo $_SESSION['populate_drop_down']?>
      			</select>
    		</div>
  
    		<div class="form-group col-md-4">
    		<label for="sel2"><h4 class="text-primary">Tulostettavat henkilötiedot:</h4>  <p class="text-info"> <small>(Työntekijätiedot)</small></p></label>
      		<select name="person_info[]" multiple class="form-control" id="sel2" style="height:160px">
      		<option value="'sukunimi'">Sukunimi</option>
      		<option value="'etunimet'">Etunimi</option>
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
      		<select name= "other_info[]" multiple class="form-control" id="sel3" style="height:160px">>
      		
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
    	<div class="form-group col-md-3">
    	<label for = "aloituspvm" class="text-primary">Aloitus päivämäärä</label>
    	<input type="date" class="form-control" id="alku" name="start_date" placeholder="MM/DD/YYYY">
    	</div>
    	<div class="form-group col-md-3">
    	<label for = "lopetuspvm" class="text-primary">Lopetus päivämäärä</label>
    	<input type="date" class="form-control" id="loppu" name="end_date" placeholder="MM/DD/YYYY">
    	</div>
    	</div>
    	<div class="form-row">
    	<div class="form-group col-md-3"><br>
    		<button type="submit" class="btn btn-success btn-block" style="height:40px">Tyhjennä</button>
    	</div>
    	<div class="form-group col-md-3"><br>
 			<button type="submit" name="check" class="btn btn-success btn-block" style="height:40px">Näytä Raportti</button>
		</div>
		</div>
		
	</form>
	
</div>
<div class="row">
<div class="col-md-2 text-center"></div>
<div class="col-md-8 text-center"> Testi
	<?php
	if (isset($arguments) && isset($names) && isset($start_date) && isset($end_date) && $tables==2){   
	    echo $html_table= get_personal_and_working_info($arguments, $names, $start_date, $end_date);
            //$html_table= get_personal_info($arguments, $names);
	}
        
    ?>
    </div>
    <div class="col-md-2 text-center"></div>
    </div>
</div>
  
</body>
<script type='text/javascript' src="menu.js"></script>
</html>
