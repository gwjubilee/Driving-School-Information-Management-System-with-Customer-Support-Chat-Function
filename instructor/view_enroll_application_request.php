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


//import database
require_once "../include/connection.php";

$userrow = $database->query("SELECT * FROM instructor WHERE instructor_email='$useremail'");
$userfetch=$userrow->fetch_assoc();

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
    <form action="" method="POST">

        <!-- back button -->
        <div id="back_button">
        <a href="enrollment_request.php" class="text-warning" style="font-size: larger; margin-left: 10px;"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
        </div>


        <div class="banner">
          <h1>Mabuhay Student Enrollment Form</h1>
        </div>


        <h2>Applicant Details</h2>

        <?php

          if(isset($_GET["id"])) {
            $id = $_GET["id"];

            $sqlmain= "SELECT * FROM enrollment_request WHERE enrollment_request_id=$id";

            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();

            $name=$row["student_name"];
            $student_address=$row["student_address"];
            $student_phone=$row["student_phone"];
            $student_birthdate=$row["student_birthdate"];
            $student_age=$row["student_age"];
            $student_classification=$row["student_classification"];
            $student_restriction_code_number=$row["student_restriction_code_number"];
            $student_gender=$row["student_gender"];
            $student_civil_status=$row["student_civil_status"];
            $student_religion=$row["student_religion"];


            $student_parent_guardian=$row["student_parent_guardian"];
            $student_parent_guardian_address=$row["student_parent_guardian_address"];
            $student_parent_guardian_home_phone=$row["student_parent_guardian_home_phone"];
            $student_parent_guardian_email=$row["student_parent_guardian_email"];


            $student_transmission=$row["student_transmission"];
            

            echo '
            <input type="hidden" name="schedule_id" value="'.$id.'" >
            <input type="hidden" name="date" value="'.$today.'" >

            <div class="item">
              <p>Student Name</p>
              <div class="name-item">
                <input type="text" placeholder="Name" value="'.$name.'" style="width: 99%;" readonly />
              </div>
            </div>


            <div class="item">
              <p>Address</p>
              <input type="text" placeholder="Address" value="'.$student_address.'" readonly />
            </div>


            <div class="item">
              <p>Home Phone</p>
              <input type="number" placeholder="Home Phone" value="'.$student_phone.'" readonly />
            </div>

            <div class="item">
              <p>Date of Birth</p>
              <input type="date" placeholder="Date of Birth" value="'.$student_birthdate.'" readonly />
            </div>

            <div class="item">
              <p>Age</p>
              <input type="number" placeholder="Age" value="'.$student_age.'" readonly />
            </div>

            <div class="item">
              <p>Gender</p>
              <input type="text" placeholder="Gender" value="'.$student_gender.'" readonly />
            </div>

            <div class="item">
              <p>Civil Status</p>
              <input type="text" placeholder="Civil Status" value="'.$student_civil_status.'" readonly />
            </div>

            <div class="item">
              <p>Religion</p>
              <input type="text" placeholder="Religion" value="'.$student_religion.'" readonly />
            </div>


            <div class="item">
              <p>Restriction Code No.</p>
              <input type="number" placeholder="Restriction Code No." value="'.$student_restriction_code_number.'" readonly />
            </div>


            <p class="text-danger" style="margin-top: 30px;">If student is 18 y/o below, kindly fill out the data below.</p>
            
            <div class="item">
              <p>Parent/Guardian\'s</p>
              <input type="text" placeholder="Parent/Guardian\'s" value="'.$student_parent_guardian.'" readonly />
            </div>


            <div class="item">
              <p>Address</p>
              <input type="text" placeholder="Address" value="'.$student_parent_guardian_address.'" readonly />
            </div>


            <div class="item">
              <p>Home Phone</p>
              <input type="number" placeholder="Home Phone" value="'.$student_parent_guardian_home_phone.'" readonly />
            </div>

            <div class="item">
              <p>Email</p>
              <input type="text" placeholder="Email" value="'.$student_parent_guardian_email.'" readonly />
            </div>


            <div class="item" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
              <p style="outline-style: dashed; outline-color: #ffc107; outline-width: 2px; padding: 20px;">The collected personal information herewith is utilized solely for documentation and processing purposes of 
    driving lesson and is not shared with any outside parties. Only authorized personnel 
    has access to these personal information.</p>
            </div>

            
            <div class="item">
              <p>The vehicle to be used for instruction and shall be equipped with, at minimum, a brake for both the instructor and the student.</p>
              <input type="text" value="'.$student_transmission.'" readonly />
            </div>


            <div class="item">
              <p>Classification</p>
              <input type="text" placeholder="Classification" value="'.$student_classification.'" readonly />
            </div>
            
            ';

          } else {
            echo '<h3 class="text-center" style="margin-top: 50px;">Oops, something went wrong!</h3>';
          }
        ?>
    </form>

    </div>

  </body>
</html>