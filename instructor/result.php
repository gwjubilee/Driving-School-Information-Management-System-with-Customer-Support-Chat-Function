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

$userrow = mysqli_query($database, "SELECT * FROM schedule,student WHERE student_email='$useremail'") or die(mysqli_error($database));

if (mysqli_num_rows($userrow) > 0) {
$userfetch = mysqli_fetch_assoc($userrow);

$userid = $userfetch["student_id"];
$username = $userfetch["student_name"];

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
<div class="container text-white">



</div>
</div>

<!-- footer -->
<?php } include("section/footer.php"); ?>