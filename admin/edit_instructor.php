<?php

//import database
require_once "../include/connection.php";

if($_POST){
$result= $database->query("SELECT * FROM webuser");
$name=$_POST['name'];
$email=$_POST['email'];
$tele=$_POST['Tele'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
$id=$_POST['id00'];

if ($password==$cpassword) {
    $error='3';
    $result= $database->query("SELECT instructor.instructor_id FROM instructor INNER JOIN webuser ON instructor.instructor_email=webuser.email WHERE webuser.email='$email';");
    if($result->num_rows==1) {
        $id2=$result->fetch_assoc()["instructor_id"];
    } else {
        $id2=$id;
    }
    
    echo $id2."";
    if($id2!=$id) { 
        $error='1';
    } else {
        $sql1="UPDATE instructor SET instructor_email='$email',instructor_name='$name',instructor_password='$password',instructor_phone='$tele' WHERE instructor_id=$id;";
        $database->query($sql1);
        
        $sql1="UPDATE webuser SET email='$email' WHERE email='$oldemail' ;";
        $database->query($sql1);
        $error= '4';
        
    }
    
} else {
    $error='2';
}

} else {
$error='3';
}


header("location: instructor.php?action=edit&error=".$error."&id=".$id);
?>