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
    
if($_GET) {
  //import database
  require_once "../include/connection.php";
  $id=$_GET["id"];
  $sql= $database->query("DELETE FROM enrollment, enrollment_requests WHERE enrollment_id = '$id' AND enrollment_request_id = '$id'");
  header("location: enrollment.php");
}


?>