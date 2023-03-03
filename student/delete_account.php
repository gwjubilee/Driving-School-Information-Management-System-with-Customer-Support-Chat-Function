<?php

session_start();

if(isset($_SESSION["user"])) {
if(($_SESSION["user"])=="" or $_SESSION['usertype']!='student') {
    header("location: ../signin.php");
} else {
    $useremail=$_SESSION["user"];
}

} else {
    header("location: ../signin.php");
}

//import database
require_once "../include/connection.php";

$userrow = $database->query("SELECT * FROM student WHERE student_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["student_id"];
$username=$userfetch["student_name"];

    
if($_GET) {
    $id=$_GET["id"];
    $result001= $database->query("SELECT * FROM student where student_id=$id;");
    $email=($result001->fetch_assoc())["student_email"];
    $sql= $database->query("DELETE FROM webuser WHERE email='$email';");
    $sql= $database->query("DELETE FROM student WHERE student_email='$email';");
    header("location: ../include/signout.php");
}

?>