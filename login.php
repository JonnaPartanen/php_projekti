<?php 
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $testi = "Testimuuttuja";
    
    
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
    
    
    $sql = "SELECT * FROM henkilo WHERE ktunnus = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["etunimet"]. " - Name: " . $row["sukunimi"]. " " . $row["ktunnus"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    
    $conn->close();


?>