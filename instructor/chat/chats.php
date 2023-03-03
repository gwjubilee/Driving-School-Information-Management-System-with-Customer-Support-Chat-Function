<?php

session_start();

// if user not logged in

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
require_once "../../include/connection.php";

?>
<!-- header -->
<?php include "../section/header.php" ?>

<body onLoad = "myFunction()">

<!-- side navigation bar -->
<?php include "../section/sidebar.php" ?>

<div class="main">
    <div class="container text-white">


<div data-aos="fade-up" class="row" style="margin-top: 30px; margin-bottom: 100px;">

    <div class="col-2">
  <img src="../asset/img/undraw_educator.svg" width="170" style="margin-top: 10px;">
  </div>

  <div data-aos="fade-up" data-aos-duration="1000"  class="col-9 flex" style="margin-left: 70px;">
  <h3 class="text-warning" style="margin-bottom: 20px;">Chat with instructors</h3>
  <p>Chats received from instructors will appear below.</p>
      <?php
        $getUser = "SELECT instructor_email FROM instructor";
        $getUserStatus = mysqli_query($database,$getUser) or die(mysqli_error($database));
        $getUserRow = mysqli_fetch_assoc($getUserStatus);
        $instructor_email = $getUserRow["instructor_email"];
      ?>
 </div>
</div>
    <!-- chats section -->
    <div class="container mt-4">

      <!-- session message -->
      <?php
        include "snackbar.php";
      ?>


<div data-aos="fade-up" data-aos-duration="1200" class="card-body mb-4" style="width: 70%; margin: auto;">

        <div class="card-body mb-4">
          <?php
            $lastMessage = "SELECT DISTINCT sent_by FROM messages WHERE received_by = '$instructor_email'";
            $lastMessageStatus = mysqli_query($database,$lastMessage) or die(mysqli_error($database));
            if(mysqli_num_rows($lastMessageStatus) > 0) {
              while($lastMessageRow = mysqli_fetch_assoc($lastMessageStatus)) {
                $sent_by = $lastMessageRow['sent_by'];
                $getSender = "SELECT * FROM student WHERE student_email = '$sent_by'";
                $getSenderStatus = mysqli_query($database,$getSender) or die(mysqli_error($database));
                $getSenderRow = mysqli_fetch_assoc($getSenderStatus);
          ?>
          <div class="card text-white" style="background-color: #2c2f33;">
            <div class="card-body">
              <h6><strong><?=$lastMessageRow['received_by'];?></strong><a href="./message.php?receiver=<?=$sent_by?>" class="btn btn-outline-warning" style = "float:right">Chat</a></h6>
            </div>
          </div><br/>
          <?php
            }
          } else {
          ?>
            <div class="card-body text-center">
              <h6><strong>No conversations yet</strong></h6>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="snackbar.js"></script>

    </div>
</div>
<!-- footer -->
<?php include("../section/footer.php"); ?>