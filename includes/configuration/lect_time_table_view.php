 <?php  

    $r=$db->get_results("SELECT * FROM lect_time_table WHERE insti_id='".$_SESSION['ad_id']."'");
?> 
<style type="text/css">
  .btn-size
  {
    margin-top: 5px;
  }
</style>
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
             <a href='index.php?folder=configuration&file=add_lect_time_table' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New </b></a>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body table-responsive">   

              	<table id="example1" class="table table-bordered table-striped">
	                <thead>
		                <tr>
		                  <th class="text-center" style="width: 5%;">Sr.No</th>
		                  <th class="text-center" style="width: 15%;">Class Details</th>
		                  <th class="text-center" style="width: 20%;">All Details</th>
		                  <th class="text-center" style="width: 5%;">Action</th>
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
                		   <!-- <td><?php echo date('M d, Y',strtotime($data->exam_date)); ?></td> -->
                		   <td>
                		   		<b style="color: red;">Class : </b> <?php echo $get_standard->class_name; ?><br>
                          <b style="color: red;">Board : </b> <?php echo $get_board->board_name; ?><br>
                          <b style="color: red;">Section : </b> <?php echo $get_section->sec_name; ?><br>
                          <b style="color: red;">Acd Year : </b> <?php echo $get_acd_yr->start_year; ?> - <?php echo $get_acd_yr->end_year; ?>
                		   </td>
                			<td>
                				     <table class="table table-bordered">
                          <thead>
                            <th class="text-center">Start & End Time</th>
                            <th class="text-center">Monday</th>
                            <th class="text-center">Tuesday</th>
                            <th class="text-center">Wednesday</th>
                            <th class="text-center">Thursday</th>
                            <th class="text-center">Friday</th>
                            <th class="text-center">Saturday</th>
                          </thead>
                          <tbody>
                          <?php

                          $json = json_decode($data->time_table_details);

                            for($i=0; $i<count($json->start_time); $i++)
                          {
                            
                              $c=$i+1;

                              $subject=$db->get_row("SELECT * FROM subject WHERE sub_id='".$json->mon_subject[$i]."'");

                              $subject1=$db->get_row("SELECT * FROM subject WHERE sub_id='".$json->tue_subject[$i]."'");

                              $subject2=$db->get_row("SELECT * FROM subject WHERE sub_id='".$json->wed_subject[$i]."'");

                              $subject3=$db->get_row("SELECT * FROM subject WHERE sub_id='".$json->thu_subject[$i]."'");

                              $subject4=$db->get_row("SELECT * FROM subject WHERE sub_id='".$json->fri_subject[$i]."'");

                              $subject5=$db->get_row("SELECT * FROM subject WHERE sub_id='".$json->sat_subject[$i]."'");
                          ?>
                          
                          <tr> 
                            <td class="text-center"><?php echo $json->start_time[$i]; ?> - <?php echo $json->end_time[$i]; ?></td>

                            <td class="text-center"><?php echo $subject->subject; ?></td>

                            <td class="text-center"><?php echo $subject1->subject; ?></td>

                            <td class="text-center"><?php echo $subject2->subject; ?></td>

                            <td class="text-center"><?php echo $subject3->subject; ?></td>

                            <td class="text-center"><?php echo $subject4->subject; ?></td>

                            <td class="text-center"><?php echo $subject5->subject; ?></td>
                            
                          </tr>
                        <?php } ?>
                          </tbody>
                        </table>
                			</td>
                			<!-- <td><?php echo $get_subject->subject; ?></td> -->
                			<!-- <td><?php echo $data->exam_start_time; ?> To <?php echo $data->exam_end_time; ?></td> -->
                			<td>
                				<a href="?folder=configuration&file=add_lect_time_table&ed_id=<?php echo $data->lt_id; ?>" class="btn-size"><i class="fa fa-pencil btn btn-primary btn-size"></i></a>

                				<?php if ($data->status==0) { ?>

                				  <a onclick="return confirm('Are You Sure Deactivate..?')" href="?folder=configuration&file=lect_time_table_view&lect_deact_id=<?php echo $data->lt_id; ?>" title="Deactivate" style="margin-top: 5px;"><i class="fa btn btn-warning btn-size"> <b>D</b></i> </a>

                				<?php } else {  ?>

                				  <a onclick="return confirm('Are You Sure Activate..?')" href="?folder=configuration&file=lect_time_table_view&lect_act_id=<?php echo $data->lt_id; ?>" style="margin-top: 5px;"><i class="fa btn btn-success btn-size"> <b>A</b></i></a>

                				<?php } ?>
                        <a class="btn btn-danger btn-size" onclick="return confirm('Are You Sure Delete this Time Table..?')" href="?folder=configuration&file=lect_time_table_view&ltdel_id=<?php echo $data->lt_id; ?>" title="Delete Time Table" style="margin-top: 5px;"><i class="fa fa-trash "></i> </a>
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
  