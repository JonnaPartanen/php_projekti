<?php
session_start();
	require_once('sql_handler.php');
	if (empty($_SESSION['userid'])) {

			header("Location: index.php"); /* Redirect browser */;
	}
	$dateErr = $hourErr = $Err = "";
	$otErr = $wErr = $kmErr = "";
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if (isset($_POST['check'])){
			
			if(empty($_POST["pvm"])){
				$dateErr = "pvm on pakollinen tieto";
			} else {
				$date = $_POST["pvm"];
			}

			if(empty($_POST["tunnit"])){
				$hourErr = "Tunnit on pakollinen tieto";
			}
				elseif (check_if_float($_POST["tunnit"]) == false) {
					$hourErr = "Tarkista syöte";
			} else {
				$hours = str_replace(",", ".",$_POST["tunnit"]);
			}
			if (check_if_float($_POST["ylityo"]) == false && $_POST["ylityo"]!='' ) {
				$otErr = "Tarkista syöte";
			}
			if (check_if_float($_POST["ylityo"]) == true) {
				$overtime = str_replace(",", ".",$_POST["ylityo"]);
			}
			if (check_if_float($_POST["vkl"]) == false && $_POST["vkl"]!='') {
				$wErr = "Tarkista syöte";
			} 
			if (check_if_float($_POST["vkl"]) == true){
				$weekend = str_replace(",", ".",$_POST["vkl"]);
			}
			if (check_if_float($_POST["km"]) == false && $_POST["km"]!='') {
				$kmErr = "Tarkista syöte";
			} 
			if (check_if_float($_POST["km"]) == true) {
				$kilometers = str_replace(",", ".",$_POST["km"]);
			}
			$place = filter_var($_POST["kohde"], FILTER_SANITIZE_STRING);
			$km_description = filter_var($_POST["selite"], FILTER_SANITIZE_STRING);

			
		}
	
	 }

function check_if_float($floatInput){
	$bln= filter_var(str_replace(",", ".", $floatInput), FILTER_VALIDATE_FLOAT);
	return $bln;
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
		<button type="button" class="btn btn-success" onclick="openKayttajat()">Lis�� ty�ntekij�</button>
		<button type="button" class="btn btn-success" onclick="openRaportit()">Raporttien haku ja tulostus</button>
		<button type="button" class="btn btn-success" onclick="openSeuranta()">Tunti- ja ajop�iv�kirjan t�ytt�</button>
		<button type="submit" name="logout" class="btn btn-danger">Kirjaudu ulos ja sulje</button>
		
	</div> </form></div>
	
    <div class="col-md-2"></div>
    <div class="col-md-8" style="background-color:#5158AC">
    <h2> Työaikaseuranta ja ajopäiväkirja: </h2> <br>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <div class="form-row">
  <?php 
	if ($_SESSION['admin'] == true) {
		echo "<div class='form-group col-md-4'>";
  		echo "<label for='sel1'>Valitse työntekijä:</label>";
  		echo "<select class='form-control' id='sel1'>";
		echo $_SESSION['populate_drop_down'];
		echo	"</select></div>";
	} else {
		echo "<h3 style='color:red'>".$_SESSION['username']."</h3>"; 
	}
?>
	<div class='form-group col-md-10'> <h4>Työtunnit ja työkohde:</h4> <small class='danger'>(Päivämäärä ja perustunnit ovat pakollisia tietoja.)</small></div>
	</div>
	<div class="form-row">
	<div class="form-group col-md-3">
      <label for="pvm">Päivämäärä (tunnit/km)</label>
      <input type="date" class="form-control" id="pvm" name="pvm" placeholder="MM/DD/YYYY">
      <span class="error">* <?php echo $dateErr;?></span>
    </div>
    <div class="form-group col-md-1">
      <label for="tunnit">Työtunnit</label>
      <input type="text" class="form-control" id="tunnit" name="tunnit" >
      <span class="error">* <?php echo $hourErr;?></span>
    </div>
    <div class="form-group col-md-1">
      <label for="ylityo">Ylityö</label>
      <input type="text" class="form-control" id="ylityo" name="ylityo">
      <span class="error"> <?php echo $otErr;?></span>
    </div>
    <div class="form-group col-md-1">
      <label for="vkl">Vkl</label>
      <input type="text" class="form-control" id="vkl" name="vkl">
       <span class="error"> <?php echo $wErr;?></span>
    </div>
  </div>
  
  <div class="form-group col-md-6">
    <label for="kohde">Kohde</label>
    <input type="text" class="form-control" id="kohde" name="kohde" placeholder="kohde">
    </div>
  <div class="form-row">
  <div class="form-group col-md-12">
   <h4>Ajokilometrit ja selite:</h4> </div>
  </div>
  <div class="form-row"> 
  <div class="form-group col-md-2">
      <label for="km">Kilometrit</label>
      <input type="text" class="form-control" id="km" name="km">
       <span class="error"> <?php echo $kmErr;?></span>
  </div>
  <div class="form-group col-md-10">
      <label for="selite">Km Selite</label>
      <input type="text" class="form-control" id="selite" name="selite">
    </div>
    </div>

    

 <div class="form-group col-md-5">
 <br>
 <button type="submit" name="check" class="btn btn-success btn-block" style="height:40px">Tallenna tiedot</button>
 </div>
</form>
</div>


    <div class="col-md-2"></div>
</div>

<?php
	if (isset($date))
		echo "<br><br><p align='center'>".$message=insert_hours($date, $hours, $overtime, $weekend, $place, $kilometers, $km_description) ."</p>";
?>
<div class="col-md-2"></div>
    <div class="col-md-8">
<table class="table table-hover table-dark">
 <thead>
<tr><th scope="col"> Id </th><th scope="col"> Pvm </th><th scope="col">Kohde</th><th scope="col">Tunnit</th><th scope="col">Ylityö</th><th scope="col">Viikonloppu</th><th scope="col">Kilometrit</th><th scope="col">Selite</th></tr>
</thead>
<?php
	if (isset($message))
		echo $_SESSION['addedRows'];
?>
</table>
 </div>
 <div class="col-md-2"></div> 
</body>
<script type='text/javascript' src="menu.js"></script>
</html>
