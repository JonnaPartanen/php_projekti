<?php
session_start();
	require_once('sql_handler.php');
	if (empty($_SESSION['userid'])) {

			header("Location: index.php"); /* Redirect browser */;
	}
	$dateErr = $hourErr = $Err = "";
	$otErr = $wErr = $kmErr = $eventId = "";
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	    
	    if(isset($_POST['remove'])){
	        $removeEvent = ($_POST['tapid']);
	    }
		
		if (isset($_POST['check'])){
		    echo $_POST['tapid'] ."joo";
		    if(isset($_POST['tapid'])){
		        echo $_POST['tapid'];
		        $eventId = $_POST['tapid'];
		        echo $eventId;
		    }
			
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
			
			if(empty($_POST["ylityo"])){
			    $overtime=0;
			}elseif(check_if_float($_POST["ylityo"]) == false){
			    $otErr = "Tarkista sy�te";
			    
			}else{
			    $overtime = str_replace(",", ".",$_POST["ylityo"]);
			}
		
			
			if(empty($_POST["km"])){
			    $kilometers=0;
			}elseif(check_if_float($_POST["km"]) == false){
			    $kmErr = "Tarkista sy�te";
			}else{
			    $kilometers = str_replace(",", ".",$_POST["km"]);
			}
			
			$place = filter_var($_POST["kohde"], FILTER_SANITIZE_STRING);
			$km_description = filter_var($_POST["selite"], FILTER_SANITIZE_STRING);
			
			if (isset($_POST['persons']) && $_POST['persons'] !=$_SESSION["userid"]){
			    $userid=$_POST["persons"];
			} else{
			    $userid=$_SESSION["userid"];
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
<body class ="mb-2 bg-primary text-white">

<div class="jumbotron text-center" style="background-color:inherit">
  <h2 class="mb-2 bg-primary text-white">Timanttityö Lindh Oy</h2>
</div>

<div class="row">

	<div class="col-sm-2 text-center" style="margin-left:15px";>
    <form action="logout.php" method="post">
    <div class="btn-group-vertical">
		<button type="button" class="btn btn-success" onclick="openKayttajat()">Lis�� ty�ntekij�</button>
		<button type="button" class="btn btn-success" onclick="openRaportit()">Raporttien haku ja tulostus</button>
		<button type="button" class="btn btn-success" onclick="openSeuranta()">Tunti- ja ajop�iv�kirjan t�ytt�</button>
		<button type="submit" name="logout" class="btn btn-danger">Kirjaudu ulos ja sulje</button>
		
	</div> </form></div>
	
  
    <div class="col-md-8 text-primary" style="background-color:#f2f2f2">
    <h2 class="text-primary"> Työaikaseuranta ja ajopäiväkirja: </h2> <br>
 
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <div class="form-row">
  <?php 
    echo '<div class="form-group col-md-3"><label id="tapidlabel" for="tapid" style="display:none">Tapahtuma ID</label>
	<input readonly type="text" class="form-control" id="tapid" name="tapid" style="display:none" >';
	if ($_SESSION['admin'] == true) {
		
  		echo "<label for='persons' id='personslabel'>Valitse työntekijä:</label>";
  		echo "<select class='form-control' name='persons' id='persons'>";
		echo $_SESSION['populate_drop_down'];
		echo	"</select>";
	} else {
		echo "<h3 style='color:red'>".$_SESSION['username']."</h3>"; 
	}
	echo '</div>';
	
?>
	
	
	<div class='form-group col-md-10'> <h4 class="text-primary">Työtunnit ja työkohde:</h4> <small class='danger'>(Päivämäärä ja perustunnit ovat pakollisia tietoja.)</small></div>
	</div>
	<div class="form-row">
	<div class="form-group col-md-3">
      <label for="pvm" class="text-primary" >Päivämäärä (tunnit/km)</label>
      <input type="date" class="form-control" id="pvm" name="pvm" placeholder="MM/DD/YYYY">
      <span class="error">* <?php echo $dateErr;?></span>
    </div>
    <div class="form-group col-md-1" class="text-primary">
      <label for="tunnit">Työtunnit</label>
      <input type="text" class="form-control" id="tunnit" name="tunnit" >
      <span class="error">* <?php echo $hourErr;?></span>
    </div>
    <div class="form-group col-md-1">
      <label for="ylityo">Ylityö/VKL</label>
      <input type="text" class="form-control" id="ylityo" name="ylityo">
      <span class="error"> <?php echo $otErr;?></span>
    </div>
    
  </div>
  
  <div class="form-group col-md-7">
    <label for="kohde">Kohde</label>
    <input type="text" class="form-control" id="kohde" name="kohde" placeholder="kohde">
    </div>
  <div class="form-row">
  <div class="form-group col-md-12">
   <h4>Ajokm ja selite:</h4> </div>
  </div>
  <div class="form-row"> 
  <div class="form-group col-md-2">
      <label for="km">km</label>
      <input type="text" class="form-control" id="km" name="km">
       <span class="error"> <?php echo $kmErr;?></span>
  </div>
  <div class="form-group col-md-10">
      <label for="selite">Km Selite</label>
      <input type="text" class="form-control" id="selite" name="selite">
    </div>
</div>

 <div class="form-row">
 	<div class="form-group col-md-3">
 		<br>
 		<button type="submit" name="check" class="btn btn-success btn-block" style="height:40px">Tallenna tiedot</button>
 		<button type="submit" name="remove" class="btn btn-danger btn-block" style="height:40px; display:none;">Poista rivi</button>
 	</div>
 	<div class="form-group col-md-9"></div>
 </div>
 
 
 <div class="form-row">
 <div class="form-group col-md-12"></div>
 <div class="form-group col-md-4"></div>
  	<div class="form-group col-md-3">
    	<label for = "aloituspvm" class="text-primary">Jakson alku</label>
    	<input type="date" class="form-control" id="alku" name="start_date" placeholder="MM/DD/YYYY">
  	</div>
    <div class="form-group col-md-3">
    	<label for = "lopetuspvm" class="text-primary">Jakson loppu</label>
    	<input type="date" class="form-control" id="loppu" name="end_date" placeholder="MM/DD/YYYY">
    </div>
    <div class="form-group col-md-2"><br>
 			<button type="submit" name="check" class="btn btn-success btn-block" style="height:40px">N�yt� Raportti</button>
	</div>
    
 </div><!-- p�iv�m��rien form row loppuu -->
 
 
 </form>
</div>


    <div class="col-md-2"></div>
</div>

<?php
if (isset($eventId) && $eventId !=""){
    echo "<br><br><p align='center'>".$message=update_hoursrow($eventId, $date, $hours, $overtime, $place, $kilometers, $km_description, $userid)."</p>";
} else if (isset($date) && isset($hours)&& isset($overtime)&& isset($kilometers) && $eventId ==""){
    echo "<br><br><p align='center'>".$message=insert_hours($date, $hours, $overtime, $place, $kilometers, $km_description, $userid) ."</p>";
} else if(isset($removeEvent)){
    echo "<br><br><p align='center'>".$message=remove_hoursRow($removeEvent) ."</p>";
}
?>
<div class="col-md-2"></div>
    <div class="col-md-8">
<table class="table table-hover table-dark">
 <thead>
<tr><th scope="col"> Id </th><th scope="col"> HenkilöId </th><th scope="col"> Pvm </th><th scope="col">Kohde</th><th scope="col">Tunnit</th><th scope="col">Ylityö/VKL</th><th scope="col">km</th><th scope="col">Selite</th></tr>
</thead>
<?php
	if (isset($message))
		echo $_SESSION['addedRows'];
?>
</table>

 </div>
 <div class="col-md-2"></div>
 <script type='text/javascript' src="js/menu.js"></script> 
</body>

</html>
