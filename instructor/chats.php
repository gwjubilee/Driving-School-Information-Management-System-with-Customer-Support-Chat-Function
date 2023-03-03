<?php

session_start();

// if user not logged in

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

?>
<!-- header -->
<?php include "section/header.php" ?>

<body onLoad = "myFunction()">

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
    <div class="container text-white">

 <div data-aos="fade-up" class="row" style="margin-top: 30px; margin-bottom: 50px;">

    <div class="col-2">
      <img src="../asset/img/undraw_educator.svg" width="170" style="margin-top: 10px;">
    </div>

    <div data-aos="fade-up" data-aos-duration="1000"  class="col-9 flex" style="margin-left: 70px;">
      <h3 class="text-warning" style="margin-bottom: 20px;">Chat with students</h3>
      <p>Chats received from students will appear below.</p>
      <?php
        $getUser = "SELECT * FROM instructor WHERE instructor_email = '$useremail'";
        $getUserStatus = mysqli_query($database,$getUser) or die(mysqli_error($database));
        $getUserRow = mysqli_fetch_assoc($getUserStatus);
      ?>
    </div>


  </div>

    <!-- chats section -->
    <div class="container mt-4">

      <!-- session message -->
      <div class="text-center" data-aos="fade-up">
      <?php
        include "snackbar.php";
      ?>
      </div>

      <div data-aos="fade-up" class="card bg-dark" style="margin-bottom: 100px; background-color: #23272a; width: 70%; margin:auto;">
        <div class="card-title text-center">
          <!-- form -->
          <form class="form-inline mt-4" style = "display : inline-block" method = "POST" action = "search-users.php">
            <input class="form-control mr-sm-2" type="search" name = "search" placeholder="Search for a student" aria-label="Search" style="margin-bottom: 20px;">
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>

        <div class="card-body mb-4">
          <?php
            $lastMessage = "SELECT DISTINCT sent_by FROM messages WHERE received_by = '$useremail'";
            $lastMessageStatus = mysqli_query($database,$lastMessage) or die(mysqli_error($database));
            if(mysqli_num_rows($lastMessageStatus) > 0) {
              while($lastMessageRow = mysqli_fetch_assoc($lastMessageStatus)) {
                $sent_by = $lastMessageRow['sent_by'];
                // changeable user
                $getSender = "SELECT * FROM student WHERE student_email = '$sent_by'";
                // $getSender = "SELECT * FROM users WHERE email = '$sent_by'";
                $getSenderStatus = mysqli_query($database,$getSender) or die(mysqli_error($database));
                $getSenderRow = mysqli_fetch_assoc($getSenderStatus);
          ?>
          <div class="card text-white" style="background-color: #2c2f33;">
            <div class="card-body">
              <h6><strong><?=$lastMessageRow['sent_by'];?></strong><a href="./message.php?receiver=<?=$sent_by?>" class="btn btn-outline-warning" style = "float:right">Send message</a></h6>
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

    </div>
</div>


  <!-- Bootstrap scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <!-- Scripts -->
  <script src="snackbar.js"></script>


<!-- footer -->
<?php include("section/footer.php"); ?>