<?php 
//session_start();
require_once('connection.php');


function login($email, $pwd){
    
    $sql = ("SELECT idhenkilo, sukunimi , etunimet, ktunnus, salasana, admin FROM henkilo WHERE ktunnus ='$email'");
    $result = execute_query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $current_userid=$row["idhenkilo"];
            $current_user = $row["sukunimi"]. ", " . $row["etunimet"]; 
            $sql_username=$row["ktunnus"];
            $sql_pwd=$row["salasana"];
            $_SESSION['admin']=$row["admin"];
        }
        if($sql_username==$email && password_verify($pwd, $sql_pwd) == true){
            //"Kirjautuminen onnistui"
            $_SESSION['userid'] = $current_userid;
            $_SESSION['username'] = $current_user;
            $_SESSION['addedRows'] = "";
           
            if($_SESSION['admin']!=true){
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

function update_hoursrow($eventId, $date, $hours, $overtime, $place, $kilometers, $km_description, $userid){
    $mysqli = get_database();
    if($stmt = $mysqli->prepare("UPDATE tuntiseuranta SET pvm=?, tyokohde=?, tunnit=?, ylityo=?, kilometrit=?, kmselite=? WHERE idtuntiseuranta=?")){
        $stmt->bind_param("ssssssi", $date, $place, $hours, $overtime, $kilometers, $km_description, $eventId);
        $stmt->execute();
        $stmt->close();
        $_SESSION['addedRows'] = "<tr id='$eventId'><td>" .$eventId . "</td><td>" .$userid . "</td><td>". $date . "</td><td>" .$place ."</td><td>" .$hours . "</td><td>
        " .$overtime ."</td><td>" .$kilometers ."</td><td>" . $km_description ."</td>
        <td><button type=\"button\" class=\"btn btn-success\"onClick=\"modifyRow('$eventId')\">Muokkaa</button></td>
        <td><button type=\"button\" class=\"btn btn-danger\" onclick=\"removeRow('$eventId')\">Poista</button></td></tr>";
        return "Rivi on päivitetty";
        
    }else{
        return $mysqli->errno . ' ' . $mysqli->error;
        $stmt->close();
    }
}

function insert_person($lname,$fname,$bdate,$veroNro,$address,$zipcode,$city,$phone,$email,$pass, $admin) {
    $mysqli = get_database();
    if($stmt = $mysqli->prepare("INSERT INTO henkilo (sukunimi, etunimet, syntymaaika, veronro, osoite, postinumero, kaupunki, puhnro, ktunnus, salasana, admin)
        VALUES (?,?,?,?,?,?, ?,?,?,?,?)")){
        $stmt->bind_param("ssssssssssi",$lname, $fname, $bdate, $veroNro, $address, $zipcode, $city, $phone, $email, $pass, $admin);
        //$result = execute_prepared_query($stmt);
        $stmt->execute();
        $stmt->close();
        return "Käyttäjä tallennettu tietokantaan";
    
    }else{
        return $mysqli->errno . ' ' . $mysqli->error;
        $stmt->close();
    }
   
    
}

function insert_hours($date, $hours, $overtime, $place, $kilometers, $km_description, $userid){
    $mysqli = get_database();
    
    if($stmt = $mysqli->prepare("INSERT INTO tuntiseuranta (pvm, tyokohde, tunnit, ylityo, kilometrit, kmselite, henkilo_idhenkilo)
	VALUES (?,?,?,?,?,?,?);")){
        $stmt->bind_param("ssssssi",$date, $place, $hours, $overtime, $kilometers, $km_description, $userid);
        $stmt->execute();
        $id= $mysqli->insert_id;
        $stmt->close();
        $_SESSION['addedRows'] = "<tr id='$id'><td>" .$id . "</td><td>" .$userid . "</td><td>". $date . "</td><td>" .$place ."</td><td>" .$hours . "</td><td>
        " .$overtime ."</td><td>" .$kilometers ."</td><td>" . $km_description ."</td>
        <td><button type=\"button\" class=\"btn btn-success\"onClick=\"modifyRow('$id')\">Muokkaa</button></td>
        <td> <button type=\"button\" name=\"remove\" class=\"btn btn-danger\"onClick=\"removeRow('$id')\">Poista</button></form></td></tr>";
        return "Rivi tallennettiin tietokantaan onnistuneesti: ".$id;
    }else{
        return $mysqli->errno . ' ' . $mysqli->error;
        $stmt->close();
    }
    
}

function get_personal_and_working_info($arguments, $names, $start_date, $end_date){
    $table_header="<table class='table table-hover table-dark'><thead><tr><th scope='col'>henkiloId";
    
    for ($i=0; $i < count($arguments); $i++){
        $table_header .= "<th scope='col'>".str_replace("'", "", $arguments[$i]) ."</th>";
    }
    $table_header .= "</tr></thead>";
    
    $sql = ("SELECT henkilo_idhenkilo,".str_replace("'","",implode(",", $arguments))." FROM henkilo join tuntiseuranta ON
        henkilo.idhenkilo = tuntiseuranta.henkilo_idhenkilo WHERE henkilo.idhenkilo IN (".implode(',',$names).")
        AND pvm BETWEEN '" .$start_date."' AND '".$end_date. "' ORDER BY henkilo.idhenkilo,pvm ");
    $result = execute_query($sql);
    $table_row="";
    $file_row="";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $table_row .= "<tr>";
            foreach ($row as $item) {
                $table_row .= "<td>". $item."</td>";
                $file_row .= "\t". $item;
            }
            $table_row .= "</tr>";
            $file_row .= "\n";
        }
      $html_table=$table_header. $table_row. "</table>";
      
      $file = $file_row;
      $myfile = fopen("C:\Users\User1\myfile.txt", "w") or die("Unable to open file!");
      fwrite($myfile, $file);
      
      echo fread($myfile,filesize('C:\Users\User1\myfile.txt'));
      fclose($myfile); 
      
      //exec("notepad.exe". "C:\Users\User1\myfile.txt");
      
      return $html_table;
      
    } else {
        //return "Antamillasi hakuehdoilla ei löytynyt tuloksia";
        return $sql;
    }
}

function get_personal_info($arguments, $names){
    $table_header="<table class='table table-hover table-dark'><thead><tr><th scope='col'>henkiloId";
    
    for ($i=0; $i < count($arguments); $i++){
        $table_header .= "<th scope='col'>".str_replace("'", "", $arguments[$i]) ."</th>";
    }
    $table_header .= "</tr></thead>";
    
    $sql = ("SELECT idhenkilo,".str_replace("'","",implode(",", $arguments))." FROM henkilo WHERE idhenkilo IN (".implode(',',$names).") 
    ORDER BY idhenkilo");
    $result = execute_query($sql);
    $table_row="";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $table_row .= "<tr>";
            foreach ($row as $item) {
                $table_row .= "<td>". $item."</td>";
            }
            $table_row .= "</tr>";
        }
        $html_table=$table_header. $table_row. "</table>";
        return $html_table;
    } else {
        return "Antamillasi hakuehdoilla ei löytynyt tuloksia";
        //return $sql;
    }
    
}

function getNames(){
    $_SESSION['populate_drop_down']="";
    $sql = "SELECT idhenkilo, sukunimi, etunimet FROM henkilo;";
    $result = execute_query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $current_userid=$row["idhenkilo"];
            $current_user = $row["sukunimi"]. ", " . $row["etunimet"]; 
            $_SESSION['populate_drop_down'] .= '<option value="'.$current_userid.'">'.$current_user.'</option>';
        }
    } 
    else {
        return "SQL failure";
    }
}
function auth_failed(){
    return "Antamillasi hakuehdoilla ei löytynyt tuloksia";
}


?>