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

  $list110 = $database->query("SELECT * FROM schedule;");
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
         <input type="submit" name="filter" value="Filter" class="btn btn-warning btn-sm" style="padding: 6px;">
       </div>
     </div>

   </div>
 </div>

 </form>


 <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 50px; margin-bottom: 50px; color: #E0E1E4;">
    <div class="col">
      <p>All schedules (<?php echo $list110->num_rows; ?>)</p>
    </div>
  </div>


  <div data-aos="fade-up" class="row text-center">
    <div class="col">
      <a href="?action=add_schedule&id=none&error=0" class="btn btn-warning btn-sm">Add a schedule</a>
    </div>
  </div>


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
  $sqlmain= "SELECT schedule.schedule_id,schedule.title,instructor.instructor_name,schedule.schedule_date,schedule.schedule_time FROM schedule INNER JOIN instructor on schedule.instructor_id=instructor.instructor_id ";
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
  $sqlmain= "SELECT schedule.schedule_id,schedule.title,schedule.course_type,instructor.instructor_name,schedule.schedule_date,schedule.schedule_time FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id ORDER BY schedule.schedule_date DESC";

  }
  ?>
  
    </div>
  </div>

  <div data-aos="fade-up" data-aos-duration="1400" class="row text-white" style="margin-top: 30px; margin-bottom: 300px; margin-left: 200px;">
  <div class="col">
    <table class="styled-table">
      <thead>
        <tr>
          
          <th>Course type</th>
          <th>Instructor</th>
          <th>Schedule Date</th>
          <th>Start Time</th>
          <th></th>
        </tr>
      </thead>
    
    <?php
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
    for($x=0; $x<$result->num_rows;$x++) {
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
      <td>
      <a href="?action=drop&id='.$schedule_id.'" class="btn btn-warning btn-sm">Cancel Schedule</a>
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

  <!-- actions -->
  <?php
  if($_GET) {
  $id=$_GET["id"];
  $action=$_GET["action"];
  if($action=='add_schedule') {
  echo '
  <div class="overlay">
  <div class="popup" style="bottom: 60px;">
  <a class="close" href="schedule.php">&times;</a>

  <div class="form__group field">
  <h5 class="text-warning">Add Instructor Schedule</h5>
  </div>

  <form action="add_schedule.php" method="POST">


  <div class="form__group field">
  <label for="course_type" class="form__label">Course type</label>
  <select name="course_type" style="background-color: #fff; margin-top: 20px;" required>
  <option value="" disabled="disabled" selected="selected">Select transmission</option>
  <option value="Theoretical Driving Lesson">Theoretical Driving Lesson</option>
  <option value="Practical Driving Lesson">Practical Driving Lesson</option>
  </select>
  </div>

  <div class="form__group field">
  <select name="instructor_id" id="" class="box" >
  <option value="" disabled selected hidden>Choose an instructor from the list</option><br/>';
  $list11 = $database->query("SELECT  * FROM  instructor ORDER BY instructor_name ASC;");

  for ($y=0;$y<$list11->num_rows;$y++) {
  $row00=$list11->fetch_assoc();
  $sn=$row00["instructor_name"];
  $id00=$row00["instructor_id"];
  echo "<option value=".$id00.">$sn</option><br/>";
  };
  echo ' </select>
  </div>

  <div class="form__group field">
  <input type="date" class="form__field" name="date" min="' . date('Y-m-d') . '" required>
  <label for="date" class="form__label">Date</label>
  </div>

  <div class="form__group field">
  <input type="time" class="form__field" name="time" placeholder="time" required>
  <label for="time" class="form__label">Time</label>
  </div>


  <div class="form__group field">
  <input type="reset" value="Reset" class="btn btn-warning btn-sm" >
  <input type="submit" name="shedulesubmit" value="Set this schedule" class="btn btn-warning btn-sm">
  </div>

  </form>

  </div>
  </div>
  ';

  } elseif($action=='schedule_added') {
  $get_course_type=$_GET["course_type"];
  echo '
  <div class="overlay">
  <div class="popup text-center text-white">
      <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
      <a class="close" href="instructor.php">&times;</a>
      <p>Successfully added!</p>
      <p><span class="text-warning">'.$get_course_type.'</span> is set.</p>
      <a href="schedule.php" class="btn btn-warning btn-sm">Okay</a>
      </div>
  </div>
  </div>
  ';

  } elseif($action=='drop') {
  $nameget=$_GET["name"];
  echo '
  <div class="overlay">
  <div class="popup text-center text-white">
      <img src="../asset/img/undraw_feeling_blue.svg" width="50%" style="margin-bottom: 10px;">
      <a class="close" href="schedule.php">&times;</a>
      <p>Are you sure?<br />This will permanently delete this instructor\'s schedule.</p>
      <a href="delete_schedule.php?id='.$id.'" class="btn btn-warning btn-sm" style="padding: 6px; width: 60px;">Yes</a>
      </div>
  </div>
  </div>
  ';

  $result= $database->query($sqlmain12);
  if($result->num_rows==0) {
  echo '
  <div class="row text-center" style="position: absolute; margin-top: 100px;">
  <div class="col">
      <img src="../asset/img/undraw_taken.svg" width="25%">
      <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
  </div>
  </div> 
  ';

  } else {
  for( $x=0; $x<$result->num_rows;$x++) {
  $row=$result->fetch_assoc();
  $enrollment_number=$row["enrollment_number"];
  $student_id=$row["student_id"];
  $student_name=$row["student_name"];
  $student_phone=$row["student_phone"];

  echo '
  <div class="row">
  <div class="col">
  '.substr($student_id,0,15).'
  </div>
  <div class="col">
  '.substr($student_name,0,50).'
  </div>
  <div class="col">
  '.$enrollment_number.'
  </div>
  <div class="col">
  '.substr($student_phone,0,25).'
  </div>
  </div>  
  ';

  }
  }
  echo '';  
  }
  }

  ?>

  </div>
</div>


<!-- footer -->
<?php include "section/footer.php" ?>