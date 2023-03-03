<?php

//import database
require_once "../include/connection.php";


if($_POST) {
    $result= $database->query("SELECT * FROM webuser");
    $name=$_POST['name'];
    $oldemail=$_POST["oldemail"];
    $email=$_POST['email'];
    $tele=$_POST['Tele'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $id=$_POST['id00'];
    
    if ($password==$cpassword) {
        $error='3';
        $aab="SELECT instructor.instructor_id FROM instructor INNER JOIN webuser on instructor.instructor_email=webuser.email where webuser.email='$email';";
        $result= $database->query($aab);
        if($result->num_rows==1) {
            $id2=$result->fetch_assoc()["instructor_id"];
        }else {
            $id2=$id;
        }
        
        if($id2!=$id) {
            $error='1';
                
        } else {

            $sql1="UPDATE instructor SET instructor_email='$email',instructor_name='$name',instructor_password='$password',instructor_phone='$tele' WHERE instructor_id=$id ;";
            $database->query($sql1);
            echo $sql1;
            $sql1="UPDATE webuser set email='$email' where email='$oldemail' ;";
            $database->query($sql1);
            echo $sql1;
            
            $error= '4';
            
        }
        
    }else {
        $error='2';
    }

}else {
    $error='3';
}

header("location: settings.php?action=edit&error=".$error."&id=".$id);
?>