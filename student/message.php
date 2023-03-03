<?php

session_start();

// if user not logged in

error_reporting(0);

if(isset($_SESSION["user"])) {
  if(($_SESSION["user"])=="" or $_SESSION['usertype']!='student') {
    header("location: ../signin.php");
  } else {
    $useremail=$_SESSION["user"];
  } 
  $receiver = $_GET['receiver'];

} else {
    header("location: ../signin.php");
}


//import database
require_once "../include/connection.php";

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
    <div class="container text-white">

    <div id="back_button">
        <a href="chats.php" class="text-warning" style="font-size: larger; margin-left: 10px;"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
    </div>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php
        $getUser = "SELECT * FROM student WHERE student_email = '$useremail'";
        $getUserStatus = mysqli_query($database,$getUser) or die(mysqli_error($database));
        $getUserRow = mysqli_fetch_assoc($getUserStatus);
      ?>
      <h3 data-aos="fade-up" style="margin-top: 20px;"><?=$getUserRow['student_name']?></h3>
  </div>
</nav>
    <div class="container" style="margin-bottom: 100px; background-color: #23272a; width: 70%; margin:auto;">
        <?php
            $getReceiver = "SELECT * FROM instructor WHERE instructor_email = '$receiver'";
            $getReceiverStatus = mysqli_query($database,$getReceiver) or die(mysqli_error($database));
            $getReceiverRow = mysqli_fetch_assoc($getReceiverStatus);
            $received_by = $getReceiverRow['instructor_email'];
        ?>
        <div class="card mt-4" style="background-color: #2c2f33;">
            <div class="card-header">
                <h6><strong><?=$getReceiverRow['instructor_name']?></strong><br /><i class="text-warning"><?=$receiver?></i></h6>
            </div>
            <?php
                $getMessage = "SELECT * FROM messages WHERE sent_by = '$receiver' AND received_by = '$useremail' OR sent_by = '$useremail' AND received_by = '$receiver' ORDER BY createdAt asc";
                $getMessageStatus = mysqli_query($database,$getMessage) or die(mysqli_error($database));
                if(mysqli_num_rows($getMessageStatus) > 0) {
                    while($getMessageRow = mysqli_fetch_assoc($getMessageStatus)) {
                        $message_id = $getMessageRow['id'];
            ?>
            <div class="card-body">
                <h6 class="text-warning"><?=$getMessageRow['sent_by']?></h6>
                <div class="message-box ml-4">    
                    <p><?=$getMessageRow['message']?></p>
                </div>
            </div>
            <?php
                    } 
                } else {
            ?>
            <div class="card-body">
                    <p class="text-center" style="color:lightgrey">No messages yet. Say 'Hi!'</p>
            </div>
            <?php
                }
            ?>
            <div class="card-footer text-center" style="margin-top: 100px;">
            <form action="send.php" method = "POST" style = "display: inline-block">
            <input type="hidden" name = "sent_by" value = "<?=$useremail?>"/>
            <input type="hidden" name = "received_by" value = "<?=$receiver?>"/>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" name = "message" id = "message" class="form-control" placeholder = "Type your message here" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type = "submit" class="btn btn-warning">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

 <!-- Bootstrap scripts -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </div>
</div>
<!-- footer -->
<?php include("section/footer.php"); ?>