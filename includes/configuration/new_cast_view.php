
<?php $r=$db->get_results("SELECT * FROM cast_details WHERE insti_id='".$_SESSION['ad_id']."'");

if(isset($_GET['edit_id']) && $_GET['edit_id']!=''){
    $edit_id= $_GET['edit_id'];
    $bkedit=$db->get_row("SELECT * FROM cast_details WHERE cst_id='$edit_id'");
}

?>
<style>
	.form-control
	{
		border-radius: 8px !important;
	}
</style>

							<section class="content">
							 <div class="col-md-6">
							 <div class="box box-primary">
							 
							 <div class="box-header">
							 <h3 class="box-title"><b>Add New Category</b></h3><br>
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
							    
							       <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Category Already Exist</b> </h5>

							 <?php header("Refresh:2.5; url=index.php?folder=configuration&file=new_cast_view"); } ?>
							  <div class="box-tools">
							 
							 </div>
							 </div>
							 
							 
							<div class="box-body">
						
							<form method="POST">
							<div class="form-group">
							    <label>Category Name <span style="color:red;">*</span></label>
							    <input  class="form-control" placeholder="Enter New Category Name" type="text" name="cast_name" value="<?php if(isset($bkedit)){ echo $bkedit->cast_name;} ?>" required>
							</div>
							<div class="form-group">
							    <input type="submit" name="cast_det_submit" value="Submit" class="btn btn-primary">
							</div>	
						</form>	
					</div>
				</div>
			</div> 


					<div class="col-md-6">
							 <div class="box box-primary">
							 
							 <div class="box-header">
							 <h3 class="box-title"><b>All Category Details</b></h3>
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
							    <th class="text-center" style="width:20%;">Category Name</th>
							    <th class="text-center" style="width:10%;">Action</th>
							</tr>
							</thead>
							<tbody>

							<?php
							$i=0;
							foreach($r as $rw)
							{ $i++;?>
							<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center"> <?php echo $rw->cast_name;?></td>
							<td class="text-center">
								
								<a title="edit" href="?folder=configuration&file=new_cast_view&edit_id=<?php echo $rw->cst_id;?>"><i class="fa fa-pencil btn btn-warning"></i></a>

							 	<a onclick="return confirm('Do You Want Delete...?')" href="?folder=configuration&file=new_cast_view&cst_del_id=<?php echo $rw->cst_id;?>"><i class="fa fa-trash btn btn-danger"></i></i></a> 

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