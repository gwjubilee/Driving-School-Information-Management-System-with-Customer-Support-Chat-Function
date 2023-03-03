<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Mabuhay Driving Lesson Academy</title>
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="asset/css/bootstrap.css" rel="stylesheet">
    <link href="asset/css/animation.css" rel="stylesheet">
    <link href="asset/css/aos.css" rel="stylesheet">
    <link href="asset/img/logo.png" rel="icon">
    <!-- Slick slider -->
    <link href="asset/css/slick.css" rel="stylesheet">
    <style>
      div {
          animation: transitionIn-Y-bottom 1s;
      }
    </style>
</head>
<body>

<!-- header -->
<header class="p-3 text-bg-dark" style="font-size: large;">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
        <li><a href="about.php" class="nav-link px-2 text-warning">About</a></li>
      </ul>
      
      <div class="text-end">
        <a href="signin.php" type="button" class="btn btn-outline-light me-2">Sign in</a>
        <a href="signup.php" type="button" class="btn btn-warning">Sign up</a>
      </div>

    </div>
  </div>
</header>

<!-- content -->
<main class="bg-dark text-white">
  <div class="px-4 py-4 my-4 text-center">

    <h1 class="display-5 fw-bold">About <span class="text-warning">Us</span></h1>
    <img data-aos="fade-up" src="asset/img/undraw_team_spirit.svg" class="d-block mx-lg-auto rounded img-fluid" alt="About us" width="500" height="400" loading="lazy">

    <div class="col-lg-6 mx-auto" style="margin-top: 10px;">
      <p class="lead mb-4">
        We provide structured driving lessons and a team of reliable driving instructors.  Mabuhay Driving Lesson Academy Inc. is one of the best and most trusted driving school in your area.
      </p>

      <div data-aos="fade-up">
      <img src="asset/img/lto1.png" alt="Land Transportation Office" width="100" height="100" loading="lazy" style="margin-top: 100px;">
      <img src="asset/img/tesda1.png" alt="Land Transportation Office" width="100" height="100" loading="lazy" style="margin-top: 100px; margin-left: 30px;">
      </div>
      <p data-aos="fade-up" class="lead mb-4" style="margin-top: 10px;">
        ACCREDITED BY: Land Transportation Office (LTO) and Technical Education and Skills Development Authority (TESDA).
      </p>
      <p data-aos="fade-up" style="margin-top: 100px;">
        For more information, please feel free to visit any of our branches near you!
      </p>
      <p data-aos="fade-up">Call us: 0917-503-2648 (Globe), 0933-829-5429 (Smart), 218-0416 (Landline)</p>
      <p data-aos="fade-up">or email us at: <a href="mailto:tlmdla.info@gmail.com" class="text-warning">tlmdla.info@gmail.com</a></p>
    </div>
    
  </div>
</main>

<!-- footer -->
<?php include "section/footer.php"; ?>

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