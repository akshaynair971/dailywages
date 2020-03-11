 
  <?php
 if(isset($_POST['report_submit']))
   {
     	$class = $_POST['report_class_name'];
    	$board = $_POST['report_board_name'];
    	$secion = $_POST['report_class_section'];
    	$acd_yr = $_POST['report_acd_year'];

    	$r=$db->get_results("SELECT * FROM student_admission WHERE admi_board='$board' AND admi_class='$class' AND admi_section='$secion' AND admi_acad_yr='$acd_yr' AND user_id='".$_SESSION['ad_id']."'");
   }
 ?>



  <?php
 if(isset($_POST['stud_det_submit']))
   {
      $class_att_id = $_POST['stud_name_att'];

      $stud_att=$db->get_results("SELECT * FROM student_attendence WHERE stud_id='$class_att_id' AND insti_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'");
   }
 ?>

 <?php  
   $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['ad_id']."'");
   $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['ad_id']."'");
   $section=$db->get_results("SELECT * FROM section WHERE inst_id='".$_SESSION['ad_id']."'");
   $acd_year=$db->get_results("SELECT * FROM academic_year WHERE inst_id='".$_SESSION['ad_id']."'");
 ?>

   <style type="text/css">
     .btn-primary
     {
        margin-top: 10px;
     }
     .table-border{
       background-color: #337ab7;
     }
   </style>
 <br>
     <div class="col-lg-6 col-md-6 col-sm-12">
           <div class="box box-primary">
                <div class="box-header">
                <h3 class="box-title"><label><i class="fa fa-book"></i> Generate Student Details</label></h3>
                <form method="POST"><br>
                 <div class="row">

                   <div class="form-group col-md-6"> 
                     	<label>Class Name</label>
                   	<select class="form-control" name="report_class_name" required>
                   		<option value="">Select Class Name</option>
                        <?php
                            if ($classes) {
                              foreach ($classes as $class_key) {
                        ?>
                        <option value="<?php echo $class_key->class_id; ?>"><?php echo $class_key->class_name; ?></option>
                      <?php } } ?>
                   	</select>
                   </div>

                   <div class="form-group col-md-6"> 
                     	<label>Board Name</label>
                   	<select class="form-control" name="report_board_name" required>
                   		<option value="">Select Board Name</option>
	                    <?php
	                          if ($board){
	                            foreach ($board as $board_key){           
	                    ?>
                      <option value="<?php echo $board_key->board_id; ?>"><?php echo $board_key->board_name; ?></option>
                      <?php } } ?>
                   	</select>
                   </div>

                   	<div class="form-group col-md-6"> 
                    	<label>Section</label>
	                   	<select class="form-control" name="report_class_section" required>
	                        <option value="">Select Class Section</option>
	                        <?php
	                            if ($section) {
	                              foreach ($section as $section_key) {
	                        ?>
	                        <option value="<?php echo $section_key->sec_id; ?>"><?php echo $section_key->sec_name; ?></option>
	                        <?php }} ?>
	                      </select>
                   	</div>

                   <div class="form-group col-md-6"> 
                     	<label>Academic Year</label>
	                   	<select class="form-control" name="report_acd_year" required>
	                        <option value="">Select Academic Year</option>
	                        <?php
	                            if ($acd_year) {
	                              foreach ($acd_year as $acd_yr_key) {       
	                        ?>
	                        <option value="<?php echo $acd_yr_key->ay_id; ?>"><?php echo $acd_yr_key->start_year; ?> - <?php echo $acd_yr_key->end_year; ?></option>
	                        <?php } } ?>
	                      </select>
                   </div>
                     
                    <div class="col-md-4">
                     <input type="submit" name="report_submit" value="Submit" class="btn btn-primary btn-round">
                     </div>
                 </div>
               </form>
             </div>   
           </div>
     </div>


<?php
   if(isset($_POST['report_submit'])) { 
?>

        <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="box box-primary">
                   <div class="box-header">
                   <h3 class="box-title"><label><i class="fa fa-book"></i> Generate Student Attendance Report </label></h3>
                   <form method="POST"><br>
                    <div class="row">

                      <div class="form-group col-md-6"> 
                          <label>Student Name</label>
                        <select class="form-control" name="stud_name_att" required>
                          <option value="">Select Class Name</option>
                           <?php
                               if ($r){
                                 foreach($r as $stud_name){
                                  $get_stud_name = $db->get_row("SELECT * FROM student_registration WHERE sr_id='$stud_name->regi_id'");
                           ?>
                           <option value="<?php echo $stud_name->admi_id; ?>"><?php echo $get_stud_name->stud_name; ?></option>
                         <?php } } ?>
                        </select>
                      </div>

                       <div class="col-md-12">
                        <input type="submit" name="stud_det_submit" value="Generate Report" class="btn btn-primary btn-round">
                        </div>
                    </div>
                  </form>
                </div>   
              </div>
        </div>
                
<?php } ?>   



<?php
   if(isset($_POST['stud_det_submit'])) { 
?>

<div class="col-md-12">
                <div class="box box-primary">
                
                <div class="box-header">
                <h3 class="box-title"><b>Student Attendance Report</b></h3>
                <div class="box-tools">
                         <a href="student_attend_report.php?stud_att_id=<?php echo $_POST['stud_name_att']; ?>" class="btn btn-warning"><i class="fa fa-print"></i></a>
                </div>
                </div>
                
                
               <div class="box-body">
         
              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
              <thead class="table-border">
              <tr>
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Student Name</th>
                <th class="text-center">Class Name</th>
                <th class="text-center">Board Name</th>
                <th class="text-center">Section</th>
                <th class="text-center">Academic Year</th>
                <th class="text-center">Leave Date & Rerason </th>
              </tr>
              
              </thead>
              <tbody>
              <?php
                $i=0;
                if($stud_att){ 
                  foreach($stud_att as $rw){

                  $get_admi_det = $db->get_row("SELECT * FROM student_admission WHERE admi_id='$rw->stud_id'");

                  $course=$db->get_row("SELECT * FROM course WHERE class_id='$get_admi_det->admi_class'");
                  $board=$db->get_row("SELECT * FROM board WHERE board_id='$get_admi_det->admi_board'");
                  $sec=$db->get_row("SELECT * FROM section WHERE sec_id='$get_admi_det->admi_board'");
                  $stud=$db->get_row("SELECT * FROM student_registration WHERE sr_id='$get_admi_det->regi_id'");
                  $acd_yr=$db->get_row("SELECT * FROM academic_year WHERE ay_id='$get_admi_det->admi_acad_yr'");
                  $i++;
               ?>
              <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $stud->stud_name;?></td>
                <td class="text-center"><?php echo $course->class_name; ?></td>
                <td class="text-center"><?php echo $board->board_name; ?></td>
                <td class="text-center"><?php echo $sec->sec_name; ?></td>
                 <td class="text-center"><?php echo $acd_yr->start_year; ?> - <?php echo $acd_yr->end_year; ?></td>
                <td class="text-center">
                  <b style="color: red;">Date : </b><?php echo date('M d, Y', strtotime($rw->stud_att_date));?><br>
                  <b style="color: red;">Reason : </b><?php echo $rw->leave_reason;?>
                  </td>
              </tr>
              <?php } } ?>
              </tbody>
            </table>
           </div>
         </div>
       </div>

<?php } ?>     