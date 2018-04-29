<?php
session_start();

    if (empty($_SESSION['userid'])) {
    
        header("Location: index.php"); /* Redirect browser */;
    }elseif($_SESSION['admin']!=true){
        header("Location: seuranta.php"); /* Redirect browser */;
}

?>