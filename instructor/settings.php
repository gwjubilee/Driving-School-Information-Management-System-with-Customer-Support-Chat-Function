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
  
?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
<div class="container text-white">

<img data-aos="fade-up" src="../asset/img/undraw_personal_information.svg"
 class="d-block mx-lg-auto img-fluid" alt="Driving school banner" style="margin-top: 20px;" width="250" height="250" loading="lazy">

<div class="row text-center" style="margin-top: 50px;">
    <div class="col">
        <p><svg class="bi" width="18" height="18"><use xlink:href="#person"/></svg>
        Account settings</p>
        <a data-aos="fade-up" href="?action=view&id=<?php echo $userid ?>&error=0" class="text-warning"><small>View and edit your account details & change password</small></a>
    </div>
</div>

    <!-- code for prompt -->
    <?php 
    if($_GET) {

    $id=$_GET["id"];
    $action=$_GET["action"];
    
    if($action=='view') {
    $sqlmain= "SELECT * FROM instructor WHERE instructor_id='$id'";
    $result= $database->query($sqlmain);
    $row=$result->fetch_assoc();
    $name=$row["instructor_name"];
    $email=$row["instructor_email"];
    $tele=$row['instructor_phone'];

    echo '
    <div class="overlay">
    <div class="popup">
    <a class="close" href="settings.php">&times;</a>
        
    <div class="panel" style="margin-left: 10px;">
    <div class="panel-body bio-graph-info">
        <h1 class="text-warning" style="margin-bottom: 25px;">Personal Information</h1>
        <div class="row">
            <div class="bio-row">
                <p><span>Name </span>: '.$name.'</p>
            </div>
            <div class="bio-row">
                <p><span>Email </span>: '.$email.'</p>
            </div>
            <div class="bio-row">
                <p><span>Phone </span>: '.$tele.'</p>
            </div>
            <div class="bio-row text-center" style="margin-top: 15px;">
            <a href="?action=edit&id='.$userid.'&error=0" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
    </div>
    </div>
    
    </div>
    </div>
    ';
} elseif($action=='edit') {
    $sqlmain= "SELECT * FROM instructor WHERE instructor_id='$id'";
    $result= $database->query($sqlmain);
    $row=$result->fetch_assoc();
    $name=$row["instructor_name"];
    $email=$row["instructor_email"];
    $tele=$row['instructor_phone'];
    $password=$row['instructor_password'];

    $error_1=$_GET["error"];
    $errorlist= array(
    '1'=>'<p style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this email address.</p>',
    '2'=>'<p style="color:rgb(255, 62, 62);text-align:center;">Try to confirm your password again.</p>',
    '3'=>'<p style="color:rgb(255, 62, 62);text-align:center;"></p>',
    '4'=>"",
    '0'=>'',

    );

    if($error_1!='4') {
    echo '
    <div class="overlay">
    <div class="popup" style="bottom: 70px;">
    <a class="close" href="settings.php">&times;</a>
    
    <p class="text-center text-warning">'.$errorlist[$error_1].'</p>

    <div class="form__group field">
    <p>User ID : '.$id.' (Auto Generated)</p>
    </div>

    <form action="edit_user.php" method="POST">


    <div class="form__group field">
        <input type="hidden" value="'.$id.'" name="id00">
        <input type="hidden" name="oldemail" value="'.$email.'">
        <input type="email" name="email" class="form__field" placeholder="Email Address" value="'.$email.'" required>
        <label for="email" class="form__label">Email</label>
    </div>

    <div class="form__group field">
        <input type="text" name="name" class="form__field" placeholder="Name" value="'.$name.'" required>
        <label for="name" class="form__label">Name: </label>
    </div>

    <div class="form__group field">
        <input type="tel" name="Tele" class="form__field" placeholder="Phone" value="'.$tele.'" required>
        <label for="Tele" class="form__label">Phone: </label>
    </div>

    <div class="form__group field">
        <input type="password" name="password" class="form__field" placeholder="Password" required>
        <label for="password" class="form__label">Password: </label>
    </div>

    <div class="form__group field">
        <input type="password" name="cpassword" class="form__field" required>
        <label for="cpassword" class="form__label">Confirm Password: </label>
    </div>

    <div class="form__group field">
        <input type="reset" value="Reset" class="btn btn-warning btn-sm" >
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
        <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
        <a class="close" href="settings.php">&times;</a>
        <p>Successfully updated!</p>
        <a href="settings.php" class="btn btn-warning btn-sm">Okay</a>
        </div>
    </div>
    </div>
    ';

    }; }
}

    ?>

</div>
</div>
</body>

<!-- footer -->
<?php include("section/footer.php"); ?>