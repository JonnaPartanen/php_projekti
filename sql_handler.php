<?php 
//session_start();
require_once('connection.php');

function login($email, $pwd){
    
    $sql = "SELECT * FROM henkilo WHERE ktunnus = '$email'";
    $result = get_database($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $current_userid=$row["idhenkilo"];
            $current_user = $row["sukunimi"]. ", " . $row["etunimet"]; 
            $sql_username=$row["ktunnus"];
            $sql_pwd=$row["salasana"];
        }
        if($sql_username==$email && $sql_pwd==$pwd ){
            //"Kirjautuminen onnistui"
            $_SESSION['userid'] = $current_userid;
            $_SESSION['username'] = $current_user;
            header("Location: seuranta.php"); /* Redirect browser */
        }else{
            //header("Location: index.html");
            return "Tarkista käyttäjänimi ja salasana";
        }
    } else {
        return auth_failed();
    }
    
}

function insert_hours($date, $hours, $over_time, $weekend, $place, $kilometers, $km_description){
    $userid=$_SESSION["userid"];
    $sql = "INSERT INTO tuntiseuranta (pvm, tyokohde, tunnit, ylityo, viikonloppu, kilometrit, kmselite, henkilo_idhenkilo)
	VALUES ('$date','$place','$hours','$over_time','$weekend','$kilometers','$km_description','$userid')";
    $result = get_database($sql);
    
    if ($result === TRUE) {
        return "New record created successfully";
    } else {
        return $sql;
    }
    
    //return $result;*/
}


function auth_failed(){
     return "Kirjautuminen epäonnistui. Tarkasta käyttäjätunnus ja salasana";
}


?>