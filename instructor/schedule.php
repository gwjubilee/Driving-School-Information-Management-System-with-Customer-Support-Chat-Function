<!-- code -->
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

  <!-- code -->
  <?php 
    date_default_timezone_set('Asia/Manila');

    $today = date('Y-m-d');
    $list110 = $database->query("SELECT * FROM schedule WHERE instructor_id=$userid;");
  ?>

  <!-- form -->
  <form action="" method="post">
 
  <!-- filter -->
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

  <!-- count text -->
  <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
    <div class="col">
    <p>My schedules (<?php echo $list110->num_rows; ?>)</p>
    </div>
  </div>

  <!-- code -->
  <?php
    $sqlmain= "SELECT * FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE schedule.schedule_date>='$today' ORDER BY schedule.schedule_date ASC";
    $sqlpt1="";
    $insertkey="";
    $q='';
    $searchtype="All";
    if($_POST) {
    if(!empty($_POST["search"])) {
      $keyword=$_POST["search"];
      $sqlmain= "SELECT * FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE schedule.schedule_date>='$today' AND (instructor.instructor_name='$keyword' OR instructor.instructor_name LIKE '$keyword%' OR instructor.instructor_name LIKE '%$keyword' OR instructor.instructor_name LIKE '%$keyword%' OR schedule.title='$keyword' OR schedule.title LIKE '$keyword%' OR schedule.title LIKE '%$keyword' OR schedule.title LIKE '%$keyword%' OR schedule.schedule_date LIKE '$keyword%' OR schedule.schedule_date LIKE '%$keyword' OR schedule.schedule_date LIKE '%$keyword%' OR schedule.schedule_date='$keyword' ) ORDER BY schedule.schedule_date ASC";
      //echo $sqlmain;
      $insertkey=$keyword;
      $searchtype="Search Result : ";
      $q='"';
    }
    }
    $result= $database->query($sqlmain)
  ?>

  <!-- add schedule button -->
  <div data-aos="fade-up" data-aos-duration="1100" class="row text-center" style="margin-top: 50px;">
    <div class="col">
    <?php
      $sql="SELECT * FROM schedule";
      $result= $database->query($sql);
 
          $row=$result->fetch_assoc();
          if(!isset($row)) {
            
          };
          $schedule_id=$row["schedule_id"];
          $title=$row["title"];
          $instructor_name=$row["instructor_name"];
          $schedule_date=$row["schedule_date"];
          $schedule_time=$row["schedule_time"];
      echo '
      <a href="add_schedule.php?id='.$schedule_id.'" class="btn btn-warning btn-sm">Add a schedule</a>
      ';
        
    ?>
    </div>
  </div>


  <!-- table -->
  <div data-aos="fade-up" data-aos-duration="1400" class="row" style="margin-top: 30px; margin-bottom: 300px;">
    <div class="col">
      <table class="styled-table">
        <thead>
          <tr>
          
            <th>Course Type</th>
            <th>Date</th>
            <th>Time Starts</th>
            <th></th>
          </tr>
        </thead>


        
      <?php

      $sqlmain1= "SELECT * FROM schedule INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE schedule.instructor_id=$userid ORDER BY schedule.schedule_date ASC";
        $result1=$database->query($sqlmain1);

        if($result1->num_rows==0) {
        echo '
        <div class="row text-center" style="position: absolute; margin-top: 100px; left: 115px;">
          <div class="col">
            <img src="../asset/img/undraw_taken.svg" width="25%">
            <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
          </div>
        </div>  
        ';

        } else {
          for ( $x=0; $x<$result1->num_rows;$x++) {
            $row=$result1->fetch_assoc();
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
                  <td>'.$schedule_date.'</td>
                  <td>'.$schedule_time.'</td>
                  <td>
                    <a href="?action=drop&id='.$schedule_id.'&name='.$title.'" class="btn btn-warning btn-sm">Cancel Schedule</a>
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

  <div class="row">
    <div class="col">
    <?php

      if(isset($_GET["id"])) {
        $id=$_GET["id"];

        $action=$_GET["action"];
        if($action=='add_schedule') {
          echo '
          <div class="overlay">
          <div class="popup">
          <a class="close" href="schedule.php">&times;</a>
        
          <div class="form__group field">
          <p class="text-white">Add schedule</p>
          </div>
        
          <form action="add_schedule.php" method="POST">

          <div class="form__group field">
          <input type="hidden" class="form__field" name="userid" value="'.$userid.'" required>
          </div>
        
          <div class="form__group field">
          <input type="text" class="form__field" name="title" placeholder="Name for this schedule" required>
          <label for="title" class="form__label">About</label>
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
        echo '
        <div class="overlay">
          <div class="popup text-center">
            <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
            <a class="close" href="schedule.php">&times;</a>
            <p>Successfully added!</p>
            <p>Your schedule has been posted.</p>
            <a href="schedule.php" class="btn btn-warning btn-sm">Okay</a>
            </div>
          </div>
        </div>
      ';
      } elseif($action=='drop') {
        $getname=$_GET["name"];
        echo '
        <div class="overlay">
        <div class="popup text-center">
            <img src="../asset/img/undraw_feeling_blue.svg" width="50%" style="margin-bottom: 10px;">
            <a class="close" href="schedule.php">&times;</a>
            <p>Are you sure?<br />This will permanently remove <span class="text-warning">"'.$getname.'"</span> to your schedule.</p>
            <a href="delete_schedule.php?id='.$id.'" class="btn btn-warning btn-sm" style="padding: 6px; width: 60px;">Yes</a>
            </div>
        </div>
        </div>
        ';

      }
        

      }
    ?>
      </div>
    </div>

  </div>
</div>

<!-- footer -->
<?php include "section/footer.php" ?>