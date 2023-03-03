<?php

    // session start
    session_start();

    //import database
    require_once "../../include/connection.php";

    // declaring variables
    $sent_by = "";
    $received_by = "";
    $message = "";
    $createdAt = date("Y-m-d h:i:sa");

    // get data from form
    if(isset($_POST['sent_by'])) {

        $sent_by = $_POST['sent_by'];

    }

    if(isset($_POST['received_by'])) {

        $received_by = $_POST['received_by'];

    }

    if(isset($_POST['message'])) {

        $message = $_POST['message'];

    }

    if($message != "") { // if message box is not empty!

        // send message
        $sendMessage = "INSERT INTO messages(sent_by,received_by,message,createdAt) VALUES('$sent_by','$received_by','$message','$createdAt')";
        $sendMessageStatus = mysqli_query($database,$sendMessage) or die(mysqli_error($database));
        
        if($sendMessageStatus) {

            header("Location: message.php?receiver=$received_by");

        } else {

            header("Location: message.php?receiver=$received_by");

        }
    }
?>