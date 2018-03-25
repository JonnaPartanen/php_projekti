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
    echo "Connected successfully" . "<br>";
    
    
    $sql = "SELECT * FROM henkilo WHERE ktunnus = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $current_user = $row["sukunimi"]. ", " . $row["etunimet"]; 
            $sys_username=$row["ktunnus"];
            $sys_pwd=$row["salasana"];
        }
        if($sys_username==$email && $sys_pwd==$pwd ){
            echo "Kirjautuminen onnistui";
            header("Location: seuranta.html"); /* Redirect browser */
        }else{
            header("Location: index.html");
            //echo "Tarkista käyttäjänimi ja salasana";
        }
    } else {
        echo "0 results";
    }
    
    $conn->close();
     


?>