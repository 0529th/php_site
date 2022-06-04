<?php
    $host = "localhost";
    $user = "grhimpan2";
    $pass = "dz!en940318";
    $db = "grhimpan2";
    $connect = new mysqli($host, $user, $pass, $db);
    $connect -> set_charset("utf8");
    
    if(mysqli_connect_errno()) {
        echo "DATABASE connect false";
    } else {
        // echo "DATABASE connect true";
    }
?>