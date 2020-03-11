
<?php
if(isset($_GET['select_attd_month']))
{
  extract($_GET);
  
  $datearray = explode("-",$select_attd_month);
  $fulldate = date('F-Y',strtotime($select_attd_month));
  $r=$db->get_row("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$DEM_EMP_ID."'");   


}
?>

<div class="col-md-12">
  <div class="box box-primary">
        
    <div class="box-header">
      <h3 class="box-title"><b>Attendance Report of <span style="color:green;"><?php echo strtoupper($r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME); ?></span> (Month <?php echo $fulldate; ?>)</b></h3>
      <div class="box-tools">
        <a href="index.php?folder=reports&file=emp_attd_detailed_single_month&DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>&exppdfselect_attd_month=<?php echo $select_attd_month; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>        
        <a href="index.php?folder=reports&file=emp_attd_detailed_single_month&DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>&expxlselect_attd_month=<?php echo $select_attd_month; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>        
        <a href="index.php?folder=reports&file=emp_attd_single_month_list&DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>&select_attd_month=<?php echo $select_attd_month; ?>" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>        
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info" style="border: 1px solid black !important;">
        <thead>
          <tr>
            <th class="text-center" style="border: 1px solid black !important;">Attendance Date</th>
            <th class="text-center" style="border: 1px solid black !important;">Attendance Day</th>
            <th class="text-center" style="border: 1px solid black !important;">In Time</th>
            <th class="text-center" style="border: 1px solid black !important;">Out Time</th>
            <th class="text-center" style="border: 1px solid black !important;">Location</th>
            <th class="text-center" style="border: 1px solid black !important;">Remark</th>
            <!-- <th style="border: 1px solid black !important;">Sign</th> -->
          </tr>
        </thead>
        <tbody>
        <?php
          $countdays =  cal_days_in_month(CAL_GREGORIAN, $datearray[1], $datearray[0]);
          for($cntd=1;$cntd<=$countdays;$cntd++)
          {
            $convdate = date("Y-m-d",strtotime($datearray[0]."-".$datearray[1]."-".$cntd));
            $convday = date("D",strtotime($datearray[0]."-".$datearray[1]."-".$cntd));
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
              <td class="text-center" style="border: 1px solid black !important;"> 
                <?php echo date("d-M-Y",strtotime($convdate)); ?>
              </td>
              <td class="text-center" style="border: 1px solid black !important;"><?php echo $convday; ?></td>
              <td class="text-center" style="border: 1px solid black !important;"><?php if($getattd->DEA_IN_TIME!=''){ echo $getattd->DEA_IN_TIME; }elseif($convday=="Sun"){ echo "9:00 AM"; }else{ echo "--"; } ?>
              </td>
              <td class="text-center" style="border: 1px solid black !important;"><?php if($getattd->DEA_OUT_TIME!=''){ if(date('h:i A',strtotime($getattd->DEA_OUT_TIME))< date('h:i A',strtotime("6:00 PM")) ){ echo $getattd->DEA_OUT_TIME; }else{ echo "6:00 PM"; } }elseif($convday=="Sun"){ echo "6:00 PM"; }else{ echo "--"; } ?>
              </td>
              <td class="text-center" style="border: 1px solid black !important;"><?php if($getattd->DEA_CURRENT_LOCATION!=''){ echo $getattd->DEA_CURRENT_LOCATION; }elseif($convday=="Sun"){ echo "WEEKLY OFF"; }else{ echo "--"; } ?>
              </td>
              <td class="text-center" style="border: 1px solid black !important;"><?php if($getattd->DEA_REMARK!=''){ echo $getattd->DEA_REMARK; }else{ echo "--"; } ?>
              </td>
              <!-- <td style="border: 1px solid black !important;"><span style="display: none;"> <?php echo base64_encode("images/user_sign/".$DEM_EMP_ID."_SIGN.jpg"); ?></span><img style="width:100px;width:70px;" src="images/user_sign/<?php echo $DEM_EMP_ID."_SIGN.jpg"; ?> " onerror="this.src='images/sign.jpg'">
              </td>  -->        
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
        buttons: [
            // 'copyHtml5',
            'colvis',
            // { extend: 'print', footer: true, title: '<?php if (isset($title)){echo $title->ins_name;}   ?>' ,messageTop: 'Attendance Report of Month <?php echo $fulldate;?>' },
            // { extend: 'copyHtml5', footer: true },
            // { extend: 'excelHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name;}   ?>' ,messageTop: 'Attendance Report of Month <?php echo $fulldate;?>' },
            // { extend: 'csvHtml5', footer: true },
            // { extend: 'pdfHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name;} ?>' , messageTop: 'Attendance Report of Month <?php echo $fulldate;?>', orientation: 'landscape' }
        ]
    } );

} );

</script>
