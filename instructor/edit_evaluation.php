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

	<div class="row flex justify-content-center">
		<div class="col-8 flex justify-content-center">

		<!-- stopped here plan to make student name readonly -->
		<!-- comment and remark is editable -->


			<form action="edit.php" method="POST">
			<h3 class="text-warning text-center" style="margin-bottom: 50px; margin-top: 50px;">Evaluate Student</h3>

			<div class="form__group field">
			<input type="text" class="form__field" name="comment" placeholder="Comment" readonly>
			<label for="comment" class="form__label">Comment</label>
			</div>

			<div class="form__group field">
			<input type="text" class="form__field" name="comment" placeholder="Comment" required>
			<label for="comment" class="form__label">Comment</label>
			</div>

			<div class="form__group field">
			<select name="remark" style="padding: 7px;" required>
				<option value="" >Select Remark</option>
				<option value="PASSED">PASSED</option>
				<option value="FAILED">FAILED</option>
			</select>
			</div>

			<div class="form__group field">
			<a href="evaluations.php" class="btn btn-danger btn-sm" style="margin: 7px;">Cancel</a>
			<button type="submit" name="submit" class="btn btn-warning btn-sm">Post</button>
			</div>

			</form>
		</div>
	</div>

<!-- end container -->
  </div>
</div>

<!-- footer -->
<?php include "section/footer.php" ?>