<?php

session_start();

if(isset($_SESSION["user"])) {
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='admin') {
        header("location: ../signin.php");
    } else {
    $useremail=$_SESSION["user"];
  }
}else{
    header("location: ../signin.php");
}

    
if($_POST) {
//import database
require_once "../include/connection.php";
$course_type=$_POST["course_type"];
$instructor_id=$_POST["instructor_id"];
$date=$_POST["date"];
$time=$_POST["time"];
$sql="INSERT INTO schedule(instructor_id,course_type,schedule_date,schedule_time) values($instructor_id,'$course_type','$date','$time');";
$result= $database->query($sql);
header("location: schedule.php?action=schedule_added&course_type=$course_type");

}

?>