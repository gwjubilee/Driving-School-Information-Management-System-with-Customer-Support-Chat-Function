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

// import database
require_once "../include/connection.php";

$userrow = $database->query("SELECT * FROM instructor WHERE instructor_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$username=$userfetch["instructor_name"];

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- sidebar -->
<?php include "section/sidebar.php" ?>

<?php 
  date_default_timezone_set('Asia/Manila');

  $today = date('Y-m-d');

  $studentrow = $database->query("SELECT  * FROM  student;");
  $instructorrow = $database->query("SELECT  * FROM  instructor;");
  $enrollmentrow = $database->query("SELECT  * FROM  enrollment WHERE enrollment_date>='$today';");
  $schedulerow = $database->query("SELECT  * FROM  schedule WHERE schedule_date='$today';");
?>

<div class="main">

  <div class="container text-white">

    <!-- row 1 -->
    <div data-aos="fade-up" class="row" style="margin-top: 70px;">
      
      <div class="col text-center">
        <h1>Hello,</h1>
        <h2><span class="text-warning"><?php echo ucwords($username); ?></span>!</h2>
        <p class="lead" style="margin-top: 50px;">Together let's thrive for quality driving education.</p>
      </div>

    </div>

  <!-- Widgets  -->
  <div class="row" style="margin-top: 150px; margin-bottom: 100px;">
    <div data-aos="fade-right" data-aos-duration="1100" class="col">
        <div class="blog-shadow-dreamy">
          <div class="blog-shadow-dreamy-body">
            <svg class="bi pe-none" width="25" height="25"><use xlink:href="#school"/></svg>
            <h4><?php echo $studentrow->num_rows ?></h4>
            <p>Students</p>
          </div>
        </div>
    </div>

    <div data-aos="zoom-in" data-aos-duration="1300" class="col">
        <div class="blog-shadow-dreamy">
          <div class="blog-shadow-dreamy-body">
            <svg class="bi pe-none" width="25" height="25"><use xlink:href="#description"/></svg>
            <h4><?php echo $enrollmentrow->num_rows ?></h4>
            <p>New enrollments</p>
          </div>
        </div>
    </div>

    <div data-aos="fade-left" data-aos-duration="1500" class="col">
      <div class="blog-shadow-dreamy">
        <div class="blog-shadow-dreamy-body">
          <svg class="bi pe-none" width="25" height="25"><use xlink:href="#calendar-month"/></svg>
          <h4><?php echo $schedulerow->num_rows ?></h4>
          <p>Today schedule</p>
        </div>
      </div>
    </div>

    </div>
    
<!-- /Widgets -->

<!-- instructor-index.txt was here -->


  </div>
</div>
 

<!-- footer -->
<?php include "section/footer.php" ?>