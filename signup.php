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


if(isset($_POST['signup'])) {

  $_SESSION["personal"]=array(
    'first_name'=>$_POST['first_name'], 
    'middle_name'=>$_POST['middle_name'],
    'last_name'=>$_POST['last_name'],
    'birthdate'=>$_POST['birthdate']
);

  $result = $database->query("SELECT * from webuser");

  $first_name = $_SESSION['personal']['first_name'];
  $middle_name = $_SESSION['personal']['middle_name'];
  $last_name = $_SESSION['personal']['last_name'];
  $name = $first_name." ".$middle_name." ".$last_name;
  $birthdate = $_SESSION['personal']['birthdate'];
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  
  $result= $database->query("SELECT * FROM webuser WHERE email='$email';");
  if($result->num_rows==1){
    $message='<p class="form-label text-center text-danger">Email already exists.</p>';
  } else {
      
    $database->query("INSERT INTO student(student_email, student_name, student_password, student_birthdate) VALUES('$email','$name','$password','$birthdate');");
    $database->query("INSERT INTO webuser VALUES('$email','student')");

    //print_r("INSERT INTO student VALUES('$email','$name','$password','$birthdate');");
    $_SESSION["user"]=$email;
    $_SESSION["usertype"]="student";
    $_SESSION["username"]=$first_name;
    $_SESSION["message"]= "Signed up successfully!";

    header('location: signin.php');
  }
    
} else {
    //header('location: signup.php');
    $message='<p class="form-label text-center text-danger"></p>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | Mabuhay Driving Lesson Academy</title>
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
      
        
        <li><a data-aos="fade-up" data-aos-duration="1700" href="index.php"  class="nav-link px-2 text-warning">Home</a></li>
        <li><a data-aos="fade-up" data-aos-duration="1900" href="about.php" class="nav-link px-2 text-white">About</a></li>
      </ul>
      
      

    </div>
  </div>
</header>
<main class="form-signin w-100 m-auto bg-dark text-white">

  <!-- form -->
  <form action="" method="POST">

    <!-- message -->
    <div data-aos="fade-up" data-aos-duration="500"style="margin: 10px 0 10px 0; margin-bottom: 10px;"><?php echo $message; ?></div>
    
    <!-- logo -->
    <a data-aos="fade-up" href="index.php"><img data-aos="fade-up" class="img-fluid rounded mx-auto d-block" src="asset/img/logo.png" alt="" width="72" height="72"></a>

    <!-- heading -->
    <div data-aos="fade-up" data-aos-duration="1300" class="text-center" style="margin: 10px 0 20px 0;">
      <h2>Let's get started</h2>
      <p>Add your personal details to continue</p>
    </div>

    <!-- first name -->
    <div data-aos="fade-up" data-aos-duration="1000" class="form-floating">
      <input name="first_name" type="text" class="form-control top" id="floatingInput" placeholder="First name" required>
      <label for="floatingInput" class="text-dark">First name</label>
    </div>

    <!-- middle name -->
    <div data-aos="fade-up" data-aos-duration="1000" class="form-floating">
      <input name="middle_name" type="text" class="form-control middle" id="floatingInput" placeholder="Middle name">
      <label for="floatingInput" class="text-dark">Middle name</label>
    </div>

    <!-- last name -->
    <div data-aos="fade-up" data-aos-duration="1000" class="form-floating">
      <input name="last_name" type="text" class="form-control middle" id="floatingInput" placeholder="Last name" required>
      <label for="floatingInput" class="text-dark">Last name</label>
    </div>

    <!-- birthdate -->
    <div data-aos="fade-up" data-aos-duration="1000" class="form-floating">
      <input name="birthdate" type="date" class="form-control bottom" id="floatingInput" placeholder="Birthdate" onfocus="(this.type='date')"  min="1900-01-01" max="2003-12-31" required>
      <label for="floatingInput" class="text-dark">Birthdate</label>
    </div>

    <!-- email -->
    <div data-aos="fade-up" data-aos-duration="1000" class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="Email" required>
      <label for="floatingInput" class="text-dark">Email</label>
    </div>

    <!-- password -->
    <div data-aos="fade-up" data-aos-duration="1000" class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingInput" placeholder="Password" required>
      <label for="floatingInput" class="text-dark">Password</label>
    </div>

    <!-- button -->
    <button data-aos="fade-up" data-aos-duration="800" class="w-100 btn btn-lg btn-warning" name="signup" type="submit">Sign up</button>

    <!-- sign in link -->
    <div class="text-center" style="margin-top: 20px;">
      <p class="text-center">Already have an account?<a class="text-decoration-none text-warning" href="signin.php"> Sign in</a>.</p>
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