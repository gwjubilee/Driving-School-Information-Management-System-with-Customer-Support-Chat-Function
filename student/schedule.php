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

$userrow = mysqli_query($database, "SELECT * FROM student WHERE student_email='$useremail'") or die(mysqli_error($database));
$userfetch = mysqli_fetch_assoc($userrow);
$userid = $userfetch["student_id"];
$username = $userfetch["student_name"];

date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container text-white">

    <form action="" method="POST">

    <!-- search -->
      <div class="row">
          <div class="col">
            <div class="box">
              <div data-aos="fade-up" class="container-1">
                <span class="icon"><i class="fa fa-search"></i></span>
                <input type="search" name="search" id="search" placeholder="Instructor name or email" list="instructors" />
              </div>
            </div>

          </div>
      </div>

      <!-- code for search -->
    <?php
      $sqlmain= "SELECT * FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE schedule.schedule_date>='$today' ORDER BY schedule.schedule_date ASC";
      $insertkey="";
      $q='';
      $searchtype="All";
      if($_POST) {

      if(!empty($_POST["search"])) {

      $keyword=$_POST["search"];
      $sqlmain= "SELECT * FROM schedule INNER JOIN instructor on schedule.instructor_id=instructor.instructor_id WHERE schedule.schedule_date>='$today' AND (instructor.instructor_name='$keyword' OR instructor.instructor_name LIKE '$keyword%' OR instructor.instructor_name LIKE '%$keyword' OR instructor.instructor_name LIKE '%$keyword%' OR schedule.title='$keyword' OR schedule.title LIKE '$keyword%' OR schedule.title LIKE '%$keyword' OR schedule.title LIKE '%$keyword%' OR schedule.schedule_date LIKE '$keyword%' OR schedule.schedule_date LIKE '%$keyword' OR schedule.schedule_date LIKE '%$keyword%' OR schedule.schedule_date='$keyword' ) ORDER BY schedule.schedule_date ASC";

      $insertkey=$keyword;
      $searchtype="Search result: ";
      $q='"';
      }
      }
      $result = mysqli_query($database, $sqlmain) or die(mysqli_error($database));
    ?>

    <!-- datalist -->
      <?php
        echo '<datalist id="instructors">';
        $list11 = mysqli_query($database, "SELECT DISTINCT * FROM instructor;") or die(mysqli_error($database));
        $list12 = mysqli_query($database, "SELECT DISTINCT * FROM schedule GROUP BY title;") or die(mysqli_error($database));

        for ($y=0;$y<$list11->num_rows;$y++) {

        $row00 = mysqli_fetch_assoc($list11);

        $instructor_name=$row00["instructor_name"];

        echo "<option value='$instructor_name'><br />";

        };

        for ($y=0;$y<$list12->num_rows;$y++) {
        $row00=$list12->fetch_assoc();
        $instructor_name=$row00["title"];

        echo "<option value='$instructor_name'><br />";
        };

        echo '</datalist>';
      ?>

    <!-- submit button -->
    <div class="row text-center" style="margin-top: 20px;">
      <div data-aos="fade-up" class="col">
        <input type="submit" value="Search" class="btn btn-warning btn-sm" style="padding: 7px;">
      </div>
    </div>
    <!-- end form -->
    </form>

    <!-- number of schedules -->
    <div class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
      <div data-aos="fade-up" class="col">
        <p><?php echo $searchtype." Schedules"." (".$result->num_rows.")"; ?></p>
        <p><?php echo $q.$insertkey.$q ; ?></p>
      </div>
    </div>

    <!-- table -->
    <div class="row">
      <div class="col">
        <table data-aos="fade-up" class="styled-table">
          <thead>
            <tr>
             
              <th>Course Type</th>
              <th>Instructor</th>
              <th>Date</th>
              <th>Time Starts</th>
              <th></th>
            </tr>
          </thead>

        <?php
        if($result->num_rows==0) {
        echo '
        <div class="row" style="position: absolute; margin-top: 100px; margin-bottom: 100px; left: 47.5%;">
        <div data-aos="fade-up" class="col">
            <img src="../asset/img/undraw_taken.svg" width="25%">
            <p style="margin-top:10px; color:#E0E1E4;">There\'s nothing here.</p>
        </div>
        </div> 
        ';

        } else {

        for( $x=0;$x<($result->num_rows);$x++) {

        $row=$result->fetch_assoc();
        if(isset($row)) {    
        $schedule_id=$row["schedule_id"];
        $title=$row["title"];
        $course_type=$row["course_type"];
        $instructor_name=$row["instructor_name"];
        $schedule_date=$row["schedule_date"];
        $schedule_time=$row["schedule_time"];
        };
        if($schedule_id=="") {
        break;
        }

        echo '
        <tbody>
          <tr>
          
              <td>'.$course_type.'</td>
              <td>'.$instructor_name.'</td>
              <td>'.$schedule_date.'</td>
              <td>'.$schedule_time.'</td>
              <td><a href="enroll_application.php?id='.$schedule_id.'" class="btn-warning btn btn-sm">Enroll to this schedule</a>
              </td>
          </tr>
        </tbody>
        ';

        }
        }
        ?>
      </table>
    </div>
  </div>

<?php

  // actions for handlers
  if($_GET) {

    $id=$_GET["id"];
    $action=$_GET["action"];
    if($action=='ongoing_application') {

    echo'
    <div class="overlay">
    <div class="popup text-center">
        <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
        <a class="close" href="schedule.php">&times;</a>
        <p>Enrollment application already submitted. <br />Thank you!</p>
        <a href="schedule.php" class="btn btn-warning btn-sm">Okay</a>
        </div>
    </div>
    </div>
    
    ';
    } else if($action=='already_approved') {

      echo'
      <div class="overlay">
      <div class="popup text-center">
          <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
          <a class="close" href="schedule.php">&times;</a>
          <p>You are already approved for this subject.</p>
          <a href="schedule.php" class="btn btn-warning btn-sm">Okay</a>
          </div>
      </div>
      </div>
      
      ';
    } else if($action=='success') {
      echo'
      <div class="overlay">
      <div class="popup text-center">
          <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
          <a class="close" href="schedule.php">&times;</a>
          <p>Enrollment request submitted successfully. <br />View your enrollment application?</p>
          <a href="enrollment_request.php" class="btn btn-warning btn-sm">View</a>
          </div>
      </div>
      </div>
      ';
    }
  }

?>

  </div>
</div>

<!-- footer -->
<?php include("section/footer.php"); ?>