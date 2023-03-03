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
$userrow = $database->query("SELECT * FROM student where student_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["student_id"];
$username=$userfetch["student_name"];


//echo $userid;
//echo $username;


$sqlmain= "SELECT enrollment.enrollment_id,schedule.schedule_id,schedule.title,schedule.course_type,instructor.instructor_name,student.student_name,schedule.schedule_date,schedule.schedule_time,enrollment.enrollment_date,enrollment.enrollment_status FROM schedule INNER JOIN enrollment on schedule.schedule_id=enrollment.schedule_id INNER JOIN student ON student.student_id=enrollment.student_id INNER JOIN instructor ON schedule.instructor_id=instructor.instructor_id WHERE student.student_id=$userid ";

if($_POST){
    //print_r($_POST);
    
    if(!empty($_POST["schedule_date"])){
        $schedule_date=$_POST["schedule_date"];
        $sqlmain.=" AND schedule.schedule_date='$schedule_date' ";
    };



    //echo $sqlmain;

}

$sqlmain.="ORDER BY enrollment.enrollment_date ASC";
$result= $database->query($sqlmain);
?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
    <div class="container text-white">
        
        <form action="" method="POST">
        <div class="row text-center">
            <div class="col">
                <div class="box">
                <div data-aos="fade-up" class="container-1">
                    <form action="" method="post">                   
                    <input type="date" name="shedule_date" style="height: 35px; border-radius: 7px; padding:10px;">
                    <input type="submit" name="filter" value=" Filter" class="btn btn-warning btn-sm" style="padding: 5px;">
                    </form>
                </div>
                </div>

            </div>
        </div>

        <!-- row 2 -->
        <div class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
        <div data-aos="fade-up" class="col">
            <p>My Enrollment (<?php echo $result->num_rows; ?>)</p>
        </div>
        </div>


        <div data-aos="fade-up" data-aos-duration="1200" class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
            <div class="col">
            <a href="enrollment_request.php" class="btn btn-warning" style="padding: 7px;">View my enrollment application</a>
            </div>
        </div>


        <!-- row 3 -->
        <div class="row" style="margin-left: auto;">
        <div data-aos="fade-up" class="col">
            <table class="styled-table">
            <thead>
                <tr>
               
                <th>Course Type</th>
                <th>Instructor</th>
                <th>Date</th>
                <th>Time Starts</th>
                <th>Status</th>
                <th></th>
                </tr>
            </thead>
                <?php
                if($result->num_rows==0) {
                echo '
                <div class="row" style="position: absolute; margin-top: 100px; left: 41%;">
                <div data-aos="fade-up" class="col">
                    <img src="../asset/img/undraw_taken.svg" width="25%">
                    <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">Select schedule first.</p>
                </div>
                </div> 
                ';
                } else {
                for($x=0; $x<($result->num_rows);$x++) {
                for($q=0;$q<3;$q++) {
                $row=$result->fetch_assoc();
                if(!isset($row)) {
                break;
                };
                $enrollment_id=$row["enrollment_id"];
                $schedule_id=$row["schedule_id"];
                $title=$row["title"];
                $instructor_name=$row["instructor_name"];
                $schedule_date=$row["schedule_date"];
                $schedule_time=$row["schedule_time"];
                $enrollment_date=$row["enrollment_date"];
                $course_type=$row["course_type"];
                $enrollment_status=$row["enrollment_status"];

                if($schedule_id=="") {
                break;
                }
                echo '
                <tbody>
                <tr>
              
                    <td>'.$course_type.'</td>
                    <td>'.$instructor_name.'</td>
                    <td>'.$schedule_date.'</td>
                    <td>'.$schedule_time.'</td>
                    <td class="text-success">'.$enrollment_status.'</td>
                    <td>
                    <a href="view_enroll_application.php?id='.$enrollment_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-warning btn-sm" style="margin:7px;">View my application</a>
                    </td>
                </tr>
              </tbody>
                ';
                }
                }
                }
                ?>
            </table>
            </div>
        </div>

        <!-- code for actions -->
        <?php
        if($_GET) {
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='enrollment_added') {
        echo '
        <div class="overlay">
            <div class="popup text-center">
                <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
                <a class="close" href="instructor.php">&times;</a>
                <p>Your enrollment request has been received. Please wait for the instructor to approve or disapprove your enrollment.</p>
                <a href="enrollment.php" class="btn btn-warning btn-sm">Okay</a>
                </div>
            </div>
        </div>
        ';
        } else if($action=='enrollment_request_added') {
            echo '
            <div class="overlay">
                <div class="popup text-center">
                    <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
                    <a class="close" href="enrollment.php">&times;</a>
                    <p>Your enrollment request has been sent. Please wait for the instructor to approve your enrollment.</p>
                    <a href="enrollment.php" class="btn btn-warning btn-sm">Okay</a>
                    </div>
                </div>
            </div>
            ';
        } elseif($action=='drop') {
        $title=$_GET["title"];
        $instructor_name=$_GET["instructor_name"];

        echo '
        <div class="overlay">
            <div class="popup text-center">
                <img src="../asset/img/undraw_faq.svg" width="50%" style="margin-bottom: 10px;">
                <a class="close" href="enrollment.php">&times;</a>
                <p>Drop this enrollment?</p>
                <a href="delete_enrollment.php?id='.$id.'" class="btn btn-warning btn-sm">Yes</a>
                </div>
            </div>
        </div>
        '; 
        } elseif($action=='view') {
        $sqlmain= "SELECT * FROM instructor WHERE instructor_id='$id'";
        $result= $database->query($sqlmain);
        $row=$result->fetch_assoc();
        $name=$row["instructor_name"];
        $email=$row["instructor_email"];
        $tele=$row['instructor_phone'];
        echo '
        <div class="overlay">
        <div class="popup">
        <a class="close" href="enrollment.php">&times;</a>
        <h3>Enrollment details</h3>

        <div class="row">
        <div class="col">
        <p>Name:</p>
        </div>
        <div class="col">
        <p>'.$name.'</p>
        </div>
        </div>

        <div class="row">
        <div class="col">
        <p>Email:</p>
        </div>
        <div class="col">
        <p>'.$email.'</p>
        </div>
        </div>

        <div class="row">
        <div class="col">
        <p>Phone number:</p>
        </div>
        <div class="col">
        <p>'.$tele.'</p>
        </div>
        </div>

        <div class="row">
        <div class="col">
        <a href="instructor.php" class="btn btn-warning btn-sm">Okay</a>
        </div>
        </div>

        </div>
        </div>
        ';  
        }
        }
        ?>

    </div>
</div>

<!-- footer -->
<?php include("section/footer.php"); ?>