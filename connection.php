<?php

function get_database(){
    
    
    $config = parse_ini_file('config.ini'); 
    
    $mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    
    // Check connection
    if ($mysqli->connect_error) {
        return ("Connection failed: " . $myqli->connect_error);
    }else{
        //return "Connected successfully" . "<br>";
        return $mysqli;
    }
}


function execute_query($sql_query) {
    $mysqli = get_database();
    $sql = $sql_query;
    $result = $mysqli->query($sql);
    
    $mysqli->close();
    return $result;
}


?>