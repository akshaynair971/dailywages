<?php  
  if(isset($_GET['DEM_EMP_ID']))
  {
    extract($_GET);
    $user_details=$db->get_row("SELECT b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_employee_master as b WHERE b.DEM_EMP_ID='$DEM_EMP_ID'");


    if(date('M')>date('M',strtotime('March')))
    {
      $initial_year = date('Y');
      $initial_fin_year =  $initial_year."-04";

      $final_year = date('Y',strtotime('+1 Years'));
      $final_fin_year =  $final_year."-03";

    }else{
      $initial_year = date('Y',strtotime('-1 Years'));
      $initial_fin_year =  $initial_year."-04";

      $final_year = date('Y');
      $final_fin_year =  $final_year."-03";

    }

    $r = $db->get_results("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year'  AND DEA_CURRENT_LOCATION!='CUSTOMER SITE' AND DEA_CURRENT_LOCATION!='OFFICE' ORDER BY DEA_CURRENT_LOCATION ASC ");
    // $db->debug();
    // prnt($r);
  }
?>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
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
        <div class="box-header">
          <h4>Leave Report Details of <span style="color:green;"><?php echo $user_details->DEM_EMP_NAME_PREFIX." ".$user_details->DEM_EMP_FIRST_NAME." ".$user_details->DEM_EMP_MIDDLE_NAME." ".$user_details->DEM_EMP_LAST_NAME; ?> (<?php echo $user_details->DEM_EMP_ID; ?>)</span> - (<?php echo date('M-Y',strtotime($initial_fin_year))." ~ ".date('M-Y',strtotime($final_fin_year)); ?>)</h4>
          <div class="box-tools">
            <a href="?folder=leave_report&file=leave_report_details&exp_pdf_DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
            <a href="?folder=leave_report&file=leave_report_details&exp_xl_DEM_EMP_ID=<?php echo $DEM_EMP_ID; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>
            <a href="?folder=leave_report&file=leave_report_list" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive  table-striped" style="border: 1px solid black !important;">
            <thead>
              <tr>
                <th style="border: 1px solid black !important;" class="text-center">SR.NO</th>
                <th style="border: 1px solid black !important;" class="text-center">DATE</th>
                <th style="border: 1px solid black !important;" class="text-center">DAY</th>
                <th style="border: 1px solid black !important;" class="text-center">LEAVES/LOCATION</th>
                <th style="border: 1px solid black !important;" class="text-center">REMARKS</th>
              </tr>
            </thead> 
            <tbody>
            <?php  
            if(isset($r))
            {
              $emp = 0;
              foreach ($r as $row)
              {
                $emp++;                        
            ?>
              <tr>
                <td style="border: 1px solid black !important;" class="text-center"><?php echo $emp;  ?></td>
                <td style="border: 1px solid black !important;" class="text-center"><?php echo date('d-M-Y',strtotime($row->DEA_ATTD_DATE)); ?></td>
                <td style="border: 1px solid black !important;" class="text-center"><?php echo date('D',strtotime($row->DEA_ATTD_DATE)); ?></td>
                <td style="border: 1px solid black !important;" class="text-center"><?php echo $row->DEA_CURRENT_LOCATION; ?></td>
                <td style="border: 1px solid black !important;" class="text-center"><?php echo $row->DEA_REMARK; ?></td>
              </tr>

            <?php 
              } 
            }
            else 
            { 
              ?>
              <tr>                      
                <td style="border: 1px solid black !important;text-align: center;" colspan='5' class="pull-center" >
                  <b>No Record Available</b>
                </td>
              </tr>
            <?php 
            }  
            ?> 
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

