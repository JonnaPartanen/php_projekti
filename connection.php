<?php

function get_database(){
    
    $dbhost= "127.0.0.1:49518";
    $dbname= "localdb";
    $dbusername= "azure";
    $dbpassword= "6#vWHD_$";
    
    
    //$config = parse_ini_file('config.ini'); 
    
   // $mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    $mysqli = new mysqli($dbhost, $dbname, $dbusername, $dbpassword);
    // Check connection
    if ($mysqli->connect_error) {
        return ("Connection failed: " . $myqli->connect_error);
    }else{
        //return "Connected successfully" . "<br>";
        return $mysqli;
    }
}




?>