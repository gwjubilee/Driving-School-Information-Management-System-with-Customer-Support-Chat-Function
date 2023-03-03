<?php
session_start();

if(isset($_SESSION["user"])) {
  if(($_SESSION["user"])=="" or $_SESSION['usertype']!='instructor') {
    header("location: ../signin.php");
  } else {
    $useremail=$_SESSION["user"];
  }

} else {
  header("location: ../signin.php");
}

//import database
require_once "../include/connection.php";

$userrow = $database->query("SELECT * FROM instructor WHERE instructor_email='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["instructor_id"];
$username=$userfetch["instructor_name"];
  
?>

<!-- header -->
<?php include "section/header.php" ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script>
	$(document).ready( function () {
	  var table = $('#myTable').DataTable({
	        initComplete: function () {
	        this.api().columns().every(function () {
         	var column = this;
         	if (column.index() !== 4) { 
           	$(column.header()).append("<br>")
           	var select = $('<select style="color:black;"><option value="">Select</option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                	var val = $.fn.dataTable.util.escapeRegex(
                    	$(this).val());
                 		column
                    		.search(val ? '^' + val + '$' : '', true, false)
                    		.draw();
             			});
	           		column.data().unique().sort().each(function (d, j) {
	             	select.append( '<option value="'+d+'">'+d+'</option>' );
	                });
	            }
	        });
	    }
	});  
});
</script>

<!-- side navigation bar -->
<?php include "section/sidebar.php" ?>

<div class="main">
  <div class="container text-white">


	<div data-aos="fade-up" class="row" style="margin-top: 30px; margin-bottom: 50px;">

		<div class="col-9 flex" style="margin-left: 70px;">
			<h3 data-aos="fade-up" data-aos-duration="1000" class="text-warning" style="margin-bottom: 20px;">Evaluations for students</h3>

			<p style="margin-top: 20px;">Provide the result of the student's performance.</p>
			<p><i>Note: Please make the correct marking for the student who took the test.</i></p>		
		</div>

		<div class="col-2">
			<img src="../asset/img/undraw_accept_request_04.svg" width="170" style="margin-top: 10px;">
		</div>

	</div>

	<div class="row text-center" >
		<div class="col">	
				
		<?php
			if(isset($_SESSION['error'])){
				echo
				'<h4 class="text-danger">'.$_SESSION['error'].'</h4>';
				unset($_SESSION['error']);
			}
			if(isset($_SESSION['success'])){
				echo
				'<h4 class="text-success">'.$_SESSION['success'].'</h4>';
				unset($_SESSION['success']);
				// header("Refresh: 1; evaluations.php");
			}
		?>
		</div>
	</div>


	<!-- add schedule button -->
	<div data-aos="fade-up" data-aos-duration="1100" class="row text-center" style="margin-top: 50px;">
    	<div class="col">
			<a href="add_evaluation.php" class="btn btn-warning btn-sm">Evaluate enrolled students</a>
		</div>
  	</div>

	<div class="row" style="margin-left: auto; margin-top: 30px; margin-bottom: 300px;">
        <div data-aos="fade-up" class="col">
			<h3 class="text-center" style="margin-top: 30px; margin-bottom: 20px;">Done Evaluating</h3>
			<table class="styled-table">
            <thead>
                <tr>
                <th>Student ID</th>
                <th>Student Name</th>
        
                <th>Course Type</th>
                <th>Remark</th>
                <th>Date Evaluated</th>
                <th>Evaluated By</th>
                </tr>
            </thead>
            
			<tbody>

				<?php

					// BASING FROM THE BREAK POINT PLESE INNER JOIN THE ENROLLMENT.TITLE TO EVALUATIONS.TITLE
					// select the evaluations of the current logged in student based on the student_id

					$sqlmain = "SELECT * FROM evaluations WHERE instructor_id = '$userid'"; // this was the original sql statement
					// demo sql statement
					// $sqlmain = "SELECT * FROM evaluations INNER JOIN schedule ON evaluations.title = schedule.title AND evaluations.course_type = schedule.course_type WHERE instructor_id = '$userid'";

					$result= $database->query($sqlmain);
                    if($result->num_rows==0) {
						echo '
						<div class="row" style="position: absolute; margin-top: 100px; left: 41%;">
						<div data-aos="fade-up" class="col">
							<img src="../asset/img/undraw_taken.svg" width="25%">
							<p style="margin-top:10px 0 20px 0; color:#E0E1E4;">There\'s nothing here.</p>
						</div>
						</div>';

					} else {

					for ($x=0; $x<$result->num_rows;$x++) {
						$row=$result->fetch_assoc();

						$student_id = $row["student_id"];
						$student_name = $row["student_name"];
						$title = $row["title"];
						$course_type = $row["course_type"];
						$remark = $row["remark"];
						$evaluation_date = $row["evaluation_date"];
						$instructor_name = $row["instructor_name"];
						echo '
						<tr>
							<td>'.$student_id.'</td>
							<td>'.$student_name.'</td>
					
							<td>'.$course_type.'</td>
							<td class="text-info">'.$remark.'</td>
							<td>'.$evaluation_date.'</td>
							<td>'.$instructor_name.'</td>
						</tr>
						';
					}
				}
				?>
					</tbody>
				</table>
				
			</div>
		</div>

	</div>
</div>

<?php
  if($_GET) {
	$action=$_GET["action"];
	if($action=='success') {
		echo'
		<div class="overlay">
		<div class="popup text-center text-white">
		  <img src="../asset/img/undraw_welcome.svg" width="50%" style="margin-bottom: 10px;">
		  <a class="close" href="evaluations.php">&times;</a>
		  <p>Successfully added!</p>
		  <p>Your evaluation has been posted.</p>
		  <a href="evaluations.php" class="btn btn-warning btn-sm">Okay</a>
		  </div>
		</div>
	  </div>
		
		';

	}
}

?>

<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="datatable/jquery.dataTables.min.js"></script>
<script src="datatable/dataTable.bootstrap.min.js"></script>
<!-- generate datatable on our table -->
<script>
$(document).ready(function(){
	//inialize datatable
    $('#myTable').DataTable();
});
</script>
</body>
    <script>
       $.fn.dataTable.ext.errMode = 'none';
    $('#table').on( 'error.dt', function ( e, settings, techNote, message ) {
    console.log( 'An error has been reported by DataTables: ', message );
    } ) ;
    $(function(){
    table = $('#myTable').DataTable( {
        paging: false
    } );
    table.destroy();    
    table = $('#myTable').DataTable( {
        ordering: false  
    });
    });
    </script>
<div class="report">
    <div class="mb-3">
      <a onclick="window.print()" class="btn btn-outline-success">
        <i class="bi bi-download"></i> Download
      </a>
      
    </div>
  </div>
<!-- footer -->
<?php include "section/footer.php" ?>