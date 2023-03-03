<?php

session_start();

if(isset($_SESSION["user"])) {
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='admin') {
        header("location: ../signin.php");
    } else {
    $useremail=$_SESSION["user"];
  }
} else {
    header("location: ../signin.php");
}

    if($_GET) {
        require_once "../include/connection.php";
        $id=$_GET["id"];
        $result001= $database->query("SELECT * FROM instructor WHERE instructor_id=$id;");
        $email=($result001->fetch_assoc())["instructor_email"];
        $sql= $database->query("DELETE FROM webuser WHERE email='$email';");
        $sql= $database->query("DELETE FROM instructor WHERE instructor_email='$email';");
        header("location: instructor.php");
    }

?>