<?php

session_start();

if(isset($_SESSION["user"])) {
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='instructor') {
      header("location: ../signin.php");
    } else {
        $useremail=$_SESSION["user"];
      }
  
    } else {
      header("location: ../signin.php");
    }


//import database
require_once "../include/connection.php";

if (!$database) {
    die("Connection failed: " . mysqli_connect_error());
}

$userrow = $database->query("SELECT * FROM instructor WHERE instructor_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["instructor_id"];
$username=$userfetch["instructor_name"];

if($_POST) {
    if(isset($_POST["set_schedule"])) {
      
        $instructor_id=$userid;
        $instructor_name=$username;
        $title=$_POST["title"];
        $course_type=$_POST["course_type"];
        $date=$_POST["date"];
        $time=$_POST["time"];

        $sql2="INSERT INTO schedule (instructor_id,instructor_name,title,course_type,schedule_date,schedule_time) values ('$instructor_id','$instructor_name','$title','$course_type','$date','$time')";
        
        $result= $database->query($sql2);
        if (!$result) {
            echo "Error: " . $sql2 . "<br>" . $database->error;
        }else{
        header("location: schedule.php?action=schedule_added&titleget=none");
        }

    }
}

?>
