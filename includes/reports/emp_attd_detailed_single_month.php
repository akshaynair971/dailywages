
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
      <h3 class="box-title"><b>Attendance Report of Month <?php echo $fulldate; ?></b></h3>
      <div class="box-tools">
        <a href="index.php?folder=reports&file=emp_attd_single_month_list&DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>&select_attd_month=<?php echo $select_attd_month; ?>" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>        
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info">
        <thead>
          <tr>
            <th>Attendance Date</th>
            <th>Attendance Day</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Location</th>
            <th>Remark</th>
            <th>Sign</th>
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
              <td> 
                <?php echo $convdate; ?>
              </td>
              <td><?php echo $convday; ?></td>
              <td><?php if($getattd->DEA_IN_TIME!=''){ echo $getattd->DEA_IN_TIME; }else{ echo "--"; } ?>
              </td>
              <td><?php if($getattd->DEA_OUT_TIME!=''){ echo $getattd->DEA_OUT_TIME; }else{ echo "--"; } ?>
              </td>
              <td><?php if($getattd->DEA_CURRENT_LOCATION!=''){ echo $getattd->DEA_CURRENT_LOCATION; }else{ echo "--"; } ?>
              </td>
              <td><?php if($getattd->DEA_REMARK!=''){ echo $getattd->DEA_REMARK; }else{ echo "--"; } ?>
              </td>
              <td><?php if($getattd->DEA_SIGN!=''){ echo $getattd->DEA_SIGN; }else{ echo "--"; } ?>
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
        buttons: [
            // 'copyHtml5',
            'colvis',
            // { extend: 'print', footer: true, title: '<?php if (isset($title)){echo $title->ins_name;}   ?>' ,messageTop: 'Attendance Report of Month <?php echo $fulldate;?>' },
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name;}   ?>' ,messageTop: 'Attendance Report of Month <?php echo $fulldate;?>' },
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name;} ?>' , messageTop: 'Attendance Report of Month <?php echo $fulldate;?>', orientation: 'landscape' }
        ]
    } );

} );

</script>
