
<?php $r=$db->get_results("SELECT * FROM cast_category_details WHERE insti_id='".$_SESSION['ad_id']."'");

if(isset($_GET['sub_cat_edit_id']) && $_GET['sub_cat_edit_id']!=''){
    $sub_cat_edit_id= $_GET['sub_cat_edit_id'];
    $bkedit=$db->get_row("SELECT * FROM cast_category_details WHERE cc_id='$sub_cat_edit_id'");
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
							 <h3 class="box-title"><b>Add New Caste</b></h3><br>
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
							    
							       <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Cast Sub Category Already Exist</b> </h5>

							 <?php header("Refresh:2.5; url=index.php?folder=configuration&file=cast_subcate_view"); } ?>
							  <div class="box-tools">
							 
							 </div>
							 </div>
							 
							 
							<div class="box-body">
						
							<form method="POST">
							<div class="form-group">
							    <label>Category Name <span style="color:red;">*</span></label>
							    <select class="form-control" name="cast_id" id="cast_id" required>
							    	<option value="">Select Category</option>
						    		<?php
						    			$get_lng = $db->get_results("SELECT * FROM cast_details WHERE insti_id='".$_SESSION['ad_id']."'");
						    			if($get_lng){
						    				foreach($get_lng as $cast){
						    		?>
							    	<option value="<?php echo $cast->cst_id; ?>" <?php if($cast->cst_id==$bkedit->cst_id){ echo "selected"; } ?>><?php echo $cast->cast_name; ?></option>
							    	<?php } } ?>
							    </select>
							</div>

							<div class="form-group">
							    <label>Caste Name <span style="color:red;">*</span></label>
							    <input  class="form-control" placeholder="Enter Caste Name" type="text" name="sub_cat_name" value="<?php if(isset($bkedit)){ echo $bkedit->cast_category_name;} ?>" required>
							</div>
							<div class="form-group">
							    
							    <input type="submit" name="sub_category_submit" value="Submit" class="btn btn-primary">
							</div>	
						</form>	
					</div>
				</div>
			</div> 


					<div class="col-md-7">
							 <div class="box box-primary">
							 
							 <div class="box-header">
							 <h3 class="box-title"><b>All Caste Details</b></h3>
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
							    <th class="text-center" style="width:8%;">Sr. No.</th>
							    <th class="text-center" style="width:20%;">Category Name </th>
							    <th class="text-center" style="width:20%;">Caste Name</th>
							    <th class="text-center" style="width:12%;">Action</th>
							</tr>
							</thead>
							<tbody>

							<?php
							$i=0;
							foreach($r as $rw)
							{ $i++;
								$get_lng = $db->get_row("SELECT * FROM cast_details WHERE cst_id='$rw->cst_id'");
							?>
							<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center"> <?php echo $get_lng->cast_name;?></td>
							<td class="text-center"> <?php echo $rw->cast_category_name;?></td>
							<td class="text-center">
								
								<a title="edit" href="?folder=configuration&file=cast_subcate_view&sub_cat_edit_id=<?php echo $rw->cc_id;?>"><i class="btn btn-warning fa fa-pencil btn-size"></i></a>

							 	<a onclick="return confirm('Do You Want Delete...?')" href="?folder=configuration&file=cast_subcate_view&del_sub_cat_id=<?php echo $rw->cc_id;?>"><i class="btn btn-danger fa fa-trash btn-size"></i></i></a> 

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