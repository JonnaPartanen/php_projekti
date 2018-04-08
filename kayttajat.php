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
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){	
		if (isset($_POST['check'])){
	$lname = $_POST['sukunimi'];
	$fname = $_POST['etunimi'];
	$bdate = $_POST['saika'];
	$veroNro=$_POST['veronro'];
	$address=$_POST['osoite'];
	$zipcode = $_POST['postinro'];
	$city=$_POST['kaupunki'];
	$phone=$_POST['puhnro'];
	$email=$_POST['email'];
	$pass=$_POST['salasana'];
	$admin=$_POST['admin'];
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Henkilon lisÃ¤ys</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</head>
<body class ="mb-2 bg-primary text-white" >

<div class="jumbotron text-center" style="background-color:inherit">
  <h2 class="mb-2 bg-primary text-white">TimanttityÃ¶ Lindh Oy</h2>
  
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="background-color:#5158AC">
    <h2> LisÃ¤Ã¤ tyÃ¶ntekijÃ¤tiedot: </h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="sukunimi">Sukunimi</label>
      <input type="text" class="form-control" id="sukunimi" name="sukunimi" placeholder="Sukunimi">
    </div>
    <div class="form-group col-md-2">
      <label for="etunimi">Etunimi</label>
      <input type="text" class="form-control" id="etunimi" name="etunimi" placeholder="Etunimi">
    </div>
    
    <div class="form-group col-md-3">
      <label for="saika">SyntymÃ¤aika</label>
      <input type="date" class="form-control" id="date" name="saika" placeholder="MM/DD/YYYY">
    </div>
    
    <div class="form-group col-md-3">
      <label for="inputPassword4">Veronumero</label>
      <input type="text" class="form-control" id="veronro" name="veronro" placeholder="VeroNro">
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-5">
    <label for="inputAddress">Katuosoite</label>
    <input type="text" class="form-control" id="address" name="osoite" placeholder="Tiekatu 123">
  </div>
  <div class="form-group col-md-2">
      <label for="postiNro">Postinumero</label>
      <input type="text" class="form-control" id="postiNro" name="postinro">
  </div>
  <div class="form-group col-md-2">
      <label for="kaupunki">City</label>
      <input type="text" class="form-control" id="kaupunki" name="kaupunki">
    </div>
    </div>
  
    <div class="form-group col-md-3">
      <label for="puhNro">Puhelinnumero</label>
      <input type="text" class="form-control" id="puhNro" name="puhnro">
    </div>
    
    <div class="form-row">
    <div class="form-group col-md-4">
      <label for="email">Email tai kÃ¤yttÃ¤jÃ¤tunnus</label>
      <input type="text" id="email" name="email" class="form-control">
    </div>
    <div class="form-group col-md-3">
      <label for="password">Salasana</label>
      <input type="password" id="password" name="salasana" class="form-control">
    </div>
    
    <label for="admin">Admin</label><br>
    	<label class="radio-inline">
      		<input type="radio" id="no" name="admin" value="0" checked>Ei
    	</label>
    	<label class="radio-inline">
      		<input type="radio" id="yes" name="admin" value="1" >Kyll�
    	</label>
     
  </div>
 <div class="form-group col-md-5">
 <br>
 <button type="submit" name="check" class="btn btn-success btn-block" style="height:40px">Tallenna työntekijätiedot</button>
 </div>
</form>
</div>
<?php
	if (isset($pass))
		echo "<br><br><p align='center'>".$message=insert_person($lname,$fname,$bdate,$veroNro,$address,$zipcode,$city,$phone,$email,$pass, $admin) ."</p>";
?>

    <div class="col-md-2"></div>
</div>
  
</body>
</html>
