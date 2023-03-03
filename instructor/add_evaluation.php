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

$userrow = $database->query("SELECT * FROM instructor WHERE instructor_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["instructor_id"];
$username=$userfetch["instructor_name"];

date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');
  
?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container text-white">


  	<div class="row">
        <div data-aos="fade-up" class="col">
            <a href="evaluations.php" class="text-warning" style="font-size: larger; margin-left: 10px;"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
        </div>
    </div>


    <div class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
        <div data-aos="fade-up" class="col">
            <h3>Pending students for grading</h3>
        </div>
    </div>

	<div class="row flex justify-content-center">
		<div class="col-8 flex justify-content-center">

		<table data-aos="fade-up" class="styled-table">
            <thead>
                <tr>
                <th>Student ID </th>
                <th>Student Name</th>
							  <th>Course Type</th>
                <th>Instructor</th>
                <th>Remark</th>
                </tr>
            </thead>
			<tbody>
				<?php

					// BASING FROM THE BREAK POINT PLESE INNER JOIN THE ENROLLMENT.TITLE TO EVALUATIONS.TITLE
					// select the evaluations of the current logged in student based on the student_id
					$enrollment_status = "Approved";

					// $sqlmain = "SELECT * FROM evaluations WHERE instructor_id = '$userid'";

					// sql should apply
					// $sqlmain = "SELECT * FROM enrollment WHERE enrollment_status = '$enrollment_status' AND instructor_id = '$userid'";


					// WILL THIS WORK?
					$sqlmain = "SELECT * FROM enrollment WHERE enrollment_status = '$enrollment_status' AND instructor_id = '$userid'";


					$result= $database->query($sqlmain);
                    if($result->num_rows==0) {
						echo '
						<div data-aos="fade-up" data-aos-duration="1700" class="row" style="position: absolute; margin-top: 100px; left: 48%;">
						<div>
							<img src="../asset/img/undraw_taken.svg" width="25%">
							<p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
						</div>
						</div>';

					} else {

					for ($x=0; $x<$result->num_rows;$x++) {
						$row=$result->fetch_assoc();
						$enrollment_id = $row["enrollment_id"];
						$student_id = $row["student_id"];
						$student_name = $row["student_name"];

						$course_type = $row["course_type"];
						$instructor_id = $row["instructor_id"];
						$instructor_name = $row["instructor_name"];
						echo '
						<tr>
							<td>'.$student_id.'</td>
							<td>'.$student_name.'</td>
						
							<td>'.$course_type.'</td>
							<td>'.$instructor_name.'</td>
							<td>
							<a href="passed_evaluation.php?id='.$enrollment_id.'" class="btn btn-success btn-sm" style="margin:auto auto 5px auto;">Pass</a> <br>
							<a href="failed_evaluation.php?id='.$enrollment_id.'" class="btn btn-danger btn-sm" style="margin:auto;">Fail</a>
							</td>
						</tr>
						';
					}
				}
				?>
					</tbody>
				</table>

		</div>
	</div>

<!-- end container -->
  </div>
</div>

<!-- footer -->
<?php include "section/footer.php" ?>