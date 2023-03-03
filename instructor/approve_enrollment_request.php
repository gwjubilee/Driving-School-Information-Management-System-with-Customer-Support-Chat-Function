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
    
    // before
    // $enrollment_status = 'Approved';
    // $sql = "UPDATE enrollment_request SET enrollment_status = '$enrollment_status' WHERE student_id='$id'";
    // $query = mysqli_query($database, $sql);

    // if ($query) {
      // echo $id;
        // Get the student and schedule ID from the request
        $get_request = "SELECT * FROM enrollment_request WHERE enrollment_request_id = '$id'";
        $result = mysqli_query($database, $get_request);
        $request = mysqli_fetch_assoc($result);
        $student_id = $request['student_id'];
        $student_name = $request['student_name'];
        $schedule_id = $request['schedule_id'];
        $today = $request['enrollment_date'];
        $title = $request['title'];
        $course_type = $request['course_type'];
        $instructor_id = $request['instructor_id'];
        $instructor_name = $request['instructor_name'];
        $student_address = $request['student_address'];
        $student_phone = $request['student_phone'];
        $student_birthdate = $request['student_birthdate'];
        $student_age = $request['student_age'];
        $student_classification = $request['student_classification'];
        $student_restriction_code_number = $request['student_restriction_code_number'];
        $student_civil_status = $request['student_civil_status'];
        $student_parent_guardian = $request['student_parent_guardian'];
        $student_parent_guardian_address = $request['student_parent_guardian_address'];
        $student_parent_guardian_home_phone = $request['student_parent_guardian_home_phone'];
        $student_parent_guardian_email = $request['student_parent_guardian_email'];
        $student_transmission = $request['student_transmission'];
        $enrollment_status = 'Approved';

        // Insert the student into the enrolled students list
        $insert_enrollment = "INSERT INTO enrollment(student_id, student_name, schedule_id, enrollment_date, enrollment_status, title, course_type, instructor_id, instructor_name, student_address, student_phone, student_birthdate, student_age, student_classification, student_restriction_code_number, student_gender, student_civil_status, student_religion, student_parent_guardian, student_parent_guardian_address, student_parent_guardian_home_phone, student_parent_guardian_email, student_transmission) VALUES ('$student_id', '$student_name ', '$schedule_id', '$today', '$enrollment_status', '$title', '$course_type', '$instructor_id', '$instructor_name', '$student_address', '$student_phone', '$student_birthdate', '$student_age', '$student_classification', '$student_restriction_code_number', '$student_gender', '$student_civil_status', '$student_religion', '$student_parent_guardian', '$student_parent_guardian_address', '$student_parent_guardian_home_phone', '$student_parent_guardian_email', '$student_transmission')";
        
        $result = mysqli_query($database, $insert_enrollment);
        if($result) {
          $enrollment_status = 'Approved';

          $sql = "UPDATE enrollment_request SET enrollment_status = '$enrollment_status'";
          $query = mysqli_query($database, $sql);
          
            header("location: enrollment_request.php?action=approve_success&id='.$id.'");
        } else {
            echo 'Error: ' . mysqli_error($database);
        }

    } else {
        echo 'Error: ' . mysqli_error($database);
    }
// end for POST
 
// }else {
//   echo 'If you see this error message, then this is indicating that the $userfetch or mysqli_fetch_assoc variable is null, which means that the query $userrow = mysqli_query($database, "...") did not return any rows. As a result, trying to access the database field keys in $userfetch or mysqli_fetch_assoc variable is causing an error.';
// }
?>