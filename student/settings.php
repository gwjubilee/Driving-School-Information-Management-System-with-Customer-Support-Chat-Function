<?php

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
  
?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
<div class="container text-white">

<img data-aos="fade-up" src="../asset/img/undraw_personal_information.svg" class="d-block mx-lg-auto img-fluid" alt="Driving school banner" style="margin-top: 20px;" width="250" height="250" loading="lazy">

<div class="row text-center" style="margin-top: 50px;">
    <div class="col">
        <p><svg class="bi" width="18" height="18"><use xlink:href="#person"/></svg>
        Account settings</p>
        <a data-aos="fade-up" href="?action=view&id=<?php echo $userid ?>&error=0" class="text-warning"><small>View and edit your account details & change password</small></a>
    </div>
</div>


<!-- row 4 -->
<div class="row text-center">
    <div class="col" style="margin-top: 20px;">
        
        <p><svg class="bi" width="18" height="18"><use xlink:href="#delete-forever"/></svg>
        Delete Account</p>
        <a data-aos="fade-up" href="?action=drop&id=<?php echo $userid.'&name='.$username ?>" class="text-warning"><small>This will permanently remove your account</small></a>
    </div>
</div>

<!-- code for prompt -->
    <?php 
    if($_GET) {

    $id=$_GET["id"];
    $action=$_GET["action"];
    if($action=='drop') {
    $nameget=$_GET["name"];
    echo '
    <div class="overlay">
    <div class="popup text-center">
        <img src="../asset/img/undraw_feeling_blue.svg" width="50%" style="margin-bottom: 10px;">
        <a class="close" href="settings.php">&times;</a>
        <p>Are you sure?<br />This will permanently delete your account: <span class="text-warning">('.substr($nameget,0,40).')</span><br /></p>
        <a href="delete_account.php?id='.$id.'" class="btn btn-warning btn-sm" style="padding: 6px; width: 60px;">Yes</a>
        </div>
    </div>
    </div>
    ';

    } elseif($action=='view') {
    $sqlmain= "SELECT * FROM student WHERE student_id='$id'";
    $result= $database->query($sqlmain);
    $row=$result->fetch_assoc();
    $name=$row["student_name"];
    $email=$row["student_email"];
    $address=$row["student_address"];


    $dob=$row["student_birthdate"];
    $tele=$row['student_phone'];
    echo '
    <div class="overlay">
    <div class="popup">
    <a class="close" href="settings.php">&times;</a>
        
    <div class="panel" style="width: auto;">
    <div class="panel-body bio-graph-info">
        <h1 class="text-warning" style="margin-bottom: 25px;">Personal Information</h1>
        <div class="row">
            <div class="bio-row">
                <p><span class="text-warning">Name </span>: '.$name.'</p>
            </div>
            <div class="bio-row">
            <p><span class="text-warning">Student ID </span>: '.$id.'</p>
          </div>
            <div class="bio-row">
                <p><span class="text-warning">Email </span>: '.$email.'</p>
            </div>
            <div class="bio-row">
                <p><span class="text-warning">Phone </span>: '.$tele.'</p>
            </div>
            <div class="bio-row">
                <p><span class="text-warning">Address</span>: '.$address.'</p>
            </div>
            <div class="bio-row">
                <p><span class="text-warning">Birthday </span>: '.$dob.'</p>
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
    $sqlmain= "SELECT * FROM student WHERE student_id='$id'";
    $result= $database->query($sqlmain);
    $row=$result->fetch_assoc();
    $name=$row["student_name"];
    $email=$row["student_email"];
    $address=$row["student_address"];
    $tele=$row['student_phone'];


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
    <div class="popup" style="bottom: 100px;">
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
        <input type="text" name="address" class="form__field" placeholder="Address" value="'.$address.'" required>
        <label for="address" class="form__label">Address: </label>
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

<!-- footer -->
<?php include("section/footer.php"); ?>