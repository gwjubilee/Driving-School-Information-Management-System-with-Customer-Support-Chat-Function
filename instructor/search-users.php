<?php

    // session start
    session_start();

    //import database
    require_once "../include/connection.php";

    // declaring variables
    $search = "";

    // get form data
    if(isset($_POST['search'])) {

        $search = $_POST['search'];

    }

    if($search != "") { // if the field is not empty!

        // search for user
        $searchUser = "SELECT * FROM student WHERE student_name = '$search' OR student_email = '$search'";
        $searchUserStatus = mysqli_query($database,$searchUser) or die(mysqli_error($database));
        
        if(mysqli_num_rows($searchUserStatus) > 0) { // if there is an user

            header('Location: search-results.php?message=Search results:');

        } else {

            header('Location: search-results.php?message=No user found.');

        }
        

    } else { // if the fields is empty!

        header('Location: chats.php?message=Please input student name or email.');

    }

    $_SESSION['search'] = $search;
?>