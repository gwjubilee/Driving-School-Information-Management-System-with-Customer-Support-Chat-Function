<?php

session_start();

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

$userrow = mysqli_query($database, "SELECT * FROM instructor WHERE instructor_email='$useremail'") or die(mysqli_error($database));
$userfetch = mysqli_fetch_assoc($userrow);
$userid = $userfetch["instructor_id"];
$username = $userfetch["instructor_name"];



date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
    <div class="container text-white">

    <div class="row">
        <div data-aos="fade-up" class="col">
            <a href="enrollment.php" class="text-warning" style="font-size: larger; margin-left: 10px;"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
        </div>
    </div>

    <div class="row text-center" style="margin-top: 50px; margin-bottom: 20px; color: #E0E1E4;">
        <div data-aos="fade-up" class="col">
            <h3>Pending requests for enrollment</h3>
        </div>
    </div>

        <div class="row" style="margin-left: auto;">
        <div data-aos="fade-up" class="col">
            <table class="styled-table">
            <thead>
                <tr>
                <th>Student</th>
                <th>Course Type</th>
                <th>Instructor</th>
                <th>Date</th>
                <th>Time Starts</th>
                <th>Status</th>
                <th></th>
                </tr>
            </thead>
            <?php

            // nag error siya sa SELECT enrollment.enrollment_id,... kay wala daw sa field list
            // angay ni siya sa inig balhin na sa enrollment_request sa enrollment gyud
            // so akong gi replace ni siya sa enrollment_request.enrollment_id...
            // for reference check enrollment.php

            // $sqlmain = "SELECT 
            // enrollment_request.enrollment_request_id,
            // schedule.schedule_id,
            // schedule.title,
            // schedule.course_type,
            // instructor.instructor_name,
            // student.student_name,
            // schedule.schedule_date,
            // schedule.schedule_time,
            // enrollment_request.enrollment_date,
            // enrollment_request.enrollment_status
            // FROM schedule
            // INNER JOIN enrollment_request 
            // ON schedule.schedule_id=enrollment_request.schedule_id 
            // INNER JOIN student 
            // ON student.student_id=enrollment_request.student_id 
            // INNER JOIN instructor 
            // ON schedule.instructor_id=instructor.instructor_id 
            // WHERE enrollment_request.enrollment_status = 'Pending'`
            // AND student.student_id=$userid 
            // ORDER BY enrollment_request.enrollment_date ASC";


            // The columns "enrollment_request.title", "enrollment_request.course_type", "enrollment_request.instructor_id", and "enrollment_request.
            // instructor_name" are being selected from both the schedule and enrollment_request tables, causing potential ambiguity in the result set.
            // To resolve this, the columns from one of the tables should be aliased, or both instances should be referenced with a fully qualified name (e.g. schedule.title vs enrollment_request.title).

            $sqlmain = "SELECT 
            enrollment_request.enrollment_request_id,
            schedule.schedule_id,
            schedule.title,
            schedule.course_type,
            instructor.instructor_name,
            student.student_name,
            schedule.schedule_date,
            schedule.schedule_time,
            enrollment_request.enrollment_date,
            enrollment_request.enrollment_status, 
            schedule.title as schedule_title, 
            schedule.course_type as schedule_course_type, 
            instructor.instructor_id, 
            instructor.instructor_name as instructor_name, 
            enrollment_request.student_transmission 
            FROM schedule
            INNER JOIN enrollment_request 
            ON schedule.schedule_id=enrollment_request.schedule_id 
            AND schedule.title=enrollment_request.title 
            AND schedule.course_type=enrollment_request.course_type 
            AND schedule.instructor_id=enrollment_request.instructor_id 
            AND schedule.instructor_name=enrollment_request.instructor_name 
            INNER JOIN instructor 
            ON instructor.instructor_id=schedule.instructor_id 
            INNER JOIN student 
            ON student.student_id=enrollment_request.student_id 
            WHERE enrollment_request.enrollment_status = 'Pending' 
            ORDER BY enrollment_request.enrollment_date ASC";

            
            $result = mysqli_query($database, $sqlmain) or die(mysqli_error($database));
            if(mysqli_num_rows($result) == 0) {
                echo '
                <div class="row" style="position: absolute; margin-top: 100px; left: 41%;">
                <div data-aos="fade-up" class="col">
                    <img src="../asset/img/undraw_taken.svg" width="25%">
                    <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
                </div>
                </div> 
                ';
            } else {
                while($row = mysqli_fetch_assoc($result)) {
                    
                    $schedule_id=$row["schedule_id"];
                    $student_name=$row["student_name"];
                    $enrollment_request_id=$row["enrollment_request_id"];
                    $title=$row["title"];
                    $course_type=$row["course_type"];
                    $instructor_name=$row["instructor_name"];
                    $schedule_date=$row["schedule_date"];
                    $schedule_time=$row["schedule_time"];
                    $enrollment_status=$row["enrollment_status"];
                    $student_transmission=$row["student_transmission"];
                    
                echo '
                <tbody>
                <tr>
                    <td>'.$student_name.'</td>
                  
                    <td>'.$course_type.'</td>
                    <td>'.$instructor_name.'</td>
                    <td>'.$schedule_date.'</td>
                    <td>'.$schedule_time.'</td>
                    <td>'.$enrollment_status.'</td>
                    <td>
                    <a href="view_enroll_application_request.php?id='.$enrollment_request_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-warning btn-sm" style="margin:7px;">View</a>
                    <a href="approve_enrollment_request.php?id='.$enrollment_request_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-success btn-sm">Approve</a>
                    <a href="delete_enrollment_request.php?id='.$enrollment_request_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-danger btn-sm" style="margin-top: 5px;">Remove</a>
                    </td>
                </tr>
              </tbody>
                ';
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
        if($action=='approve_success') {
            echo '
            <div class="overlay">
                <div class="popup text-center">
                    <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
                    <a class="close" href="enrollment_request.php">&times;</a>
                    <p>Successfully approved!</p>
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