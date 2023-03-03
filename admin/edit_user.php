<?php

session_start();

if(isset($_SESSION["user"])) {
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='admin') {
        header("location: ../signin.php");
    } else {
    $useremail=$_SESSION["user"];
  }
} else {
    header("location: ../signin.php");
}

//import database
require_once "../include/connection.php";


if($_POST) {
    $result= $database->query("SELECT * FROM webuser");
    $name=$_POST['name'];
    $oldemail=$_POST["oldemail"];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $id=$_POST['id00'];
    
    if ($password==$cpassword) {
        $error='3';
        $aab="SELECT admin.admin_id FROM admin INNER JOIN webuser on admin.admin_email=webuser.email where webuser.email='$email';";
        $result= $database->query($aab);
        if($result->num_rows==1) {
            $id2=$result->fetch_assoc()["admin_id"];
        }else {
            $id2=$id;
        }
        
        if($id2!=$id) {
            $error='1';
                
        } else {

            $sql1="UPDATE admin SET admin_email='$email',admin_name='$name',admin_password='$password' WHERE admin_id=$id ;";
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