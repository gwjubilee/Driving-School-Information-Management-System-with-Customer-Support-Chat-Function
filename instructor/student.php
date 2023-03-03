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

    $selecttype="My";
    $current="My students only";
    if($_POST) {

    if(isset($_POST["search"])) {
    $keyword=$_POST["search12"];

    $sqlmain= "SELECT * FROM student WHERE student_email='$keyword' OR student_name='$keyword' OR student_name LIKE '$keyword%' OR student_name LIKE '%$keyword' OR student_name LIKE '%$keyword%'";
    $selecttype="My";
    }

    if(isset($_POST["filter"])) {
    if($_POST["showonly"]=='all') {
    $sqlmain= "SELECT * FROM student";
    $selecttype="All";
    $current="All students";
    } else {
    $sqlmain= "SELECT * FROM enrollment INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN schedule ON schedule.schedule_id=enrollment.schedule_id WHERE schedule.instructor_id=$userid;";
    $selecttype="My";
    $current="My students only";
    }
    }
    }else {
    $sqlmain= "SELECT * FROM enrollment INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN schedule ON schedule.schedule_id=enrollment.schedule_id WHERE schedule.instructor_id=$userid;";
    $selecttype="My";
    }

    ?>

<form action="" method="POST">

  <div data-aos="fade-up" data-aos-duration="1000" class="row">
    <div class="col">

      <div class="box">
        <div class="container-1">
          <span class="icon"><i class="fa fa-search"></i></span>
          <input type="search" name="search12" id="search" placeholder="Search student name or email" list="instructors" />
        </div>
      </div>

    </div>
  </div>

    <?php
      echo '<datalist id="student">';
      $list11 = $database->query($sqlmain);

      for ($y=0;$y<$list11->num_rows;$y++) {
      $row00=$list11->fetch_assoc();
      $d=$row00["student_name"];
      $c=$row00["student_email"];
      echo "<option value='$d'><br/>";
      echo "<option value='$c'><br/>";
      };

      echo ' </datalist>';
      ?>

  <div data-aos="fade-up" data-aos-duration="1100" class="row text-center" style="margin-top: 20px;">
    <div class="col">
      <input type="submit" name="search" value="Search" class="btn btn-warning btn-sm" style="padding: 7px;">
    </div>
  </div>
  <!-- end form -->
  </form>

  <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
    <div class="col">
    <p><?php echo $selecttype." students (".$list11->num_rows.")"; ?></p>
    </div>
  </div>

  <div data-aos="fade-up" data-aos-duration="1300" class="row">
    <div class="col">

    <form action="" method="post">

    <div class="box">
    <div class="container-1">
    <select name="showonly" id="filter">
      <option value="" disabled selected hidden><?php echo $current ?></option><br/>
      <option value="my">My students only</option><br/>
      <option value="all">All students</option><br/>
    </select>
    <input type="submit" name="filter" value=" Filter" class="btn btn-warning btn-sm" style="padding: 6px; margin-left: 4px;">

    </div>
    </div>

    </form>

    </div>
  </div>

  <div data-aos="fade-up" data-aos-duration="1400" class="row" style="margin-top: 80px; margin-bottom: 300px;">
      <div class="col">
        <table class="styled-table">
          <thead>
            <tr>
              <th>About</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Birthday</th>
            </tr>
          </thead>

          <?php

          $result= $database->query($sqlmain);

          if($result->num_rows==0) {
          echo '
          <div class="row text-center" style="position: absolute; margin-top: 100px; left: 110px;">
          <div class="col">
              <img src="../asset/img/undraw_taken.svg" width="25%">
              <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
          </div>
          </div> 
          ';

          } else {
          for( $x=0; $x<$result->num_rows;$x++) {
          $row=$result->fetch_assoc();
          $student_id=$row["student_id"];
          $name=$row["student_name"];
          $email=$row["student_email"];
          $dob=$row["student_birthdate"];
          $tel=$row["student_phone"];

          echo '
          <tbody>
          <tr>
              <td>'.$name.'</td>
              <td>'.$tel.'</td>
              <td>'.$email.'</td>
              <td>'.$dob.'</td>
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