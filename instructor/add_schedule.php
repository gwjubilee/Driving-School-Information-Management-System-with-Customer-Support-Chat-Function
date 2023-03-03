<?php

//learn from w3schools.com

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


// echo $userid;
// echo $username;


date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');


?>


<!-- header -->
<?php include "section/header.php" ?>

<!-- sidebar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container text-white">

    <?php
    if(isset($_GET["id"])) {
        $id=$_GET["id"];
        $sqlmain= "SELECT * FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE schedule.schedule_id=$id ORDER BY schedule.schedule_date DESC";
        //echo $sqlmain;
        $result= $database->query($sqlmain);
        $row=$result->fetch_assoc();
        $schedule_id=$row["schedule_id"];
        $title=$row["title"];
        $course_type=$row["course_type"];
        $schedule_date=$row["schedule_date"];
        $schedule_time=$row["schedule_time"];
        $sql2="SELECT * FROM enrollment WHERE schedule_id=$id";
        //echo $sql2;
        $result12= $database->query($sql2);
        $enrollment_number=($result12->num_rows)+1;
    } echo'
    <div class="row">
    <div class="col">
      <div class="justify-content-center text-center" style="width: 80%; margin:auto; margin-top: 50px;">
        <form action="add_schedule_complete.php" method="POST">

        <div class="form__group field text-warning">Add schedule</div>

        

        <div class="form__group field">
        <label for="course_type" class="form__label">Course type</label>
        <select name="course_type" style="background-color: #fff; margin-top: 20px;" required>
        <option value="" disabled="disabled" selected="selected">Select transmission</option>
        <option value="Theoretical Driving Lesson">Theoretical Driving Lesson</option>
        <option value="Practical Driving Lesson">Practical Driving Lesson</option>
        </select>
        </div>

        <div class="form__group field">
        <input type="date" class="form__field" name="date" min="' . date('Y-m-d') . '" required>
        <label for="date" class="form__label">Date</label>
        </div>

        <div class="form__group field">
        <input type="time" class="form__field" name="time" placeholder="Time Starts" required>
        <label for="time" class="form__label">Time Starts</label>
        </div>

        <div class="form__group field">
        <input type="hidden" class="form__field" name="schedule_id" required>
        <input type="hidden" class="form__field" name="instructor_id" required>
        </div>

        <div class="form__group field">
        <input type="reset" value="Reset" class="btn btn-warning btn-sm" >
        <input type="submit" name="set_schedule" value="Set this schedule" class="btn btn-warning btn-sm">
        </div>

        </form>
        </div>
      </div>
      </div>
    ';
    ?>

  </div>
</div>

<!-- footer -->
<?php include "section/footer.php" ?>