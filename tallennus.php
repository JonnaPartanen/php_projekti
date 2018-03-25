<?php
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
	
	//SQL -starts here:
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mydb";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully";


	$sql = "INSERT INTO henkilo (etunimet, sukunimi, syntymaaika, osoite, postinumero, kaupunki, puhnro, veronro, ktunnus, salasana) 
	VALUES ('$fname','$lname','$bdate','$address','$zipcode','$city','$phone','$veroNro','$email','$pass')";

	if ($conn->query($sql) === TRUE) {
    		echo "New record created successfully";
	} else {
    		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

	
	echo ("<h3>Työntekijän tiedot:</h3>");
	echo ("Sukunimi: " .$lname ."<br>");
	echo ("Etunimi: " .$fname ."<br>");
	echo ("Syntymäaika : " .$bdate."<br>");
	echo ("Veronumero : " .$veroNro."<br>");
	echo ("Osoite: " .$address."<br>");
	echo ("PostiNro: " .$zipcode."<br>");
	echo ("Kaupunki: " .$city."<br>");
	echo ("Puhelin: " .$phone."<br>");
	echo ("Email/tunnus: " .$email."<br>");
	echo ("Salasana: " .$pass."<br>");
	
	


 
	
?>