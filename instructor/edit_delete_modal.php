<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:black;">
                
                <center><h4 class="modal-title" id="myModalLabel">Edit Evaluation Student</h4></center>
            </div>
            <div class="modal-body" style="color:black;">
			<div class="container-fluid">




			
			<form method="POST" action="edit.php">
				<input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>">
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Id:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="stdnumber" value="<?php echo $row['stdnumber']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Student:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="student" value="<?php echo $row['student']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Types</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="types" value="<?php echo $row['types']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Comment:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="comment" value="<?php echo $row['comment']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">License Cert. No.:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lc" value="<?php echo $row['lc']; ?>">
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Restrictions:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="restrictions" value="<?php echo $row['restrictions']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Remarks:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="remarks" value="<?php echo $row['remarks']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Date:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="dt" value="<?php echo $row['dt']; ?>">
					</div>
				</div>
				
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-"></span> Cancel</button>
                <button type="submit" name="edit" id="success" class="btn btn-success m-1" class="btn btn-success"><span class="glyphicon glyphicon-"></span> Update</a>
			</form>
            </div>

        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<br><br><br><br><br><br>
    <div class="modal-dialog" style="color:black;">
        <div class="modal-content">
            <div class="modal-header">
               
                <center><h4 class="modal-title" id="myModalLabel">Are you sure to remove this student data?</h4></center>
            </div>
            <div class="modal-body">	
				<h1 class="text-center"><?php echo $row['stdnumber'].' '.$row['student']; ?></h1>


			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-"></span> Cancel</button>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-"></span>Delete</a>
            </div>

        </div>
    </div>
</div>