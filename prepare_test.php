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
function execute_prepared_query($stmt){
    
   
    $result = $stmt-> execute();
    
    $stmt->close();
    return $result;
    
}

function execute_query($sql_query) {
    $mysqli = get_database();
    $sql = $sql_query;
    $result = $mysqli->query($sql);
    
    $mysqli->close();
    return $result;
}


?>