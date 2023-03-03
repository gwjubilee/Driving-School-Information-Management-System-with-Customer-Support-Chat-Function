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

//import database
require_once "../include/connection.php";

$userrow = $database->query("SELECT * FROM student WHERE student_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["student_id"];
$username=$userfetch["student_name"];
  
?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container text-white">

  <div data-aos="fade-up" class="row" style="margin-top: 30px; margin-bottom: 50px;">

	<div class="col-9 flex" style="margin-left: 70px;">
		<h3 data-aos="fade-up" data-aos-duration="1000" style="margin-bottom: 20px;">Evaluation for <span class="text-warning"><?php echo ucwords($username); ?></span></h3>

		<p style="margin-top: 20px;">Below is the result of your performance.</p>
		<p><i>Note: Only the authorized instructor can evaluate the students.</i></p>	
	</div>

	<div class="col-2">
		<img src="../asset/img/undraw_accept_request_04.svg" width="170" style="margin-top: 10px;">
	</div>

</div>


	<div class="row text-center" >
		<div class="col">	
				
			<?php
				if(isset($_SESSION['error'])){
					echo
					"<div class='alert alert-danger text-center'><button class='close'>&times;</button>".$_SESSION['error']."</div>";
					unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
					echo
					" <div class='alert alert-success text-center'><button class='close'>&times;</button>".$_SESSION['success']."</div>";
					unset($_SESSION['success']);
				 // header("Refresh: 1; evaluations.php");
				}
			?>

			</div>
	</div>
	
	<div class="text-center" data-aos="fade-up" data-aos-duration="1000">
<a href="download.php"<span style="color:white;"><button class="btn btn-outline-warning btn-sm">Download</button></span></a>
</div>
<div>

	<div class="row" style="margin-left: auto; margin-top: 30px; margin-bottom: 270px;">
        <div data-aos="fade-up" class="col">
           <table class="styled-table">
            <thead>
                <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Remark</th>
                <th>Date Evaluated</th>
                <th>Evaluated By</th>
                </tr>
            </thead>
			<tbody> 


				<?php
				// select the evaluations of the current logged in student based on the student_id
				$sqlmain = "SELECT * FROM evaluations WHERE student_id=$userid";

				$result= $database->query($sqlmain);
				if($result->num_rows==0) {
					echo '
					<div class="row" style="position: absolute; margin-top: 100px; left: 41%;">
					<div data-aos="fade-up" class="col">
						<img src="../asset/img/undraw_taken.svg" width="25%">
						<p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
					</div>
					</div>';

				} else {
					for ($x=0; $x<$result->num_rows;$x++) {
					$row=$result->fetch_assoc();

					$student_id = $row["student_id"];
					$student_name = $row["student_name"];
					$remark = $row["remark"];
					$evaluation_date = $row["evaluation_date"];
					$instructor_name = $row["instructor_name"];
					echo '
					<tr>
					<td>'.$student_id.'</td>
					<td>'.$student_name.'</td>
					<td class="text-info">'.$remark.'</td>
					<td>'.$evaluation_date.'</td>
					<td>'.$instructor_name.'</td>
					</tr>
					';

					}
				}
			?>
						</tbody>
				</table>
		</div>
	</div>

  </div>
</div>				


<!-- footer -->
<?php include("section/footer.php"); ?>