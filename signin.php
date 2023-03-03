<?php

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');

$_SESSION["date"]=$date;

//import database
require_once "include/connection.php";


if(isset($_POST['signin'])) {

    $email=$_POST['email'];
    $password=$_POST['password'];
    
    $error='<label for="promter" class="form-label"></label>';

    $result= $database->query("SELECT * FROM webuser WHERE email='$email'");

    if($result->num_rows==1){

        $utype=$result->fetch_assoc()['usertype'];

        if ($utype=='student'){
          
          $checker = $database->query("SELECT * FROM student WHERE student_email='$email' and student_password='$password'");
          
          if ($checker->num_rows==1){

            // student dashbord
            $_SESSION['user']=$email;
            $_SESSION['usertype']='student';
            
            header('location: student/index.php');

          }else{
              $error='<label for="promter" class="form-label" style="color:#cc0000;">Invalid email or password</label>';
          }

        } elseif($utype=='admin'){
          $checker = $database->query("SELECT * FROM `admin` WHERE admin_email='$email' and admin_password='$password'");
          if ($checker->num_rows==1){

            //   Admin dashbord
            $_SESSION['user']=$email;
            $_SESSION['usertype']='admin';
            
            header('location: admin/index.php');

          }else{
              $error='<label for="promter" class="form-label" style="color:#cc0000;">Invalid email or password</label>';
          }

        } elseif($utype=='instructor') {
            $checker = $database->query("SELECT * FROM instructor WHERE instructor_email='$email' and instructor_password='$password'");
            if ($checker->num_rows==1){

              //   instructor dashbord
              $_SESSION['user']=$email;
              $_SESSION['usertype']='instructor';
              header('location: instructor/index.php');

            }else{
                $error='<label for="promter" class="form-label" style="color:#cc0000;">Invalid email or password</label>';
            }

        }
        
    } else {
        $error='<label for="promter" class="form-label" style="color:#cc0000;">No account associated to this email.</label>';
    }

} else {
    $error='<label for="promter" class="form-label">&nbsp;</label>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | Mabuhay Driving Lesson Academy</title>
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="asset/css/bootstrap.css" rel="stylesheet">
    <link href="asset/css/aos.css" rel="stylesheet">
    <link href="asset/css/signin_signup.css" rel="stylesheet">
    <link href="asset/img/logo.png" rel="icon">
    <!-- Slick slider -->
    <link href="asset/css/slick.css" rel="stylesheet">

</head>
<body>
  
<header class="p-3 text-bg-dark" style="font-size: large;">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li data-aos="fade-up" data-aos-duration="1700"><a href="index.php"  class="nav-link px-2 text-warning">Home</a></li>
        <li data-aos="fade-up" data-aos-duration="1900"><a href="about.php" class="nav-link px-2 text-white">About</a></li>
      </ul>
      

    </div>
  </div>
</header>
<main class="form-signin w-100 m-auto bg-dark text-white">

  <!-- form -->
  <form action="" method="POST">
    
    <!-- message -->
    <div class="text-center">
      <?php echo $error; ?>
    </div>

    <div data-aos="fade-up" class="text-center text-success" style="margin-bottom: 20px;">
    <?php
    
    $_SESSION['message']= "";
      
      if($_SESSION['message']){
        echo $_SESSION['message'];
      }
      ?>

    </div>
    <!--end message  -->

    <!-- logo -->
    <a href="index.php"><img data-aos="fade-up" class="img-fluid rounded mx-auto d-block" src="asset/img/logo.png" alt="" width="72" height="72"></a>

    <!-- heading -->
    <div data-aos="fade-up" data-aos-duration="1300" class="text-center" style="margin: 10px 0 20px 0;">
      <h2>Welcome back!</h2>
      <p>Sign in with your details to continue</p>
    </div>

    <!-- email -->
    <div data-aos="fade-up" data-aos-duration="1000"  class="form-floating bg-dark">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
      <label for="floatingInput" class="text-dark">Email</label>
    </div>

    <!-- password -->
    <div data-aos="fade-up" data-aos-duration="1000"  class="form-floating bg-dark bottom-space">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword" class="text-dark">Password</label>
    </div>

    <!-- button -->
    <button data-aos="fade-up" data-aos-duration="1300" class="w-100 btn btn-lg btn-warning" name="signin" type="submit">Sign in</button>

    <!-- sign up -->
    <div class="text-center" style="margin-top: 20px;">
      <p>New to Driving School?<a class="text-decoration-none text-warning" href="signup.php"> Create account</a>.</p>
    </div>

    <!-- footer -->
    <?php include "section/footer.php"; ?>

  </form>
</main>

<script src="asset/js/bootstrap.bundle.js"></script>
<script src="asset/js/aos.js"></script>
<script src="asset/js/jquery-3.6.1.min.js"></script>
<script src="asset/js/slick.min.js"></script>
<script type="text/javascript">
  AOS.init({
    duration: 1500,
  }
  );
  
</script>
</body>
</html>