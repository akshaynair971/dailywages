
<?php

if(isset($_GET['weekly_attd_year']) && isset($_GET['weekly_attd_week']))
{
  extract($_GET);

  
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
      <h3 class="box-title"><b>Employee List For Attendance Report of (Week  <?php echo $weekly_attd_week." - ".$weekly_attd_year; ?>)</b></h3>
      <div class="box-tools">
        <a href="?folder=reports&file=emp_report_filter_by_date" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
        
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example1" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info" style="border: 1px solid black !important;">
        <thead class="table-border">
        <tr>
          <th style="border: 1px solid black !important;" class="text-center">Sr. No.</th>
          <th style="border: 1px solid black !important;" class="text-center">EMP. ID.</th>
          <th style="border: 1px solid black !important;" class="text-center">EMPLOYEE NAME</th>
          <th style="border: 1px solid black !important;" class="text-center">Mobile No.</th>          
          <th style="border: 1px solid black !important;" class="text-center">Total Days Worked</th>          
          <th style="border: 1px solid black !important;" class="text-center">Action</th>          
        </tr>
        
        </thead>
        <tbody>
        <?php
          $i=0;
          if($r)
          { 
            
            foreach($r as $rw){
              $workdays=0;  
              $week_array = getStartAndEndDate($weekly_attd_week,$weekly_attd_year);
            
              $begin = new DateTime($week_array['week_start']);
              $end = new DateTime($week_array['week_end']);

              $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
              foreach($daterange as $date1)
              {
                $convdate = $date1->format("Y-m-d");
                $convday = date("D",strtotime($convdate));
                $getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$rw->DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
                // $db->debug();  
                if($getattd){
                  if($getattd->DEA_CURRENT_LOCATION=="OFFICE" || $getattd->DEA_CURRENT_LOCATION=="CUSTOMER SITE" || $getattd->DEA_CURRENT_LOCATION=="WEEKLY OFF" )
                  {
                    $workdays++;  
                  }
                }
              }
            
            $i++;
         ?>
            <tr>
              <td style="border: 1px solid black !important;" class="text-center"><?php echo $i;  ?></td>
              <td style="border: 1px solid black !important;" class="text-center"><?php echo $rw->DEM_EMP_ID; ?></td>
              <td style="border: 1px solid black !important;" class="text-center"><?php echo strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME); ?></td>
              <td style="border: 1px solid black !important;"  class="text-center">
                  <?php echo $rw->DEM_MOBILE_NUMBER; ?>               
              </td>   
              <td style="border: 1px solid black !important;" class="text-center"><?php echo $workdays; ?></td>   
              <td style="border: 1px solid black !important;">
                <a href="?folder=reports&file=emp_attd_detailed_weekly_report&DEM_EMP_ID=<?php echo $rw->DEM_EMP_ID; ?>&weekly_attd_year=<?php echo $weekly_attd_year; ?>&weekly_attd_week=<?php echo $weekly_attd_week; ?>" class="btn btn-info"><i class="fa fa-file"></i> Detailed Report</a>
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


