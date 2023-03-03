<?php
ob_start();
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


	if(isset($_POST['submit'])) {

		//import database
		require_once "../include/connection.php";

		$userrow = $database->query("SELECT * FROM instructor WHERE instructor_email='$useremail'");
		$userfetch=$userrow->fetch_assoc();
		$userid= $userfetch["instructor_id"];
		$username=$userfetch["instructor_name"];

		date_default_timezone_set('Asia/Manila');

		$today = date('Y-m-d');

		$student_id =  $_POST['student_id'];
		$student_name =  $_POST['student_name'];
		$comment= $_POST['comment'];
		$remark = $_POST['remark'];
		$evaluation_date = $today;
		$instructor_id = $userid;
		$instructor_name = $username;


		$sql = "SELECT * FROM evaluations WHERE student_id='$student_id' AND evaluation_date='$evaluation_date'";
		$result = $database->query($sql);
		if($result->num_rows > 0){
			$_SESSION['error'] = 'You have already done that.';
		} else {
			$sql = "INSERT INTO evaluations (`student_id`, `student_name`, `comment`, `remark`, `evaluation_date`, `instructor_id`, `instructor_name`) 
			VALUES ('$student_id','$student_name','$comment','$remark','$evaluation_date','$instructor_id','$instructor_name')";
			$result = $database->query($sql);
			if($result) {
				header('location: evaluations?action=success');
			} else {
				$_SESSION['error'] = 'Something went wrong while adding.';
			}
		}	

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}
		header('location: evaluations.php');

?>