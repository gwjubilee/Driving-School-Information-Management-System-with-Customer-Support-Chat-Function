<?php
ob_start();
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


// // THERE SEEMS TO BE AN ERROR HERE
// $userrow = mysqli_query($database, "SELECT * FROM enrollment_request 
// INNER JOIN schedule
// ON enrollment_request.schedule_id = schedule.schedule_id
// INNER JOIN student 
// ON enrollment_request.student_id = student.student_id 
// WHERE student.student_email='$useremail'") or die(mysqli_error($database));

$userrow = mysqli_query($database, "SELECT * FROM schedule,student WHERE student_email='$useremail'") or die(mysqli_error($database));

if (mysqli_num_rows($userrow) > 0) {
$userfetch = mysqli_fetch_assoc($userrow);

$userid = $userfetch["student_id"];
$username = $userfetch["student_name"];
$title = $userfetch["title"];
$course_type = $userfetch["course_type"];

// echo $userid;
// echo $username;

date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');

if (isset($_POST['enroll'])) {

  $schedule_id = $_POST["schedule_id"];
  $today = $_POST["date"];

  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $name = $first_name . " " .$last_name;

  $title = $_POST["title"];
  $course_type = $_POST["course_type"];
  $instructor_name = $_POST["instructor_name"];
  $instructor_id = $_POST["instructor_id"];

  $enrollment_status = "Pending";

  $student_address = $_POST["address"];
  $student_phone = $_POST["home_phone"];
  $student_birthdate = $_POST["date_of_birth"];
  $student_age = $_POST["age"];
  $student_classification = $_POST["student_classification"];
  $student_restriction_code_number = $_POST["restriction_code_number"];
  $student_gender = $_POST["gender"];
  $student_civil_status = $_POST["civil_status"];
  $student_religion = $_POST["religion"];
  $student_parent_guardian = $_POST["parent_guardian"];
  $student_parent_guardian_address = $_POST["parent_guardian_address"];
  $student_parent_guardian_home_phone = $_POST["parent_guardian_home_phone"];
  $student_parent_guardian_email = $_POST["email"];
  $student_transmission = $_POST["student_transmission"];



  // // tests
  // echo $schedule_id;
  // echo $name;
  // echo $today;
  // echo $enrollment_status;

// $inputs = array('first_name','last_name','address','home_phone','date_of_birth','age','student_classification','restriction_code_number','gender','civil_status','religion','parent_guardian','parent_guardian_address','parent_guardian_home_phone','email','student_transmission');

// $empty_inputs = array();
// foreach ($inputs as $input) {
//     if (empty($_POST[$input])) {
//         $empty_inputs[] = $input;
//     }
// }

// if(count($empty_inputs)>0) {
//     echo "Error: ".implode(', ',$empty_inputs)." are empty";
// } else {

    // process form data
    $select_result = mysqli_query($database, "SELECT * FROM enrollment_request WHERE student_id = '$userid' AND schedule_id = '$schedule_id'");

    if (mysqli_num_rows($select_result) > 0) {
      header("location: schedule.php?action=ongoing_application&id=".$userid."");
    } else {
  
      $insert_result = mysqli_query($database,"INSERT INTO enrollment_request (student_id, student_name, schedule_id, enrollment_date, enrollment_status, title, course_type, instructor_id, instructor_name, student_address, student_phone, student_birthdate, student_age, student_classification, student_restriction_code_number, student_gender, student_civil_status, student_religion, student_parent_guardian, student_parent_guardian_address, student_parent_guardian_home_phone, student_parent_guardian_email, student_transmission) VALUES ('$userid', '$name', '$schedule_id', '$today', '$enrollment_status', '$title', '$course_type', '$instructor_id', '$instructor_name', '$student_address', '$student_phone', '$student_birthdate', '$student_age', '$student_classification', '$student_restriction_code_number', '$student_gender', '$student_civil_status', '$student_religion', '$student_parent_guardian', '$student_parent_guardian_address', '$student_parent_guardian_home_phone', '$student_parent_guardian_email', '$student_transmission')");
  
      if($insert_result) {
        header("location: schedule.php?action=success&id=".$userid."");
      } else {
        // Insert query was not successful
        echo 'Error: ' . mysqli_error($database);
      }
      
    }
// }

} // end for POST

} else {
  echo 'If you see this error message, then this is indicating that the $userfetch or mysqli_fetch_assoc variable is null, which means that the query $userrow = mysqli_query($database, "...") did not return any rows. As a result, trying to access the database field keys in $userfetch or mysqli_fetch_assoc variable is causing an error.';
}

?>