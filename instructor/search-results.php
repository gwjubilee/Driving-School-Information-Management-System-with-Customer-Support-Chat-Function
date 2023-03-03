<?php

session_start();

// if user not logged in

if(isset($_SESSION["user"])) {
  if(($_SESSION["user"])=="" or $_SESSION['usertype']!='instructor') {
    header("location: ../signin.php");
  } else {
    $useremail=$_SESSION["user"];
  }
  $search = $_SESSION['search'];

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

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="#"></a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php
        $getUser = "SELECT * FROM instructor WHERE instructor_email = '$useremail'";
        $getUserStatus = mysqli_query($database,$getUser) or die(mysqli_error($database));
        $getUserRow = mysqli_fetch_assoc($getUserStatus);
      ?>
  </div>
</nav>

    <!-- chats section -->
    <div class="container mt-4" style="margin-bottom: 100px; background-color: #23272a; width: 70%; margin:auto;">>
      <div class="text-center" style="margin-bottom: 50px;">
      <!-- session message -->
      <div class="text-center">
      <?php
        include "snackbar.php";
      ?>
      </div>
      </div>
      <div class="card" style="margin-bottom: 100px; background-color: #2c2f33;">
        <div class="card-title text-center">
          <!-- form -->
          <form class="form-inline mt-4" style = "display : inline-block" method = "POST" action = "search-users.php">
            <input class="form-control mr-sm-2" type="search" name = "search" placeholder="Search" aria-label="Search" style="margin-bottom: 20px;">
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>

        <!-- search for students only -->
        <div class="card-body mb-4" style="margin-top: 50px;">
          <?php
            $searchUser = "SELECT * FROM student WHERE student_name = '$search' OR student_email = '$search'";
            $searchUserStatus = mysqli_query($database,$searchUser) or die(mysqli_error($database));
            if(mysqli_num_rows($searchUserStatus) > 0) {
                while($searchUserRow = mysqli_fetch_assoc($searchUserStatus)){
                    $email = $searchUserRow['student_email'];
          ?>
          <div class="card text-white" style="background-color: #23272a;">
            <div class="card-body">
                <h6><strong><?=$searchUserRow['student_name']?></strong><a href="message.php?receiver=<?=$email?>" class="btn btn-outline-warning" style = "float:right">Send message</a></h6>
            </div>
          </div>
          <?php
                }
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
<?php include("section/footer.php"); ?>