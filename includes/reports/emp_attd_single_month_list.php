
<?php
if(isset($_GET['select_attd_month']))
{
  extract($_GET);

  $datearray = explode("-",$select_attd_month);
  $fulldate = date('F-Y',strtotime($select_attd_month));
  if($_SESSION['user_type']=="2"){
    $r=$db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");  
  }else{
    $r=$db->get_results("SELECT * FROM dw_employee_master");
  }


}
?>

<div class="col-md-12">
  <div class="box box-primary">
        
    <div class="box-header">
      <h3 class="box-title"><b>Employee List For Attendance Report of Month <?php echo $fulldate; ?></b></h3>
      <div class="box-tools">
        <a href="?folder=reports&file=emp_report_filter_by_date" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
        <a href="emp_attendance_monthly_report.php?attd=<?php echo $select_attd_month; ?>" class="btn btn-warning btn-round"><i class="fa fa-refresh"></i> Overall Attendance</a>
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example1" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info">
        <thead class="table-border">
        <tr>
          <th class="text-center">Sr. No.</th>
          <th class="text-center">EMP. ID.</th>
          <th class="text-center">EMPLOYEE NAME</th>
          <th class="text-center">Mobile No.</th>          
          <th class="text-center">Total Days Worked</th>          
          <th class="text-center">Action</th>          
        </tr>
        
        </thead>
        <tbody>
        <?php
          $i=0;
          if($r)
          { 
            
            foreach($r as $rw){
              
              $getempattd= $db->get_var("SELECT COUNT(*) FROM dw_emp_attendance WHERE  DEM_EMPLOYEE_ID = '$rw->DEM_EMP_ID' AND DEA_ATTD_YEAR='$datearray[0]' AND DEA_ATTD_MONTH='$datearray[1]'");
              
            
            $i++;
         ?>
            <tr>
              <td class="text-center"><?php echo $i;  ?></td>
              <td class="text-center"><?php echo $rw->DEM_EMP_ID; ?></td>
              <td class="text-center"><?php echo strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME); ?></td>
              <td  class="text-center">
                  <?php echo $rw->DEM_MOBILE_NUMBER; ?>               
              </td>   
              <td class="text-center"><?php echo $getempattd; ?></td>   
              <td>
                <a href="?folder=reports&file=emp_attd_detailed_single_month&DEM_EMP_ID=<?php echo $rw->DEM_EMP_ID; ?>&select_attd_month=<?php echo $select_attd_month; ?>" class="btn btn-info"><i class="fa fa-file"></i> Detailed Report</a>
              </td>      
                   
            </tr>
            <?php 
            } 
          } ?>
        </tbody>        
      </table>       
    </div>
  </div>
</div>


