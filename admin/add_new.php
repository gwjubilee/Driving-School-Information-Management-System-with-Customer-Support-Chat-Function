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

//import database
require_once "../include/connection.php";


if($_POST) {
    $result= $database->query("SELECT * FROM webuser");
    $name=$_POST['name'];
    $email=$_POST['email'];
    $instructor_phone=$_POST['instructor_phone'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    
    if($password==$cpassword) {
        $error='3';
        $result= $database->query("SELECT * FROM webuser where email='$email';");
        if($result->num_rows==1) {
            $error='1';
        } else {

            $sql1="INSERT INTO instructor(instructor_email,instructor_name,instructor_password,instructor_phone) VALUES ('$email','$name','$password','$instructor_phone');";
            $sql2="INSERT INTO webuser values('$email','instructor')";
            $database->query($sql1);
            $database->query($sql2);
            $error= '4';
        }
    } else {
        $error='2';
    }  
} else {
    $error='3';
}

header("location: instructor.php?action=add&error=".$error);
?>