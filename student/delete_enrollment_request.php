<?php

session_start();

if(isset($_SESSION["user"])) {
  if(($_SESSION["user"])=="" or $_SESSION['usertype']!='student') {
    header("location: ../signin.php");
  } else {
    // access the current user's session variable
    $useremail=$_SESSION["user"];
  }

} else {
    header("location: ../signin.php");
}
    
if($_GET) {

  //import database
  require_once "../include/connection.php";
  $userrow = $database->query("SELECT * FROM student where student_email='$useremail'");
  $userfetch=$userrow->fetch_assoc();
  $userid= $userfetch["student_id"];
  $username=$userfetch["student_name"];
  $student_email=$userfetch["student_email"];

  // update the value of the session variable
  $useremail['user'] = $student_email;
  
  $id=$_GET["id"];
  $sql= $database->query("DELETE FROM enrollment_request where enrollment_request_id='$id';");
  header("location: enrollment_request.php");

  // store the updated value back in the session
  $_SESSION['user'] = $useremail;
}

?>