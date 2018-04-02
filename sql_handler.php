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
            $_SESSION['admin']=$row["admin"];
        }
        if($sql_username==$email && $sql_pwd==$pwd ){
            //"Kirjautuminen onnistui"
            $_SESSION['userid'] = $current_userid;
            $_SESSION['username'] = $current_user;
            $_SESSION['addedRows'] = "";
           
            if($_SESSION['admin']!='1'){
                header("Location: seuranta.php"); /* Redirect browser */
            }else{
                header("Location: valikko.php"); /* Redirect browser */
            }
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
        $_SESSION['addedRows'] .= "<tr><td>" .$userid . "</td><td>". $date . "</td><td>" .$place ."</td><td>" .$hours . "</td><td>
        " .$over_time ."</td><td>" .$weekend ."</td><td>" .$kilometers ."</td><td>" . $km_description ."</tr></td>";
        //return $_SESSION['addedRows'];
        return "Rivi tallennettiin tietokantaan onnistuneesti:";
    } else {
        return "Jotain meni pieleen. Yritä uudelleen";
    }
    
    //return $result;*/
}


function auth_failed(){
     return "Kirjautuminen epäonnistui. Tarkasta käyttäjätunnus";
}


?>