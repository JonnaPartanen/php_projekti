<?php
	session_start();
	require_once('sql_handler.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if (isset($_POST['check'])){
			
			$email = $_POST["email"];
    		$pwd = $_POST["pwd"];
			
		}
	
	 }


	//echo $message

?>



<!DOCTYPE html>
<html lang="fi">
<head>
  <title>Bootstrap Example</title>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body class ="mb-2 bg-primary text-white" >

<div class="jumbotron text-center" style="background-color:inherit">
  <h2 class="mb-2 bg-primary text-white">Timanttityö Lindh Oy</h2>
  
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-4">
      
      
    </div>
    <div class="col-sm-4">
      <h3>Kirjaudu sisään:</h3>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="remember"> Remember me</label>
    </div>
    <button type="submit" name="check" class="btn btn-default">Submit</button>
  </form>
    </div>
    <div class="col-sm-4">
      
    </div>
  </div>
</div>
<?php
	if (isset($email))
		echo "<br><br><p align='center'>".$message=login($email, $pwd) ."</p>";
?>

</body>
</html>