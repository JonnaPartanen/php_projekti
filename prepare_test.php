<?php 

function get_database(){
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mydb";
    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($mysqli->connect_error) {
       return ("Connection failed: " . $myqli->connect_error);
    }else{
    //return "Connected successfully" . "<br>";
     return $mysqli;
    }
}
function execute_query($stmt){
    
   
    $result = $stmt-> execute();
    
    $stmt->close();
    return $result;
    
}
function get_mysqli(){
    return $mysqli;
}

?>