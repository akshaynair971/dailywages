 
  <?php
 if(isset($_POST['report_submit']))
   {
      $class = $_POST['report_class_name'];
      $boad = $_POST['report_board_name'];
      $secion = $_POST['report_class_section'];
      $acd_yr = $_POST['report_acd_year'];

      $r=$db->get_results("SELECT * FROM student_admission WHERE admi_board='$boad' AND admi_class='$class' AND admi_section='$secion' AND admi_acad_yr='$acd_yr' AND insti_id='".$_SESSION['ad_id']."'");
   }
 ?>



  <?php
 // if(isset($_POST['stud_det_submit']))
 //   {
 //      // $class_att_id = $_POST['stud_name_att'];

       // $alldata = $db->get_results("SELECT * FROM student_admission WHERE admi_id='$class_att_id' order by 1 desc");

      // $emp_det=$db->get_results("SELECT * FROM student_admission WHERE admi_id='$class_att_id'");

      // $get_fees=$db->get_results("SELECT * FROM payment_details WHERE user_id='".$_SESSION['ad_id']."' AND insti_id='".$_SESSION['inst_id']."' AND user_type='".$_SESSION['user_type']."' AND admi_id='$class_att_id'");
   // }
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
   // if(isset($_POST['report_submit'])) { 
?>

        <!-- <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="box box-primary">
                   <div class="box-header">
                   <h3 class="box-title"><label><i class="fa fa-book"></i> Generate Student Attendance Report </label></h3>
                   <form method="POST"><br>
                    <div class="row">

                      <div class="form-group col-md-6"> 
                          <label>Student Name</label>
                        <select class="form-control" name="stud_name_att" required>
                          <option value="">Select Student Name</option>
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
        </div> -->
                
<?php 
// } 
?>   



<?php
   if(isset($_POST['report_submit'])) { 
?>

<div class="col-md-12">
                <div class="box box-primary">
                
                <div class="box-header">
                <h3 class="box-title"><b>Student Payment Report</b></h3>
                <div class="box-tools">
                         <a href="student_payment_report.php?cls_id=<?php echo $class; ?>&acd_yr_id=<?php echo $acd_yr; ?>&brd_id=<?php echo $boad; ?>" class="btn btn-warning"><b><i class="fa fa-print"></i> Print</b></a>
                </div>
                </div>
                
                
               <div class="box-body">
         
              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead class="table-border">
                  <tr>
                    <th class="text-center">Sr. No.</th>
                    <th class="text-center">Admission Id</th>
                    <th class="text-center">Name & Mob No</th>
                    <th class="text-center">Class Detail</th>
                    <th class="text-center">Admission Type</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Paid</th>
                    <th class="text-center">Remaning</th>
                    <th class="text-center">Action</th>
                  </tr>
                  
                  </thead>
                  <tbody>
                   <?php

                   if($r){
                    $total_amt = 0;
                    $paid_amt = 0;
                    $balance = 0;
                    $pay = 0;

                    foreach ($r as $data) {
                      $get_reg_det=$db->get_row("SELECT * FROM student_registration WHERE sr_id='$data->regi_id'");
                      $get_admission=$db->get_row("SELECT * FROM admission_type WHERE admis_id='$data->admi_type'");
                      $pay++;
                   ?>
            <tr>   
              <td> <?php echo $pay; ?></td>                   
              <td class="text-center">
                  <?php echo $data->admi_no; ?>
              </td> 

              <td>
                  <b style="color:red;">Name : </b><?php echo $get_reg_det->stud_name; ?><br>
                  <b style="color:red;">Mobile No : </b><?php echo $get_reg_det->stud_phone; ?>
              </td>
              <?php $get_clss_name=$db->get_row("SELECT * FROM course WHERE class_id='$data->admi_class'"); ?>

              <?php $get_board = $db->get_row("SELECT * FROM board WHERE board_id='$data->admi_board'"); ?>

              <?php $get_sec = $db->get_row("SELECT * FROM section WHERE sec_id='$data->admi_section'"); ?>

              <td>
                  <b style="color:red;">Class : </b> <?php echo $get_clss_name->class_name; ?><br>
                  <b style="color:red;">Board : </b> <?php echo $get_board->board_name; ?><br>
                  <b style="color:red;">Section : </b> <?php echo $get_sec->sec_name; ?>
              </td>
              <td class="text-center">
                <?php echo $get_admission->admission_type_name; ?>
              </td>

              <td class="text-center">
                 <i class="fa fa-inr"></i> <?php echo $data->ad_year_tot_fee; $total_amount+= $data->ad_year_tot_fee; ?>/-
              </td>

              <?php
                  $result = $db->get_row("SELECT SUM(paid_amount) AS sum FROM payment_details WHERE sr_id='$data->regi_id' AND admi_id='$data->admi_id'"); 
              ?>

              <td class="text-center">
                  <i class="fa fa-inr"></i> <?php if(isset($result->sum) && $result->sum!=0){ echo $result->sum; $paid_amt+=$result->sum; } else { echo '0'; }  ?>/-
              </td>

              <td class="text-center">
                  <i class="fa fa-inr"></i> <?php echo ($data->ad_year_tot_fee)-($result->sum);  $balance+=($data->ad_year_tot_fee)-($result->sum); ?>/-
              </td>

              <td class="text-center">
                <a href="?folder=reports&file=stud_pay_details&admis_id=<?php echo $data->admi_id; ?>" class="btn btn-warning"><i class="fa fa-print"></i></a>
              </td>

            </tr>
            <?php } } else { ?>                      
          
            <tr>                      
              <td colspan='7' class="pull-center" style="text-align: center;">
                <b>No Orders Record Available</b>
              </td>
            </tr>                      
          <?php } ?>

          </tbody>
              </table>
               
           </div>
         </div>
       </div>

<?php } ?>     