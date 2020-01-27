
<?php



if(isset($_GET['weekly_attd_year']) && isset($_GET['weekly_attd_week']))
{
  extract($_GET);  
    
  $r=$db->get_row("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$DEM_EMP_ID."'");   

}
?>

<div class="col-md-12">
  <div class="box box-primary">
        
    <div class="box-header">
      <h3 class="box-title"><b>Attendance Report of <span style="color:green;"><?php echo strtoupper($r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME); ?></span>  (Week  <?php echo $weekly_attd_week." - ".$weekly_attd_year; ?>)</b></h3>
      <div class="box-tools">
        <a href="index.php?folder=reports&file=emp_attd_detailed_weekly_report&exppdf_weeklyattd=1&DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>&weekly_attd_year=<?php echo $weekly_attd_year; ?>&weekly_attd_week=<?php echo $weekly_attd_week; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>        
        <a href="index.php?folder=reports&file=emp_attd_detailed_weekly_report&expxl_weeklyattd=1&DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>&weekly_attd_year=<?php echo $weekly_attd_year; ?>&weekly_attd_week=<?php echo $weekly_attd_week; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>        
        <a href="index.php?folder=reports&file=weeklyattd_emp_list&weekly_attd_year=<?php echo $weekly_attd_year; ?>&weekly_attd_week=<?php echo $weekly_attd_week; ?>" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>        
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info" style="border: 1px solid black !important;">
        <thead>
          <tr>
            <th style="border: 1px solid black !important;">Attendance Date</th>
            <th style="border: 1px solid black !important;">Attendance Day</th>
            <th style="border: 1px solid black !important;">In Time</th>
            <th style="border: 1px solid black !important;">Out Time</th>
            <th style="border: 1px solid black !important;">Location</th>
            <th style="border: 1px solid black !important;">Remark</th>
            <!-- <th style="border: 1px solid black !important;">Sign</th> -->
          </tr>
        </thead>
        <tbody>
        <?php
          $week_array = getStartAndEndDate($weekly_attd_week,$weekly_attd_year);
            
          $begin = new DateTime($week_array['week_start']);
          $end = new DateTime($week_array['week_end']);

          $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
          foreach($daterange as $date1)
          {
            $convdate = $date1->format("Y-m-d");
            $convday = date("D",strtotime($convdate));
            $getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
            if($convdate>date("Y-m-d")){
              if($datearray[1]==date("m")){
                break;
              }else{
                echo "<h4>You cannot take the Attendance of future date..!</h4>";
                break;
              }
            } 
          ?>
            <tr>
              <td style="border: 1px solid black !important;"> 
                <?php echo date("d-M-Y",strtotime($convdate)); ?>
              </td>
              <td style="border: 1px solid black !important;"><?php echo $convday; ?></td>
              <td style="border: 1px solid black !important;"><?php if($getattd->DEA_IN_TIME!=''){ echo $getattd->DEA_IN_TIME; }else{ echo "--"; } ?>
              </td>
              <td style="border: 1px solid black !important;"><?php if($getattd->DEA_OUT_TIME!=''){ if(date('h:i A',strtotime($getattd->DEA_OUT_TIME))< date('h:i A',strtotime("6:00 PM")) ){ echo $getattd->DEA_OUT_TIME; }else{ echo "6:00 PM"; } }else{ echo "--"; } ?>
              </td>
              <td style="border: 1px solid black !important;"><?php if($getattd->DEA_CURRENT_LOCATION!=''){ echo $getattd->DEA_CURRENT_LOCATION; }else{ echo "--"; } ?>
              </td>
              <td style="border: 1px solid black !important;"><?php if($getattd->DEA_REMARK!=''){ echo $getattd->DEA_REMARK; }else{ echo "--"; } ?>
              </td>                      
            </tr>
          <?php
          }
          ?>
        </tbody>        
      </table>       
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        bPaginate: false,
        
    } );

} );

</script>
