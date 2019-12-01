<style>
	.btn-size{
		margin-top: 5px;
	}
</style>


	<section class="content">
							 <div class="col-md-12">
							 <div class="box box-default">
							 
							 <div class="box-header">
							 <h3 class="box-title"><b>SMS Setting Details</b></h3>

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
				             
							 <div class="box-tools">

								<!-- <a href="?folder=admin&file=change_sms_setting" class="pull-right btn btn-primary btn-w-xs btn-round" style="margin-left: 30px;"><i class="fa fa-plus"></i> <b>Change SMS Setting</b></a> -->
							
							 </div>
							 </div>
							 
							 
							<div class="box-body table-responsive">
							<?php


						$r=$db->get_results("SELECT * FROM sms_setting ");
	
							if($r)
						{	
							?>
						
							<table id="example" class='table table-bordered'>
							<thead class="title-color">
							<tr>
							<th class="text-center" style="width:10%;">Sr. No.</th>
							<th class="text-center">Sender Name</th>
							<th class="text-center">UserName</th>
							<th class="text-center">Password</th>
							<th style="width:20%;" class="text-center">Actions</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i=0;
							foreach($r as $rw)
							{ $i++;?>
						<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center"><?php echo $rw->sms_sender_name; ?></td>
							<td class="text-center"><?php echo $rw->sms_username; ?></td>
							<td class="text-center"><?php echo $rw->sms_password; ?></td>
							<td class="text-center">
							
								<a href="?folder=admin&file=change_sms_setting&edit_id=<?php echo $rw->sms_id; ?>" class="btn btn-warning btn-size"><i class="fa fa-pencil"></i></a> 

								<!-- <a onclick="return confirm('Are you sure to delete this Record...?')" href="?folder=admin&file=sms_setting_view&del_id=<?php echo $rw->sms_id; ?>" class="btn btn-danger btn-size"><i class="fa fa-trash"></i></a>  -->
							</td>
						</tr>
							
							<?php } }
							else
							{
								echo"<div class='alert alert-danger'><b>Records Not Available.</b></div>";
							}						
						?>
					</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>