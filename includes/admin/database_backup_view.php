
<?php $r=$db->get_results("SELECT * FROM job_language_type_details");

if(isset($_GET['edit_lng_type_id']) && $_GET['edit_lng_type_id']!=''){
    $edit_lng_type_id= $_GET['edit_lng_type_id'];
    $bkedit=$db->get_row("SELECT * FROM job_language_type_details WHERE lang_type_id='$edit_lng_type_id'");
}


?>
<style>
	.form-control
	{
		border-radius: 8px !important;
	}
	.btn-size
	{
		margin-top: 5px;
	}
</style>

							<section class="content">
							 <div class="col-md-5">
							 <div class="box box-primary">
							 
							 <div class="box-header">
							 <h3 class="box-title"><b>Backup Your Current Position Database</b></h3><br>
							   <?php  
							   if(isset($msg))
							   {
							     echo"<div style='font-size:18px; color:red; margin-left:15px; font-weight:700;'>".$msg."</div>";
							   }
							   if(isset($succ))
							   {
							     echo"<div style='font-size:18px; color:green; margin-left:15px; font-weight:700;'>".$succ."</div>";
							   }
							 ?>

							 <?php if ($isexist>0) { ?>
							    
							       <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Language Type Already Exist</b> </h5>

							 <?php header("Refresh:2.5; url=index.php?folder=language&file=language_type_view"); } ?>


							 <div class="box-tools">
							 
							 </div>
							 </div>
							 
							 
							<div class="box-body">
							<br>
							<form method="POST">
							<!-- <div class="form-group">
							    <label>Language <span style="color:red;">*</span></label>
							    <select class="form-control" name="lng_name" id="lng_name" required>
							    	<option value="">Select Language</option>
						    		<?php
						    			$get_lng = $db->get_results("SELECT * FROM job_language_details");
						    			if($get_lng){
						    				foreach($get_lng as $lang){
						    		?>
							    	<option value="<?php echo $lang->lang_id; ?>" <?php if($lang->lang_id==$bkedit->lang_id){ echo "selected"; } ?>><?php echo $lang->lang_name; ?></option>
							    	<?php } } ?>
							    </select>
							</div> -->

							<!-- <div class="form-group">
							    <label>Language Type Name <span style="color:red;">*</span></label>
							    <input  class="form-control" placeholder="Enter Language Type Name" type="text" name="lng_type" value="<?php if(isset($bkedit)){ echo $bkedit->lang_type_name;} ?>" required>
							</div>
							<div class="form-group">
							    
							    <input type="submit" name="lang_type_det_submit" value="Submit" class="btn btn-primary">
							</div> -->	

							<a href="?folder=admin&file=database_backup" class="btn btn-success" style="width: 100%;"> <b>Backup Your Database</b></a>

						</form><br>
					</div>
				</div>
			</div> 


					<div class="col-md-7">
							 <div class="box box-warning">
							 
							 <div class="box-header">
							 <h3 class="box-title"><b>All Area Details</b></h3>
							  <div class="box-tools">
							 
							 </div>
							 </div>
							<div class="box-body table-responsive" style="max-height: 500px;">
							
							<?php

							if($r){	
							?>
							<form method="POST">
							
							<table id="example1" class='table table-bordered' style="overflow-y: scroll;">
							<thead>
							<tr>
							    <th class="text-center" style="width:7%;">Sr. No.</th>
							    <th class="text-center" style="width:20%;">Language Name</th>
							    <th class="text-center" style="width:20%;">Language Type</th>
							    <th class="text-center" style="width:15%;">Action</th>
							</tr>
							</thead>
							<tbody>

							<?php
							$i=0;
							foreach($r as $rw)
							{ $i++;
								$get_lng = $db->get_row("SELECT * FROM job_language_details WHERE lang_id='$rw->lang_id'");
							?>
							<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center"> <?php echo $get_lng->lang_name;?></td>
							<td class="text-center"> <?php echo $rw->lang_type_name;?></td>
							<td class="text-center">
								
								<a title="edit" href="?folder=language&file=language_type_view&edit_lng_type_id=<?php echo $rw->lang_type_id;?>"><i class="btn btn-warning fa fa-pencil btn-size"></i></a>

							 	<a onclick="return confirm('Do You Want Delete...?')" href="?folder=language&file=language_type_view&del_lng_type_id=<?php echo $rw->lang_type_id;?>"><i class="btn btn-danger fa fa-trash btn-size"></i></i></a> 

							<?php } }
							else
							{
								echo"<div class='alert alert-danger'><b>Records Not Available</b></div>";
							}						
							?>
						</tbody>
					</table>
				</form>	
			</div>
		</div>
	</div>
</section>