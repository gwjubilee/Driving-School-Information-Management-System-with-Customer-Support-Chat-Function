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

date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');

//import database
require_once "../include/connection.php";

if($_GET) {
    $id=$_GET["id"];

    $get_request = "SELECT * FROM enrollment WHERE enrollment_id = '$id'";
    $result = mysqli_query($database, $get_request);

    $request = mysqli_fetch_assoc($result);

    $student_id = $request['student_id'];
    $student_name = $request['student_name'];
    $title = $request['title'];
    $course_type = $request['course_type'];

    $remark = 'Failed';

    $instructor_id = $request['instructor_id'];
    $instructor_name = $request['instructor_name'];



    if($result) {
      
      $insert_enrollment = "INSERT INTO evaluations (student_id, student_name, title, course_type, remark, evaluation_date, instructor_id, instructor_name) VALUES ('$student_id', '$student_name', '$title', '$course_type', '$remark', '$today', '$instructor_id', '$instructor_name')";
      $result1 = mysqli_query($database, $insert_enrollment);

      
      $delete_enrollment = "DELETE FROM enrollment WHERE enrollment_id = '$id'";
      $result2 = mysqli_query($database, $delete_enrollment);
      
      
      header("location: evaluations.php?action=success&id=".$id."");

    } else {
        echo 'Error: ' . mysqli_error($database);
    }

  } else {
    echo 'Error: ' . mysqli_error($database);
}
?>