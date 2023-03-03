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

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- Side navigation -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container bg-dark text-white">

  <?php 
  date_default_timezone_set('Asia/Manila');

  $today = date('Y-m-d');

  $list110 = $database->query("SELECT * FROM enrollment;");
  ?>

<form action="" method="post">
 
 <div data-aos="fade-up" data-aos-duration="1000" class="row text-center">
  <div class="col">

    <div class="box">
      <div class="container-1">
        <input type="date" name="schedule_date" id="date" style="margin-left: 50px;">
      </div>
    </div>

  </div>
 </div>

 <div data-aos="fade-up" data-aos-duration="1000" class="row text-center">
   <div class="col">

    <div class="box">
    <div class="container-1">
      <select name="instructor_id" id="filter" style="padding-left: 10px; margin-left: 50px; margin-top: 10px;">
      <option disabled selected hidden>Choose an instructor</option>
      <?php 
        $list11 = $database->query("SELECT  * FROM  instructor ORDER BY instructor_name ASC;");
        for($y=0;$y<$list11->num_rows;$y++) {
        $row00=$list11->fetch_assoc();
        $sn=$row00["instructor_name"];
        $id00=$row00["instructor_id"];
        echo "<option value=".$id00.">$sn</option><br />";
        };
      ?>
      </select>
    </div>
    </div>

   </div>
  </div>

  <div data-aos="fade-up" data-aos-duration="1000" class="row text-center" style="margin-top: 20px;">
   <div class="col">

     <div class="box">
       <div class="container-1">
         <input type="submit" name="filter" value=" Filter" class="btn btn-warning btn-sm" style="padding: 6px;">
       </div>
     </div>

   </div>
 </div>

 </form>

  <?php
    if($_POST) {
    $sqlpt1="";
    if(!empty($_POST["schedule_date"])) {
      $schedule_date=$_POST["schedule_date"];
      $sqlpt1=" schedule.schedule_date='$schedule_date' ";
    }
    $sqlpt2="";
    if(!empty($_POST["instructor_id"])) {
      $instructor_id=$_POST["instructor_id"];
      $sqlpt2=" instructor.instructor_id=$instructor_id ";
    }
    $sqlmain= "SELECT enrollment.enrollment_id,schedule.schedule_id,schedule.title,instructor.instructor_name,student.student_name,schedule.schedule_date,schedule.schedule_time,enrollment.enrollment_date FROM schedule INNER JOIN enrollment on schedule.schedule_id=enrollment.schedule_id INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id";
    $sqllist=array($sqlpt1,$sqlpt2);
    $sqlkeywords=array(" where "," and ");
    $key2=0;
    foreach($sqllist as $key) {

      if(!empty($key)) {
          $sqlmain.=$sqlkeywords[$key2].$key;
          $key2++;
      };
    };

    } else {
    $sqlmain= "SELECT enrollment.enrollment_id,schedule.schedule_id,schedule.title,schedule.course_type,instructor.instructor_name,student.student_name,schedule.schedule_date,schedule.schedule_time,enrollment.enrollment_date FROM schedule INNER JOIN enrollment on schedule.schedule_id=enrollment.schedule_id INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id ORDER BY schedule.schedule_date DESC";

    }

    ?>

  <div data-aos="fade-up" data-aos-duration="1400" class="row" style="margin-top: 70px; margin-bottom: 300px;">
  <div class="col">
    <table class="styled-table">
      <thead>
        <tr>
          <th>Student</th>
          
          <th>Course Type</th>
          <th>Instructor</th>
          <th>Schedule Date</th>
          <th>Time Starts</th>
          <th>Enrolled Date</th>
          <th></th>
        </tr>
      </thead>

  <?php                        
  $result= $database->query($sqlmain);

  if($result->num_rows==0) {
  echo '
  <div class="row" style="position: absolute; margin-top: 100px; left: 43%;">
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
  $course_type=$row["course_type"];
  $instructor_name=$row["instructor_name"];
  $schedule_date=$row["schedule_date"];
  $schedule_time=$row["schedule_time"];
  $student_name=$row["student_name"];
  $enrollment_date=$row["enrollment_date"];
  echo '
  <tbody>
  <tr>
    <td>'.$student_name.'</td>
    
    <td>'.$course_type.'</td>
    <td>'.$instructor_name.'</td>
    <td>'.$schedule_date.'</td>
    <td>'.$schedule_time.'</td>
    <td>'.$enrollment_date.'</td>
    <td>
    <a href="?action=drop&id='.$enrollment_id.'&name='.$student_name.'&schedule='.$title.'" class="btn btn-warning btn-sm">Cancel</a>
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

  <form action="add_schedule.php" method="POST">

  <div class="row">
  <div class="col">
  <label for="title">Name: </label>
  <input type="text" name="title" placeholder="Name of this schedule" required>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <label for="instructor_id">Select an instructor: </label>
  <select name="instructor_id">
  <option value="" disabled selected hidden>Choose instructor name from the list</option>';
  $list11 = $database->query("SELECT * FROM instructor order by instructor_name asc;");

  for ($y=0;$y<$list11->num_rows;$y++) {
  $row00=$list11->fetch_assoc();
  $sn=$row00["instructor_name"];
  $id00=$row00["instructor_id"];
  echo "<option value=".$id00.">$sn</option><br/>";
  };

  echo ' </select>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <label for="max_number_students">Number of students/Enrollment numbers: </label>
  <input type="number" name="max_number_students" placeholder="Number of enrollments for this schedule" required>
  </div>
  </div>
  <div class="row">
  <div class="col">
  <label for="date">Date: </label>
  <input type="date" name="date" min="'.date('Y-m-d').'" required>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <label for="time">Schedule time: </label>
  <input type="time" name="time" placeholder="Time" required>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <label for="time">Schedule time: </label>
  <input type="time" name="time" placeholder="Time" required>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <input type="reset" value="Reset" class="btn btn-warning btn-sm">
  <input type="submit" value="Set this schedule" class="btn btn-warning btn-sm" name="shedulesubmit">
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
  <a class="close" href="instructor.php">&times;</a>
  <h3>Schedule set!</h3>
  <p>'.substr($titleget,0,40).' is scheduled.</p>
  <a href="schedule.php" class="btn btn-warning btn-sm">Okay</a>
  </div>
  </div>
  ';

  } elseif($action=='drop') {
  $nameget=$_GET["name"];
  $schedule=$_GET["schedule"];
  echo '
  <div class="overlay">
  <div class="popup text-center">
  <h3>Are you sure?</h3>
  <a class="close" href="enrollment.php">&times;</a>
  <p>Delete this record with <span class="text-warning">'.$nameget.'</span>?</p>
  <a href="delete_enrollment.php?id='.$id.'" class="btn btn-warning btn-sm">Yes</a>
  </div>
  </div>
  ';

  } elseif($action=='view') {
  $sqlmain= "SELECT * FROM instructor WHERE instructor_id='$id'";
  $result= $database->query($sqlmain);
  $row=$result->fetch_assoc();
  $name=$row["instructor_name"];
  $email=$row["instructor_email"];
  $spe=$row["specialties"];

  $spcil_res= $database->query("SELECT speciality_name FROM specialties WHERE id='$spe'");
  $spcil_array= $spcil_res->fetch_assoc();
  $spcil_name=$spcil_array["speciality_name"];
  $tele=$row['instructor_phone'];
  echo '
  <div class="overlay">
  <div class="popup text-center">
  <a class="close" href="instructor.php">&times;</a>
  <p>View details.</p>

  <div class="row">
  <div class="col">
  <p>Name: </p>
  <p>'.$name.'</p>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <p>Email: </p>
  <p>'.$email.'</p>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <p>Phone number: </p>
  <p>'.$tele.'</p>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <p>Specialty: </p>
  <p>'.$spcil_name.'</p>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <a href="instructor.php" class="btn btn-warning btn-sm">Okay</a>
  </div>
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
<?php include "section/footer.php" ?>