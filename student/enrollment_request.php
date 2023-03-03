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

$userrow = mysqli_query($database, "SELECT * FROM student WHERE student_email='$useremail'") or die(mysqli_error($database));
$userfetch = mysqli_fetch_assoc($userrow);
$userid = $userfetch["student_id"];
$username = $userfetch["student_name"];



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
            <h3>My Enrollment Request</h3>
        </div>
        </div>

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

                // nag error siya sa SELECT enrollment.enrollment_id,... kay wala daw sa field list
                // angay ni siya sa inig balhin na sa enrollment_request sa enrollment gyud
                // so akong gi replace ni siya sa enrollment_request.enrollment_id...
                // for reference check enrollment.php

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
                enrollment_request.enrollment_status
                FROM schedule
                INNER JOIN enrollment_request 
                ON schedule.schedule_id=enrollment_request.schedule_id 
                INNER JOIN student 
                ON student.student_id=enrollment_request.student_id 
                INNER JOIN instructor 
                ON schedule.instructor_id=instructor.instructor_id 
                WHERE enrollment_request.enrollment_status = 'Pending'
                AND student.student_id=$userid 
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
                        $title=$row["title"];
                        $instructor_name=$row["instructor_name"];
                        $schedule_date=$row["schedule_date"];
                        $schedule_time=$row["schedule_time"];
                        $enrollment_date=$row["enrollment_date"];
                        $enrollment_request_id=$row["enrollment_request_id"];
                        $course_type=$row["course_type"];
                        $enrollment_status=$row["enrollment_status"];
                        
                        echo "<tr>";
                       
                        echo "<td>$course_type</td>";
                        echo "<td>$instructor_name</td>";
                        echo "<td>$schedule_date</td>";
                        echo "<td>$schedule_time</td>";
                        echo "<td>$enrollment_status</td>";
                        echo "<td>";
                        echo '<a href="view_enroll_application_request.php?id='.$enrollment_request_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-warning btn-sm" style="margin:7px;">View my application</a>';
                        echo '<a href="delete_enrollment_request.php?id='.$enrollment_request_id.'&title='.$title.'&instructor_name='.$instructor_name.'" class="btn btn-outline-warning btn-sm">Cancel my application</a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>

    </div>
</div>
<!-- footer -->
<?php include("section/footer.php"); ?>