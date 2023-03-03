<?php

    $database= new mysqli("localhost","root","","_driving_school_name");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>