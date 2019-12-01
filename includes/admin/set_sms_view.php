<style>
	
	.btn-size{
		margin-top: 5px;
	}
</style>

<?php 
	$r=$db->get_results("SELECT * FROM send_sms_setting "); 
	$check1 = $db->get_var("SELECT count(*) FROM send_sms_setting WHERE insti_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'");
?>
	<section class="content">
		 <div class="col-md-12">
		 <div class="box box-default">
		 
		 <div class="box-header">
		 <h3 class="box-title"><b> Send SMS Setting Details</b></h3>
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
		 	<?php if($check1){ ?>
				<!-- <span><b>You Have Seat SMS</b></span> -->
			<?php } else { ?>
				<a href="?folder=admin&file=set_sms_send_add" class="pull-right btn btn-primary btn-w-xs btn-round" style="margin-left: 30px;"><i class="fa fa-plus"></i> <b>Set Send SMS</b></a>
			<?php } ?>
		 </div>
		 </div>
							 		 
			<div class="box-body table-responsive">
					<?php
						
						if($r){	
					?>
						
					<table id="example" class='table table-bordered'>
							<thead class="title-color">
							<tr>
							<th class="text-center" style="width:5%;">Sr. No</th>
							<th class="text-center">EMP Registration</th>
							<th class="text-center">EMP Attendance</th>
							<th class="text-center">Stud Registration</th>
							<th class="text-center">Stud Admission</th>
							<th class="text-center">Stud Attendance</th>
							<th class="text-center">Payment</th>
							<th class="text-center">EMP Salewry</th>
							<th class="text-center">Exam Test</th>
							<th class="text-center">Home Work</th>
							<th style="width:5%;" class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							foreach($r as $rw)
							{ $i++;?>
							<tr>
						<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center"><?php echo $rw->emp_regi_sms; ?></td>
							<td class="text-center"><?php echo $rw->emp_atten_sms; ?></td>
							<td class="text-center"><?php echo $rw->stud_regi_sms; ?></td>
							<td class="text-center"><?php echo $rw->stud_admi_sms; ?></td>
							<td class="text-center"><?php echo $rw->stud_atten_sms; ?></td>
							<td class="text-center"><?php echo $rw->payment_sms; ?></td>
							<td class="text-center"><?php echo $rw->emp_salery_gen_sms; ?></td>
							<td class="text-center"><?php echo $rw->test_mark_snd_sms; ?></td>
							<td class="text-center"><?php echo $rw->homework_sms; ?></td>
							<td class="text-center">
							
								<a href="?folder=admin&file=set_sms_send_add&edit_id=<?php echo $rw->snd_sms_id; ?>"><i class="fa fa-pencil btn btn-warning btn-size"></i></a> 

								<!-- <a onclick="return confirm('Are you sure to delete this Record...?')" href="?folder=admin&file=sms_setting_view&del_id=<?php echo $rw->sms_id; ?>" class="btn btn-danger btn-size"><i class="fa fa-trash"></i></a>  -->
							</td>
						</tr>
							
							<?php }  }
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