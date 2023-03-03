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
        $searchUser = "SELECT * FROM instructor WHERE instructor_name = '$search' OR instructor_email = '$search'";
        $searchUserStatus = mysqli_query($database,$searchUser) or die(mysqli_error($database));
        
        if(mysqli_num_rows($searchUserStatus) > 0) { // if there is an user

            header('Location: search-results.php?message=Search results:');

        } else {

            header('Location: search-results.php?message=No user found.');

        }
        

    } else { // if the fields is empty!

        header('Location: chats.php?message=Please input instructor name or email.');

    }

    $_SESSION['search'] = $search;
?>