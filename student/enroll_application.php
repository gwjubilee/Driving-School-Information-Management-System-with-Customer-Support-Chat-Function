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

$userrow = $database->query("SELECT * FROM student WHERE student_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["student_id"];
$username=$userfetch["student_name"];

date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mabuhay Driving Lesson Academy</title>
    <link href="../asset/css/style.css" rel="stylesheet">

    <link href="../asset/css/bootstrap.css" rel="stylesheet">
    <link href="../asset/css/sidebar.css" rel="stylesheet">
    <link href="../asset/css/aos.css" rel="stylesheet">
    <link href="../asset/img/logo.png" rel="icon">
    <!-- Slick slider -->
    <link href="../asset/css/slick.css" rel="stylesheet">
    <link href="../asset/css/fontawesome.css" rel="stylesheet">
    <link href="../asset/css/brands.css" rel="stylesheet">
    <link href="../asset/css/solid.css" rel="stylesheet">
    <link href="../asset/css/all.css" rel="stylesheet">

    <style>

      h1 {
      position: absolute;
      margin: 0;
      font-size: 32px;
      color: #fff;
      z-index: 2;
      }
      h2 {
      font-weight: 400;
      }
      .testbox {
      display: flex;
      justify-content: center;
      align-items: center;
      height: inherit;
      padding: 20px;
      width: 65%;
      margin: auto;
      color: white;
      }
      form {
      width: 100%;
      padding: 50px;
      border-radius: 6px;
      box-shadow: 0 0 5px 0 #ffc107; 
      }
      .banner {
      position: relative;
      height: 400px;
      background-image: url("../asset/img/Posts1.jpg");  
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      border-radius: 7px;
      margin-bottom: 50px;

      }
      .banner::after {
      content: "";
      background-color: rgba(0, 0, 0, 0.4); 
      position: absolute;
      width: 100%;
      height: 100%;
      }
      input, select {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      }
      input {
      width: calc(100% - 10px);
      padding: 5px;
      }
      select {
      width: 100%;
      padding: 7px 0;
      background: transparent;
      }
      /* .item:hover p, .item:hover i, .question:hover p, .question label:hover, input:hover::placeholder, a {
      color: #095484; 
      } */
      /* .item input:hover, .item select:hover {
      border: 1px solid transparent;
      box-shadow: 0 0 6px 0 #095484;
      color: #ffc107;
      } */
      .item {
      position: relative;
      margin: 10px 0;
      }
      input[type="date"]::-webkit-inner-spin-button {
      display: none;
      }
      .item i, input[type="date"]::-webkit-calendar-picker-indicator {
      position: absolute;
      font-size: 20px;
      color: #a9a9a9;
      }
      .item i {
      right: 2%;
      top: 30px;
      z-index: 1;
      }
      [type="date"]::-webkit-calendar-picker-indicator {
      right: 1%;
      z-index: 2;
      opacity: 0;
      cursor: pointer;
      }
      input[type=checkbox]  {
      display: none;
      }
      label.check {
      position: relative;
      display: inline-block;
      margin: 5px 20px 10px 0;
      cursor: pointer;
      }
      .question span {
      margin-left: 30px;
      }
      span.required {
      margin-left: 0;
      color: red;
      }
      label.check:before {
      content: "";
      position: absolute;
      top: 2px;
      left: 0;
      width: 16px;
      height: 16px;
      border-radius: 2px;
      border: 1px solid #095484;
      }
      input[type=checkbox]:checked + .check:before {
      background: #095484;
      }
      label.check:after {
      content: "";
      position: absolute;
      top: 6px;
      left: 4px;
      width: 8px;
      height: 4px;
      border: 3px solid #fff;
      border-top: none;
      border-right: none;
      transform: rotate(-45deg);
      opacity: 0;
      }
      input[type=checkbox]:checked + label:after {
      opacity: 1;
      }
      .btn-block {
      margin-top: 50px;
      text-align: center;
      }
      button {
      width: 150px;
      padding: 10px;
      border: none;
      border-radius: 5px; 
      background: #ffc107;
      font-size: 16px;
      cursor: pointer;
      }
      @media (min-width: 568px) {
      .name-item, .city-item {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      }
      .name-item input, .city-item input {
      width: calc(50% - 20px);
      }
      .city-item select {
      width: calc(50% - 8px);
      }
      }
      #back_button {
        margin-left: auto;
        margin-top: 10px;
        margin-bottom: 40px;
      }
    </style>

