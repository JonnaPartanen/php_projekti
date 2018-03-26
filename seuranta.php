<?php
session_start();
	require_once('sql_handler.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if (isset($_POST['check'])){
			
			$date = $_POST["pvm"];
			$hours = filter_var($_POST["tunnit"], FILTER_VALIDATE_INT);
			$overtime = $_POST["ylityo"];
			$weekend = $_POST["vkl"];
			$place = $_POST["kohde"];
			$kilometers = $_POST["km"];
			$km_description = $_POST["selite"];
			
		}
	
	 }


	//echo $message

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
    <div class="col-md-8" style="background-color:#5158AC">
    <h2> Työaikaseuranta ja ajopäiväkirja: </h2> <br>
    <?php echo "<p> Tervetuloa ".$_SESSION['username'] . $_SESSION['userid']. "</p>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <div class="form-row">
	<div class="form-group col-md-3">
      <label for="pvm">Päivämäärä</label>
      <input type="date" class="form-control" id="pvm" name="pvm" placeholder="MM/DD/YYYY">
    </div>
    <div class="form-group col-md-1">
      <label for="tunnit">tunnit</label>
      <input type="text" class="form-control" id="tunnit" name="tunnit" >
    </div>
    <div class="form-group col-md-1">
      <label for="ylityo">Ylityö</label>
      <input type="text" class="form-control" id="ylityo" name="ylityo">
    </div>
    <div class="form-group col-md-1">
      <label for="vkl">Vkl</label>
      <input type="text" class="form-control" id="vkl" name="vkl">
    </div>
  </div>
  
  <div class="form-row">
  <div class="form-group col-md-6">
    <label for="kohde">Kohde</label>
    <input type="text" class="form-control" id="kohde" name="kohde" placeholder="kohde">
  </div>
  <div class="form-group col-md-2">
      <label for="km">Kilometrit</label>
      <input type="text" class="form-control" id="km" name="km">
  </div>
  <div class="form-group col-md-6">
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
	if (isset($km_description))
		echo "<br><br><p align='center'>".$message=insert_hours($date, $hours, $overtime, $weekend, $place, $kilometers, $km_description) ."</p>";
?>
  
</body>
</html>
