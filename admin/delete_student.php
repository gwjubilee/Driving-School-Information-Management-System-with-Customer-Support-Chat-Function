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
        $result001= $database->query("SELECT * FROM student WHERE student_id=$id;");
        $email=($result001->fetch_assoc())["student_email"];
        $sql= $database->query("DELETE FROM webuser WHERE email='$email';");
        $sql= $database->query("DELETE FROM student WHERE student_email='$email';");
        header("location: student.php");
    }

?>