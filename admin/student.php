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

  <form action="student.php" method="POST">
    <div data-aos="fade-up" data-aos-duration="1000" class="row">
      <div class="col">
        <div class="box">
          <div class="container-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" name="search" id="search" placeholder="student name or email" list="students" />
          </div>
          </div>
        </div>
    </div>

      <?php
      echo '<datalist id="students">';
      $list11 = $database->query("SELECT student_name,student_email FROM student;");

      for ($y=0;$y<$list11->num_rows;$y++) {
      $row00=$list11->fetch_assoc();
      $d=$row00["student_name"];
      $c=$row00["student_email"];
      echo "<option value='$d'><br />";
      echo "<option value='$c'><br />";
      };

      echo ' </datalist>';
      ?>
    <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 20px;">
      <div class="col">
        <input type="submit" value="Search" class="btn btn-warning btn-sm" style="padding: 7px;">
      </div>
    </div>
    <!-- end form -->
    </form>

    <?php
    if($_POST) {
    $keyword=$_POST["search"];

    $sqlmain= "SELECT * FROM student WHERE student_email='$keyword' OR student_name='$keyword' OR student_name LIKE '$keyword%' OR student_name LIKE '%$keyword' OR student_name LIKE '%$keyword%' ";
    } else {
    $sqlmain= "SELECT * FROM student ORDER BY student_id DESC";

    }
    ?>
    <div data-aos="fade-up" data-aos-duration="1300" class="row" style="margin-top: 50px; margin-bottom: 70px;">
      <div class="col">
          <table class="styled-table">
            <thead>
              <tr>
                <th>Student</th>
                <th>Email</th>
                <th></th>
                <th>Birthdate</th>
                <th></th>
                <th>Actions</th>
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
    $student_id=$row["student_id"];
    $name=$row["student_name"];
    $email=$row["student_email"];
    $dob=$row["student_birthdate"];
    $tel=$row["student_phone"];
    $address=$row["student_address"];

    echo '
    <tbody>
    <tr>
      <td>'.substr($name,0,50).'</td>
      <td>'.substr($email,0,50).'</td>
      <td>'.substr($tel,0,19).'</td>
      <td>'.substr($dob,0,30).'</td>
      <td>'.substr($address,0,50).'</td>
      <td>
      <a href="?action=edit&id='.$student_id.'&error=0" class="btn btn-warning btn-sm">Edit</a>
      <a href="?action=drop&id='.$student_id.'&name='.$name.'" class="btn btn-danger btn-sm">Drop</a>
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
    if(isset($_GET["id"])) {

    $id=$_GET["id"];
    $action=$_GET["action"];
    if($action=='drop') {
    $nameget=$_GET["name"];
    echo '
    <div class="overlay">
    <div class="popup text-center">
      <img src="../asset/img/undraw_faq.svg" width="50%" style="margin-bottom: 10px;">
      <a class="close" href="student.php">&times;</a>
      <p>Drop this student?</p>
      <a href="delete_student.php?id='.$id.'" class="btn btn-warning btn-sm">Yes</a>
      </div>
    </div>
    </div>
    ';
    } elseif($action=='edit') {
      $sqlmain= "SELECT * FROM student WHERE student_id='$id'";
      $result= $database->query($sqlmain);
      $row=$result->fetch_assoc();
      $name=$row["student_name"];
      $email=$row["student_email"];
      $dob=$row["student_birthdate"];
      $tele=$row["student_phone"];
      $address=$row["student_address"];
      $error_1=$_GET["error"];
      $errorlist= array(
      '1'=>'<p class="text-center" style="color:rgb(255, 62, 62);">Already have an account for this email address.</p>',
      '2'=>'<p class="text-center" style="color:rgb(255, 62, 62);">Try to confirm your password again.</p>',
      '3'=>'<p class="text-center" style="color:rgb(255, 62, 62);"></p>',
      '4'=>"",
      '0'=>'',
  
      );
  
      if($error_1!='4') {
      echo '
      <div class="overlay">
      <div class="popup text-center" style="bottom: 40px;">
      <a class="close" href="student.php">&times;</a>
  
      <div class="row">
      <div class="col">
      '.$errorlist[$error_1].'
      </div>
      </div>
  
      <form action="edit_student.php" method="POST">
  
  
      <div class="form__group field">
        <input type="hidden" value="'.$id.'" name="id00">
        <input type="text" name="name" class="form__field" placeholder="Name" value="'.$name.'" required>
        <label for="name" class="form__label">Name: </label>
      </div>
  
      <div class="form__group field">
          <input type="email" name="email" class="form__field" placeholder="Email" value="'.$email.'" required>
          <label for="email" class="form__label">Email: </label>
      </div>

      <div class="form__group field">
          <input type="date" name="dob" class="form__field" placeholder="Birthday" value="'.$dob.'" required>
          <label for="dob" class="form__label">Birthday: </label>
      </div>
  
      <div class="form__group field">
          <input type="tel" name="Tele" class="form__field" placeholder="Phone" value="'.$tele.'" required>
          <label for="Tele" class="form__label">Phone: </label>
      </div>

      <div class="form__group field">
          <input type="text" name="address" class="form__field" placeholder="Address" value="'.$address.'" required>
          <label for="address" class="form__label">Address: </label>
      </div>
  
      <div class="form__group field">
          <input type="submit" value="Save" class="btn btn-warning btn-sm">
      </div>
  
      </form>
  
      </div>
      </div>
  
    
      ';
  
      } else {
      echo '
      <div class="overlay">
      <div class="popup text-center">
      <a class="close" href="student.php">&times;</a>
      <h3>Updated successfully!</h3>
      <a href="student.php" class="btn btn-warning btn-sm">Okay</a>
      </div>
      </div>
      ';
  
      };
    };
  };
  ?>

  </div>
</div>

<!-- footer -->
<?php include "section/footer.php" ?>