<?php

session_start();

if(isset($_SESSION["user"])) {
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='admin') {
        header("location: ../signin.php");
    } else {
    $useremail=$_SESSION["user"];
  }
} else {
    header("location: ../signin.php");
}

//import database
require_once "../include/connection.php";

$userrow = $database->query("SELECT * FROM admin WHERE admin_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$useremail=$userfetch["admin_email"];

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container bg-dark text-white">

    <?php 
    date_default_timezone_set('Asia/Manila');

    $today = date('Y-m-d');

    $studentrow = $database->query("SELECT * FROM student;");
    $instructorrow = $database->query("SELECT * FROM instructor;");
    $enrollmentrow = $database->query("SELECT * FROM enrollment WHERE enrollment_date>='$today';");
    $schedulerow = $database->query("SELECT * FROM schedule WHERE schedule_date='$today';");

    ?>
    </p>

    <!-- row 1 -->
    <div class="row justify-content-center text-center">
      <h3 data-aos="zoom-in" style="margin-top: 30px; margin-bottom: 40px;">Status</h3>
      <!-- number of instructors -->
      <div data-aos="fade-right" data-aos-duration="1100"class="col-md-3 mr-auto text-dark text-center">
        <div class="small-box rounded bg-warning">
          <div style="padding: 10px;">
          <h3><?php echo $instructorrow->num_rows ?></h3>
          </div>
          <div class="text-center" style="margin-top: 20px; padding-bottom: 1px;">
            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#badge"/></svg>
            <p>Instructors</p>
          </div>
        </div>
      </div>
      
      <!-- number of students -->
      <div data-aos="fade-left" data-aos-duration="1200" class="col-md-3 mr-auto text-dark text-center">
        <div class="small-box rounded bg-warning">
          <div style="padding: 10px;">
          <h3><?php echo $studentrow->num_rows ?></h3>
          </div>
          <div style="margin-top: 20px; padding-bottom: 1px;">
            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#school"/></svg>
            <p>Students</p>
          </div>
        </div>
      </div>

    </div>

  <div  class="row justify-content-center" style="margin-top: 30px;">

    <!-- number of enrollments -->
    <div data-aos="fade-right" data-aos-duration="1300" class="col-md-3 mr-auto text-dark text-center">
      <div class="small-box rounded bg-warning">
        <div style="padding: 10px;">
        <h3><?php echo $enrollmentrow->num_rows ?></h3>
        </div>
        <div style="margin-top: 20px; padding-bottom: 1px;">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#description"/></svg>
          <p>New Enrollments</p>
        </div>
      </div>
    </div>

    <!-- number of schedules -->
    <div data-aos="fade-left" data-aos-duration="1350" class="col-md-3 mr-auto text-dark text-center">
      <div class="small-box rounded bg-warning">
        <div style="padding: 10px;">
        <h3><?php echo $schedulerow->num_rows ?></h3>
        </div>
        <div class="text-center" style="margin-top: 20px; padding-bottom: 1px;">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#calendar-month"/></svg>
          <p>Today Schedules</p>
        </div>
      </div>
    </div>

  </div>


  <!-- row 2 -->
  <div class="row justify-content-center text-white" style="margin-top: 50px;">

    <div data-aos="fade-up" class="col">
      <h4 class="text-center" style="margin-top: 50px; margin-bottom: 40px;">Upcoming <span class="text-warning">enrollments</span> until next <span class="text-warning"><?php echo date("l",strtotime("+1 week")); ?></span></h4>

      <table class="styled-table">
        <thead>
          <tr>
          <th>Enrolment ID</th>
          <th>Student</th>
          <th>Instructor</th>
          <th>Schedule</th>
          
          </tr>
        </thead>

      <?php
      $nextweek=date("Y-m-d",strtotime("+1 week"));
      $sqlmain= "SELECT enrollment.enrollment_id,schedule.schedule_id,schedule.title,instructor.instructor_name,student.student_name,schedule.schedule_date,schedule.schedule_time,enrollment.enrollment_date FROM schedule INNER JOIN enrollment ON schedule.schedule_id=enrollment.schedule_id INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id  WHERE schedule.schedule_date>='$today' AND schedule.schedule_date<='$nextweek' ORDER BY schedule.schedule_date DESC";

      $result= $database->query($sqlmain);

      if($result->num_rows==0) {
      echo '
      <div class="row" style="position: absolute; margin-top: 80px; left: 44%;">
      <div class="col">
        <img src="../asset/img/undraw_taken.svg" width="25%">
        <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
      </div>
      </div>
      ';
      } else {
      for ( $x=0; $x<$result->num_rows;$x++) {
      $row=$result->fetch_assoc();
      $enrollment_id=$row["enrollment_id"];
      $schedule_id=$row["schedule_id"];
      $title=$row["title"];
      $instructor_name=$row["instructor_name"];
      $schedule_date=$row["schedule_date"];
      $schedule_time=$row["schedule_time"];
      $student_name=$row["student_name"];
      $enrollment_id=$row["enrollment_id"];
      $enrollment_date=$row["enrollment_date"];
      echo '
      <tbody>
      <tr>
          <td>'.$enrollment_id.'</td>
          <td>'.$student_name.'</td>
          <td>'.$instructor_name.'</td>
          <td>'.$enrollment_id.'</td>
          <td>'.$title.'</td>
      </tr>
      </tbody>
      ';
      }
      }
      ?>
      </table>

    </div>
  </div>


  <!-- 2nd table -->
  <br><br><br><br><br><br><br><br><br><br>
  <div class="row justify-content-center text-white" style="margin-top: 100px; margin-bottom: 350px;">

  <div data-aos="fade-up" class="col">
    <h3 class="text-center" style="margin-top: 50px; margin-bottom: 40px;">Upcoming <span class="text-warning">schedules</span> until next <span class="text-warning"><?php echo date("l",strtotime("+1 week")); ?></span></h3>

    <table class="styled-table">
      <thead>
        <tr>
      
        <th>Course Type</th>
        <th>Instructor</th>
        <th>Schedule Date</th>
        <th>Time Starts</th>
        </tr>
      </thead>

    <?php
    $nextweek=date("Y-m-d",strtotime("+1 week"));
    $sqlmain= "SELECT schedule.schedule_id,schedule.title,schedule.course_type,instructor.instructor_name,schedule.schedule_date,schedule.schedule_time FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id  WHERE schedule.schedule_date>='$today' AND schedule.schedule_date<='$nextweek' ORDER BY schedule.schedule_date DESC"; 
    $result= $database->query($sqlmain);

    if($result->num_rows==0) {
    echo '
    <div class="row" style="position: absolute; margin-top: 100px; left: 44%;">
    <div class="col">
      <img src="../asset/img/undraw_taken.svg" width="25%">
      <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
    </div>
    </div>
    ';

    } else {
    for ( $x=0; $x<$result->num_rows;$x++) {
    $row=$result->fetch_assoc();
    $schedule_id=$row["schedule_id"];
    $title=$row["title"];
    $course_type=$row["course_type"];
    $instructor_name=$row["instructor_name"];
    $schedule_date=$row["schedule_date"];
    $schedule_time=$row["schedule_time"];
    echo '
    <tbody>
    <tr>
  
      <td>'.$course_type.'</td>
      <td>'.$instructor_name.'</td>
      <td>'.$schedule_date.'</td>
      <td>'.$schedule_time.'</td>
    </tr>
    </tbody>

    ';

    }
    }

    ?>

    </table>

  </div>
  </div>

  </div>
</div>

<!-- footer -->
<?php include "section/footer.php" ?>