</head>

  <body>

    <div class="testbox">

    <!-- form -->
    <form action="enroll_application_complete.php" method="POST">

        <!-- back button -->
        <div id="back_button">
        <a href="schedule.php" class="text-warning" style="font-size: larger; margin-left: 10px;"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
        </div>


        <div class="banner">
          <h1>Mabuhay Student Enrollment Form</h1>
        </div>


        <h2>Applicant Details</h2>

        <?php

          if(isset($_GET["id"])) {
            $id = $_GET["id"];

            $sqlmain= "SELECT * FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE schedule.schedule_id=$id ORDER BY schedule.schedule_date DESC";

            // $sqlmain= "SELECT * FROM schedule INNER JOIN enrollment on schedule.schedule_id=enrollment.schedule_id where schedule.schedule_id=$id ORDER BY schedule.schedule_date desc";

            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();

            $title = $row["title"];
            $course_type = $row["course_type"];
            $instructor_name = $row["instructor_name"];
            $instructor_id = $row["instructor_id"];

            echo '
            <input type="hidden" name="schedule_id" value="'.$id.'" >
            <input type="hidden" name="date" value="'.$today.'" >
            <input type="hidden" name="title" value="'.$title.'" >
            <input type="hidden" name="course_type" value="'.$course_type.'" >
            <input type="hidden" name="instructor_name" value="'.$instructor_name.'" >
            <input type="hidden" name="instructor_id" value="'.$instructor_id.'" >

            <div class="item">
              <p>Student Name</p>
              <div class="name-item">
                <input type="text" name="first_name" placeholder="Student First Name" required />
                <input type="text" name="last_name" placeholder="Student Last Name" required />
              </div>
            </div>


            <div class="item">
              <p>Address</p>
              <input type="text" name="address" placeholder="Address" />
            </div>


            <div class="item">
              <p>Home Phone</p>
              <input type="number" name="home_phone" placeholder="Home Phone Number" />
            </div>

            <div class="item">
              <p>Date of Birth</p>
              <input type="date" max="2005-12-31" name="date_of_birth" />
            </div>

            <div class="item">
              <p>Age</p>
              <input type="number" min="19" name="age" placeholder="(Age at least 19 years old)" />
            </div>

            <div class="item">
              <p>Gender</p>
              <select name="gender" style="background-color: #fff;">
                <option value="Prefer not to say">Prefer not to say</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="item">
              <p>Civil Status</p>
              <select name="civil_status" style="background-color: #fff;">
                <option value="">Choose your status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widow/er">Widow/er</option>
                <option value="Separated">Separated</option>
              </select>
            </div>

            <div class="item">
              <p>Religion</p>
              <input type="text" name="religion" placeholder="Religion" />
            </div>

            <div class="item">
              <p>Restriction Code No.</p>
              <input type="number" name="restriction_code_number" placeholder="Restriction Code Number" />
            </div>

            <p class="text-danger" style="margin-top: 30px;">If student is 18 y/o below, kindly fill out the data below.</p>
            
            <div class="item">
              <p>Parent/Guardian\'s</p>
              <input type="text" name="parent_guardian" placeholder="Parent/Guardian\'s Name" />
            </div>


            <div class="item">
              <p>Address</p>
              <input type="text" name="parent_guardian_address" placeholder="Parent/Guardian\'s Address" />
            </div>


            <div class="item">
              <p>Home Phone</p>
              <input type="number" name="parent_guardian_home_phone" placeholder="Parent/Guardian\'s Home Phone Number" />
            </div>

            <div class="item">
              <p>Email</p>
              <input type="text" name="email" placeholder="Parent/Guardian\'s Email"/>
            </div>


            <div class="item" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
              <p style="outline-style: dashed; outline-color: #ffc107; outline-width: 2px; padding: 20px;">The collected personal information herewith is utilized solely for documentation and processing purposes of 
    driving lesson and is not shared with any outside parties. Only authorized personnel 
    has access to these personal information.</p>
            </div>

            
            <div class="item">
              <p>The vehicle to be used for instruction and shall be equipped with, at minimum, a brake for both the instructor and the student.</p>
              <select name="student_transmission" style="background-color: #fff;" required>
                <option value="" disabled="disabled" selected="selected">Select transmission</option>
                <option value="Automatic Transmission">Automatic Transmission</option>
                <option value="Manual Transmission">Manual Transmission</option>
              </select>
            </div>

            <div class="item">
            <p>Classification</p>
            <select name="student_classification" style="background-color: #fff;" required >
              <option value="" disabled="disabled" selected="selected">Choose a classification</option>
              <option value="Student Permit">Student Permit</option>
              <option value="Non-Professional">Non-Professional</option>
              <option value="Professional">Professional</option>
              <option value="Dormant">Dormant</option>
              </select>
          </div>

            <div class="btn-block">
            <button type="submit" name="enroll">Send Application</button>
            </div>';

          } else {
            echo '<h3 class="text-center" style="margin-top: 50px;">Oops, something went wrong!</h3>';
          }
        ?>
    </form>

    </div>

  </body>
</html>