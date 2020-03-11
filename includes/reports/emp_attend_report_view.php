 
  <?php
 if(isset($_POST['report_submit']))
   {
     	$emp = $_POST['report_emp'];
    
    	$r=$db->get_results("SELECT * FROM employee_attendence WHERE insti_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."' AND user_id='$emp'");

     // echo "<pre>";
     // print_r($r);
     // echo "</pre>";
   }
 ?>

 <?php  
   $emp_name=$db->get_results("SELECT * FROM user WHERE inst_id='".$_SESSION['ad_id']."'");
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
                <h3 class="box-title"><label><i class="fa fa-book"></i> Generate Employee Attendance Report Here</label></h3>
                <form method="POST"><br>
                 <div class="row">

                   <div class="form-group col-md-12"> 
                     	<label>Employee Name</label>
                   	<select class="form-control" name="report_emp" required>
                   		<option value="">Select Employee Name</option>
                        <?php
                            if ($emp_name) {
                              foreach ($emp_name as $emp_key) {
                        ?>
                        <option value="<?php echo $emp_key->user_id; ?>"><?php echo $emp_key->user_name; ?></option>
                      <?php } } ?>
                   	</select>
                   </div>
                 
                     
                    <div class="col-md-4">
                     <input type="submit" name="report_submit" value="Get Report" class="btn btn-primary btn-round">
                     </div>
                 </div>
               </form>
             </div>   
           </div>
     </div>


     <?php
   if(isset($_POST['report_submit']))
   {
   ?>
                <div class="col-md-12">
                <div class="box box-primary">
                
                <div class="box-header">
                <h3 class="box-title"><b>Employee Attendance Report</b></h3>
                <div class="box-tools">
                         <a href="emp_attend_report.php?emp_attend_id=<?php echo $_POST['report_emp']; ?>" class="btn btn-warning"><i class="fa fa-print"></i></a>
                </div>
                </div>
                
                
               <div class="box-body">
         
              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
              <thead class="table-border">
              <tr>
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Employee Name</th>
                <th class="text-center">Employee Role</th>
                <th class="text-center">Leave Date</th>
              </tr>
              
              </thead>
              <tbody>
              <?php
                $i=0;
                if($r){ 
                  foreach($r as $rw){
                  $u_name=$db->get_row("SELECT * FROM user WHERE user_id='$rw->user_id'");
                  $u_role=$db->get_row("SELECT * FROM user_type WHERE usr_id='$u_name->user_type_id'");
                  $i++;
               ?>
              <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $u_name->user_name;?></td>
                <td class="text-center"><?php echo $u_role->usr_type; ?></td>
                <td class="text-center"><span style="color: red; font-weight: 700;"><?php echo date('M d, Y', strtotime($rw->att_date));?></span></td>
               
              </tr>
              <?php } } ?>
              </tbody>
            </table>
               
           </div>
         </div>
       </div>
       <?php
   }
       ?>     