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
$username=$userfetch["student_name"];
  
?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container text-white">
    <?php
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d');
    $studentrow = $database->query("SELECT * FROM student;");
    $instructorrow = $database->query("SELECT * FROM instructor;");
    $enrollmentrow = $database->query("SELECT * FROM enrollment WHERE enrollment_date>='$today';");
    $schedulerow = $database->query("SELECT * FROM schedule WHERE schedule_date='$today';");  ?>
<div class="text-center"data-aos="zoom-in">
<img data-aos="zoom-in"src="../asset/img/logo.png" class="img-fluid mx-auto d block"  style="width: 70px;">
<h3> <span style="color:white;">Welcome to <span style="color:orange;">Mabuhay Driving School Lesson Academy<span style="color:white;">!</h3></div></span>
<br>
    <!--image slider start-->
    <div data-aos="fade-up" class="slider" height="1000">
      <div class="slides">
        <!--radio buttons start-->
        <input type="radio" name="radio-btn" id="radio1">
        <input type="radio" name="radio-btn" id="radio2">
        <input type="radio" name="radio-btn" id="radio3">
        <input type="radio" name="radio-btn" id="radio4">
      
        <!--radio buttons end-->
        <!--slide images start-->
        <div class="slide first">
         <a href="index.php">  <img src="../asset/img/advertisement-photo.png" alt="Advertisement"></a>
        </div>
        <div class="slide">
          <a href="index.php"><img src="../asset/img/banner4.jpg" alt=""></a>
        </div>
        <div class="slide">
          <a href="index.php"> <img src="../asset/img/banner2.jpg" alt=""></a>
        </div>
        <div class="slide">
         <a href="index.php">  <img src="../asset/img/banner5.png" alt=""></a>
        </div>
        <!-- <div class="slide">
          <img src="../asset/img/instructor2.png" alt="">
        </div>
        <div class="slide">
          <img src="../asset/img/instructor3.png" alt="">
        </div> -->
        <!--slide images end-->
        <!--automatic navigation start-->
        <div class="navigation-auto">
          <div class="auto-btn1"></div>
          <div class="auto-btn2"></div>
          <div class="auto-btn3"></div>
           <div class="auto-btn4"></div>
          <!-- <div class="auto-btn3"></div>
          <div class="auto-btn4"></div> -->
        </div>
        <!--automatic navigation end-->
      </div>
      <!--manual navigation start-->
      <div class="navigation-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
        <label for="radio4" class="manual-btn"></label>
        <!-- <label for="radio3" class="manual-btn"></label>
        <label for="radio4" class="manual-btn"></label> -->
      </div>
      <!--manual navigation end-->
    </div>
    <!--image slider end-->

    <script type="text/javascript">
    var counter = 1;
    setInterval(function(){
      document.getElementById('radio' + counter).checked = true;
      counter++;
      if(counter > 4){
        counter = 1;
      }
    }, 5000);
    </script>


    <div class="container" style="margin-top: 100px;">
        <div data-aos="fade-up" class="row justify-content-center">
          <div class="col-12 col-sm-8 col-lg-6">
            <!-- Section Heading-->
            <div class="section_heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp; margin-bottom: 70px;">
              <h3>Meet our instructors</h3>
              <p>Reliable Instructors to equip you with the right knowledge about driving and the right attitude while driving.</p>
              <div class="line"></div>
            </div>
          </div>
        </div>
        <div data-aos="fade-up" class="row">
          <!-- Single Advisor-->
          <div class="col-12 col-sm-6 col-lg-3">
           <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;"></a>
              <!-- Team Thumb-->
               <a href="schedule.php"><div class="advisor_thumb"><img src="../asset/img/1.png" width="200" alt=""></a>
                <!-- Social Info-->
                <!-- <div class="social-info"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a></div> -->
              </div>
              <!-- Team Details-->
              <a href="schedule.php"><div class="single_advisor_details_info"></a>
                <h6>Sheeva Canoy</h6>
            
              </div>
            </div>
          </div>
          <!-- Single Advisor-->
          <div data-aos="fade-up" class="col-12 col-sm-6 col-lg-3">
            <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
              <!-- Team Thumb-->
              <a href="schedule.php"><div class="advisor_thumb"><img src="../asset/img/2.png" width="200" alt=""></a>
                <!-- Social Info-->
                <!-- <div class="social-info"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a></div> -->
              </div>
              <!-- Team Details-->
              <a href="schedule.php"><div class="single_advisor_details_info"></a>
                <h6>Jule Ann Ferolino</h6>
              </div>
            </div>
          </div>
          <!-- Single Advisor-->
          <div data-aos="fade-up" class="col-12 col-sm-6 col-lg-3">
            <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
              <!-- Team Thumb-->
              <a href="schedule.php"><div class="advisor_thumb"><img src="../asset/img/4.png" width="200" alt=""></a>
                <!-- Social Info-->
                <!-- <div class="social-info"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a></div> -->
              </div>
              <!-- Team Details-->
              <a href="schedule.php"><div class="single_advisor_details_info"></a>
                <h6>Paolo Laña</h6>
              </div>
            </div>
          </div>
          <!-- Single Advisor-->
          <div data-aos="fade-up" class="col-12 col-sm-6 col-lg-3">
            <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
              <!-- Team Thumb-->
              <a href="schedule.php"><div class="advisor_thumb"><img src="../asset/img/3.png" width="200" alt=""></a>
                <!-- Social Info-->
                <!-- <div class="social-info"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a></div> -->
              </div>
              <!-- Team Details-->
              <a href="schedule.php"><div class="single_advisor_details_info"></a>
                <h6>Brian Villarin</h6>
               </div>
            </div>
          </div>
        </div>
      </div>



    <!-- row 1 -->
    <div data-aos="zoom-in" class="row" style="margin-top: 70px;">
      
      <div class="col text-center">
        <h1>Welcome,</h1>
        <h2><span class="text-warning"><?php echo ucwords($username); ?></span>!</h2>
        <p class="lead" style="margin-top: 50px;">Quality driving education for Theoretical Driving Course and Driving Enhancement Program.</p>
      </div>

    </div>

    <!-- row 2 -->
    <div class="row" style="margin-top: 100px;">
      
      <div data-aos="fade-up" class="col-md-6 text-center">
        <h2 class="text-warning">1</h2>
        <p class="lead">Pick a lesson from available schedule.</p>
        <div class="center">
        <a href="schedule.php"><img src="../asset/img/index1.png"  width="600"></a>
      </div>
      </div>
      
    </div>

    <!-- row 3 -->
    <div class="row" style="margin-top: 100px;">

      <div class="col">
      </div>

      <div data-aos="fade-up" class="col-md-6 text-center">
        <h2 class="text-warning">2</h2>
        <p class="lead">Enroll to the posted schedule from our instructors and wait for your application to be accepted.</p>
         <div class="center">
       <a href="enrollment.php"> <img src="../asset/img/index2.png" height="110" width="610"></a>
      </div>
      
    </div>
    
    <!-- row 4 -->
    <div class="row" style="margin-top: 100px;">
      
      <div data-aos="fade-up" class="col-md-6 text-center">
        <h2 class="text-warning">3</h2>
        <p class="lead">You can also message our instructors for inquiries.</p>
         <div class="center">
        <a href="chats.php"><img src="../asset/img/index3.png" width="580"></a>
      </div>
    </div>

      <div class="col">
      </div>
      
    </div>

    <!-- row 5 -->
    <div class="row" style="margin-top: 100px;">

      <div class="col">
      </div>

      <div data-aos="fade-up" class="col-md-6 text-center">
        <h2 class="text-warning">4</h2>
        <p class="lead">Once approved, you may attend the scheduled date.</p>
         <div class="center">
        <a href="enrollment.php"><img src="../asset/img/index4.png" height="100px" width="600px"></a>
      </div>
      
    </div>

    <!-- row 6 -->
    <div class="row" style="margin-top: 100px;">
      
      <div data-aos="fade-up" class="col-md-6 text-center">
        <h2 class="text-warning">5</h2>
        <p class="lead">Payment will only be settled onsite.</p>
         <div class="center">
        <img src="../asset/img/undraw_credit_card_payment_05.svg" width="200">
      </div>

      <div class="col">
      </div>
      
    </div>

    <!-- row 7 -->
    <div data-aos="fade-up" class="row" style="margin-top: 100px; margin-bottom: 200px;">

      <div class="col">
      </div>

      <div data-aos="fade-up" class="col-md-6 text-center">
        <h2 class="text-warning">6</h2>
        <p class="lead">After taking the lesson, wait for the release of results.</p>
         <div class="center">
       <a href="result.php"> <img src="../asset/img/index6.png" width="500"></a>
      </div>
      
    </div>

  </div>
</div>
<div class="text-center">
<p><span style="color:gray;">© 2022 Driving School</p>
</div>
<!-- footer -->
<?php include("section/footer.php"); ?>