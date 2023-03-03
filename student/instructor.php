<?php

session_start();

if(isset($_SESSION["user"])){
if(($_SESSION["user"])=="" or $_SESSION['usertype']!='student'){
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

?>

<!-- header -->
<?php include "section/header.php" ?>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
    <div class="container text-white">

        <form action="" method="POST">
            <div class="row">
                <div class="col">

                    <div class="box">
                        <div class="container-1">
                            <span class="icon"><i class="fa fa-search"></i></span>
                            <input type="search" name="search" id="search" placeholder="Instructor name or email" list="instructors" />
                        </div>
                    </div>

                </div>
            </div>

            <?php
            echo '<datalist id="instructors">';
            $list11 = $database->query("SELECT  instructor_name,instructor_email FROM  instructor;");

            for($y=0;$y<$list11->num_rows;$y++) {
            $row00=$list11->fetch_assoc();
            $d=$row00["instructor_name"];
            $c=$row00["instructor_email"];
            echo "<option value='$d'><br />";
            echo "<option value='$c'><br />";
            };

            echo ' </datalist>';
            ?>

            <div class="row text-center" style="margin-top: 20px;">
                <div class="col">
                    <input type="submit" value="Search" class="btn btn-warning btn-sm" style="padding: 7px;">
                </div>
            </div>
        <!-- end form -->
        </form>

        <?php
            if($_POST) {
            $keyword=$_POST["search"];

            $sqlmain= "SELECT * FROM instructor WHERE instructor_email='$keyword' OR instructor_name='$keyword' OR instructor_name LIKE '$keyword%' OR instructor_name LIKE '%$keyword' OR instructor_name LIKE '%$keyword%'";
            } else {
            $sqlmain= "SELECT * FROM instructor ORDER BY instructor_id DESC";

            }
        ?>

        <!-- row 5 -->
        <div class="row" style="margin-top: 70px;">
            <div class="col">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Instructor</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php
                    $result= $database->query($sqlmain);
                    if($result->num_rows==0) {
                    echo '
                    <div class="row" style="position: absolute; margin-top: 100px; left: 48%;">
                        <div class="col">
                            <img src="../asset/img/undraw_taken.svg" width="25%">
                            <p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
                        </div>
                    </div>  
                    ';

                    } else {
                    for ($x=0; $x<$result->num_rows;$x++) {
                    $row=$result->fetch_assoc();
                    $instructor_id=$row["instructor_id"];
                    $name=$row["instructor_name"];
                    $email=$row["instructor_email"];
                    echo '
                    <tbody>
                        <tr>
                            <td>'.substr($name,0,50).'</td>
                            <td>'.substr($email,0,50).'</td>
                            <td>
                            <a href="?action=schedule&id='.$instructor_id.'&name='.$name.'" class="btn btn-warning btn-sm"><svg class="me-1" width="18" height="18"><use xlink:href="#calendar-month"/></svg>View their schedule</a>
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

        <?php 
        if($_GET) {

        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='schedule') {
        $name=$_GET["name"];
        echo '
        <div class="overlay">
            <div class="popup text-center">
                <img src="../asset/img/undraw_faq.svg" width="50%" style="margin-bottom: 10px;">
                <a class="close" href="instructor.php">&times;</a>
                <p>You are about to view schedules from <span class="text-warning">'.substr($name,0,40).'</span><br />This will redirect you to <span class="text-warning">Schedule</span>.</p>
                <form action="schedule.php" method="POST" style="display: flex">

                    <input type="hidden" name="search" value="'.$name.'">

                    <div style="display: flex;justify-content:center;margin:auto;">

                    <input type="submit" value="Yes" class="btn btn-warning btn-sm" style="padding: 6px; width: 60px;">
                </form

                </div>
            </div>
        </div>
        ';
        }

        };
        ?>

    </div>
</div>

<!-- footer -->
<?php include("section/footer.php"); ?>