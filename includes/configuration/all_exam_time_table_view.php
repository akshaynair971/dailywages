 <?php  

    $r=$db->get_results("SELECT * FROM exam_time_tabledb WHERE insti_id='".$_SESSION['ad_id']."'");
?>

<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12"> 
         
          <div class="box">
            <div class="box-header">
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
             <a href='index.php?folder=configuration&file=add_exam_time_table' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New </b></a>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body table-responsive">   

              	<table id="example1" class="table table-bordered table-striped">
	                <thead>
		                <tr>
		                  <th class="text-center" style="width: 5%;">Sr.No</th>
		                  <th class="text-center" style="width: 10%;">Exam Date</th>
		                  <th class="text-center" style="width: 10%;">Class & Section</th>
		                  <th class="text-center" style="width: 20%;">Board & Academic Year</th>
		                  <th class="text-center" style="width: 10%;">Subject</th>
		                  <th class="text-center" style="width: 10%;">Exam Time</th>
		                  <th class="text-center" style="width: 10%;">Action</th>
		                </tr>
	                </thead> 
                	<tbody>
                		<?php if($r){
                			$exm = 0;
                			foreach($r as $data){
                				$exm++;

                			$get_standard = $db->get_row("SELECT * FROM course WHERE class_id='".$data->class_id."'");	
                			$get_section = $db->get_row("SELECT * FROM section WHERE sec_id='".$data->sec_id."'");	
                			$get_board = $db->get_row("SELECT * FROM board WHERE board_id='".$data->board_id."'");	
                			$get_acd_yr = $db->get_row("SELECT * FROM academic_year WHERE ay_id='".$data->ay_id."'");	
                			$get_subject = $db->get_row("SELECT * FROM subject WHERE sub_id='".$data->sub_id."'");	
                		?>
                		<tr>
                		   <td><?php echo $exm; ?></td>
                		   <td><?php echo date('M d, Y',strtotime($data->exam_date)); ?></td>
                		   <td>
                		   		<b style="color: red;">Class : </b> <?php echo $get_standard->class_name; ?><br>
                		   		<b style="color: red;">Section : </b> <?php echo $get_section->sec_name; ?>
                		   </td>
                			<td>
                				<b style="color: red;">Board : </b> <?php echo $get_board->board_name; ?><br>
                				<b style="color: red;">Acd Year : </b> <?php echo $get_acd_yr->start_year; ?> - <?php echo $get_acd_yr->end_year; ?>
                			</td>
                			<td><?php echo $get_subject->subject; ?></td>
                			<td><?php echo $data->exam_start_time; ?> To <?php echo $data->exam_end_time; ?></td>
                			<td>
                				<a href="?folder=configuration&file=exam_timetable_edit&ed_sub=<?php echo $data->exam_id; ?>" class="btn-size"><i class="fa fa-pencil btn btn-success"></i></a>

                				<?php if ($data->status==0) { ?>

                				  <a onclick="return confirm('Are You Sure Deactivate..?')" href="?folder=configuration&file=all_exam_time_table_view&deact_id=<?php echo $data->exam_id; ?>" title="Deactivate" style="margin-top: 5px;"><i class="fa fa-user btn btn-danger btn-size"> <b>D</b></i> </a>

                				<?php } else {  ?>

                				  <a onclick="return confirm('Are You Sure Activate..?')" href="?folder=configuration&file=all_exam_time_table_view&act_id=<?php echo $data->exam_id; ?>" style="margin-top: 5px;"><i class="fa fa-user btn btn-success btn-size"> <b>A</b></i></a>

                				<?php } ?>
                			</td>
                		</tr>
                		<?php } } ?>
                 	</tbody>
             	</table>                   
	        </div>
	        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
  