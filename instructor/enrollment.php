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
$userid= $userfetch["instructor_id"];
$username=$userfetch["instructor_name"];

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- sidebar -->
<?php include "section/sidebar.php" ?>

<div class="main">

  <div class="container text-white">

  <?php 
    date_default_timezone_set('Asia/Manila');

    $today = date('Y-m-d');

    $list110 = $database->query("SELECT * FROM schedule INNER JOIN enrollment ON schedule.schedule_id=enrollment.schedule_id INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id  WHERE  instructor.instructor_id=$userid ");
  ?>

  <div data-aos="fade-up" data-aos-duration="1000" class="row">
    <div class="col">

      <div class="box">
        <div class="container-1">
          <input type="date" name="schedule_date" id="date">
          <input type="submit" name="filter" value=" Filter" class="btn btn-warning btn-sm" style="padding: 6px; margin-left: 4px;">
        </div>
      </div>

    </div>
  </div>

  <?php
    $sqlmain= "SELECT enrollment.enrollment_id,schedule.schedule_id,schedule.title,instructor.instructor_name,student.student_name,schedule.schedule_date,schedule.schedule_time,enrollment.enrollment_date FROM schedule INNER JOIN enrollment on schedule.schedule_id=enrollment.schedule_id INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id  WHERE  instructor.instructor_id=$userid ";

    if($_POST){

    if(!empty($_POST["schedule_date"])){
    $schedule_date=$_POST["schedule_date"];
    $sqlmain.=" AND schedule.schedule_date='$schedule_date' ";
    };

    }
  ?>


  <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
    <div class="col">
    <p>Students enrolled (<?php echo $list110->num_rows; ?>)</p>
    </div>
  </div>


  <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
    <div class="col">
    <a href="enrollment_request.php" class="btn btn-warning" style="padding: 7px;">View pending enrollment applications</a>
    </div>
  </div>


<div data-aos="fade-up" data-aos-duration="1400" class="row" style="margin-top: 50px; margin-bottom: 300px;">
  <div class="col">
    <table class="styled-table">
      <thead>
        <tr>
          <th>Student</th>
         
          <th>Date</th>
          <th>Time Starts</th>
          <th>Approved Date</th>
          <th></th>
        </tr>
      </thead>

      <?php
      $result= $database->query($sqlmain);

      if($result->num_rows==0) {
      echo '
      <div class="row text-center" style="position: absolute; margin-top: 100px; left: 105px;">
      <div class="col">
          <img src="../asset/img/undraw_taken.svg" width="25%">
          <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
      </div>
      </div>  
      ';
      } else {
      for ($x=0; $x<$result->num_rows;$x++) {
      $row=$result->fetch_assoc();
      $enrollment_id=$row["enrollment_id"];
      $schedule_id=$row["schedule_id"];
      $title=$row["title"];
      $instructor_name=$row["instructor_name"];
      $schedule_date=$row["schedule_date"];
      $schedule_time=$row["schedule_time"];
      $student_name=$row["student_name"];
      $enrollment_date=$row["enrollment_date"];
      echo '
      <tbody>
      <tr>
        <td>'.$student_name.'</td>
        
        <td>'.$schedule_date.'</td>
        <td>'.$schedule_time.'</td>
        <td>'.$enrollment_date.'</td>
        <td>
          <a href="view_enroll_application.php?id='.$enrollment_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-warning btn-sm" style="margin:7px;">View form</a>

          <a href="?action=drop&id='.$schedule_id.'&name='.$title.'" class="btn btn-danger btn-sm">Remove</a>
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


    <!-- INSERT PENDING ENROLLMENTS HERE -->


    
    <!-- code for actions -->
    <?php

    if($_GET) {
    $id=$_GET["id"];
    $action=$_GET["action"];
    if($action=='add_schedule') {
    echo '
    <div class="overlay">
    <div class="popup text-center">

    <a class="close" href="schedule.php">&times;</a>

    <div class="row">
    <div class="col">
    <p>Add new schedule</p>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <form action="add_schedule.php" method="POST">
    <p>About: </p>
    <input type="text" name="title" placeholder="About this schedule" required>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <p>Select instructor: </p>
    <select name="instructor_id" id="" class="box" >
    <option value="" disabled selected hidden>Choose an instructor from the list</option>
    ';

    $list11 = $database->query("SELECT * FROM instructor;");

    for ($y=0;$y<$list11->num_rows;$y++) {
    $row00=$list11->fetch_assoc();
    $sn=$row00["instructor_name"];
    $id00=$row00["instructor_id"];
    echo "<option value=".$id00.">$sn</option><br />";
    };

    echo '</select>
    
    </div>
    </div>

    <div class="row">
    <div class="col">
    <label for="max_number_students" class="form-label">Max number of students: </label>
    <input type="number" name="max_number_students" placeholder="The final enrollment number for this schedule depends on this number" required>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <label for="date">Schedule date: </label>
    <input type="date" name="date" class="input-text" min="'.date('Y-m-d').'" required>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <label for="date">Schedule time: </label>
    <input type="time" name="time" class="input-text" placeholder="Time" required>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <input type="reset" value="Reset" class="btn btn-warning btn-sm" >
    <input type="submit" name="shedulesubmit" value="Set this shedule" class="btn btn-warning btn-sm">
    </div>
    </div>

    </form>

    </div>
    </div>
    ';

    } elseif($action=='schedule_added') {
    $titleget=$_GET["title"];
    echo '
    <div class="overlay">
    <div class="popup text-center">
    <h2>Schedule set!</h2>
    <a class="close" href="schedule.php">&times;</a>
    <p>'.substr($titleget,0,40).' was scheduled.</p>
    <a href="schedule.php" class="btn btn-warning" style="display: flex;justify-content: center;align-items: center;">Okay</a>
    </div>
    </div>
    ';

    } elseif($action=='drop') {
    $nameget=$_GET["name"];
    $schedule=$_GET["schedule"];
    $enrollment_number=$_GET["enrollment_number"];
    echo '
    <div class="overlay">
    <div class="popup text-center">
    <h3>Are you sure?</h3>
    <a class="close" href="enrollment.php">&times;</a>
    <p>This will remove the student from your class.</p>
    <a href="delete_enrollment.php?id='.$id.'" class="btn btn-warning btn-sm" style="display: flex;justify-content: center;align-items: center;">Yes</a>
    </div>
    </div>
    ';

    } 
    }

    ?>

  </div>

</div>

</body>

<!-- footer -->
<?php include "section/footer.php" ?>