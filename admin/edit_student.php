<?php

//import database
require_once "../include/connection.php";

if($_POST){
$result= $database->query("SELECT * FROM webuser");
$name=$_POST['name'];
$email=$_POST['email'];
$tele=$_POST['Tele'];
$address=$_POST['address'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
$id=$_POST['id00'];

if ($password==$cpassword) {
    $error='3';
    $result= $database->query("SELECT student.student_id FROM student INNER JOIN webuser ON student.student_email=webuser.email WHERE webuser.email='$email';");
    if($result->num_rows==1) {
        $id2=$result->fetch_assoc()["student_id"];
    } else {
        $id2=$id;
    }
    
    echo $id2."";
    if($id2!=$id) { 
        $error='1';
    } else {
        $sql1="UPDATE student SET student_email='$email',student_name='$name',student_password='$password',student_phone='$tele',student_address='$address' WHERE student_id=$id;";
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


header("location: student.php?action=edit&error=".$error."&id=".$id);
?>