<?php 
function get_database($sql_query){
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mydb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
       return ("Connection failed: " . $conn->connect_error);
    }else{
    //return "Connected successfully" . "<br>";
    
    
    $sql = $sql_query;
    $result = $conn->query($sql);
    
    $conn->close();
    return $result;
    }
}


?>