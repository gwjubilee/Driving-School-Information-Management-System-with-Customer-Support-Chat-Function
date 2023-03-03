<?php
	session_start();
	require "../include/connection.php";

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		
		$stdnumber = $_POST['stdnumber'];
		$student = $_POST['student'];
		$types= $_POST['types'];
		$comment = $_POST['comment'];
		$lc = $_POST['lc'];
		$restrictions = $_POST['restrictions'];
		$remarks = $_POST['remarks'];
		$dt = $_POST['dt'];

		
		$sql = "UPDATE evaluations SET  stdnumber = '$stdnumber', student = '$student', types = '$types', 
		comment = '$comment', lc = '$lc', dt ='$dt', 
		restrictions = '$restrictions', remarks = '$remarks' WHERE id = '$id'";

		//use for MySQLi OOP
		// if($conn->query($sql)){
		// 	$_SESSION['success'] = 'Member updated successfully';
		// }
		///////////////

		//use for MySQLi Procedural
		if(mysqli_query($database, $sql)){
			$_SESSION['success'] = 'Member updated successfully';
			// header("Refresh: 5; evaluations.php");
		}
		///////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in updating member';
		}
	}
	else{
		$_SESSION['error'] = 'Select member to edit first';
	}
	// header("Refresh: 5; evaluations.php");
	header('location:evaluations.php');
	

?>