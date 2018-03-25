<?php
	$date = $_POST["pvm"];
	$tunnit = $_POST["tunnit"];
	$ylityo = $_POST["ylityo"];
	$vkl = $_POST["vkl"];
	$kohde = $_POST["kohde"];
	$km = $_POST["km"];
	$selite = $_POST["selite"];
	
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


	$sql = "INSERT INTO tuntiseuranta (pvm, tyokohde, tunnit, ylityo, viikonloppu, kilometrit, kmselite, henkilo_idhenkilo) 
	VALUES ('$date','$kohde','$tunnit','$ylityo','$vkl','$km','$selite','20000')";

	if ($conn->query($sql) === TRUE) {
    		echo "New record created successfully";
	} else {
    		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	
	echo ($date);
	echo "<br>";
	echo ($tunnit);
	echo "<br>";
	echo ($ylityo);
	echo "<br>";
	echo ($vkl);
	echo "<br>";
	echo ($kohde);
	echo "<br>";
	echo ($km);
	echo "<br>";
	echo ($selite);
	
	
?>