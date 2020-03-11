<?php  
  if(isset($_GET['DEM_EMP_ID']) && isset($_GET['SAL_SUM_REP_FROM_DATE']) && isset($_GET['SAL_SUM_REP_TO_DATE']))
  {
    extract($_GET);
    // prnt($_GET);
    $r=$db->get_row("SELECT a.* FROM dw_employee_master as a WHERE a.DEM_EMP_ID='$DEM_EMP_ID'");
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
          <h3>Salary Summary Report</h3>
          <div class="box-tools">
            <!-- <a href="?folder=travel_expense&file=view_travel_expense&exppdfdte_id=<?php echo $DTE_ID; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a> -->
            <!-- <a href="?folder=travel_expense&file=view_travel_expense&expxldte_id=<?php echo $DTE_ID; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a> -->
            <a href="?folder=reports&file=emp_report_filter_by_date" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <?php 
          if($r)
          { ?>
            <table  class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
              <tr>                
                <th style="border: 1px solid black !important;" >Engineer Name</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")"; ?></td>

                <th style="border: 1px solid black !important;" >PAN</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DEM_PAN_ID; ?></td>                              
              </tr>  

              <tr>                
                <th style="border: 1px solid black !important;" >DOJ</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DEM_START_DATE)); ?></td>

                <th style="border: 1px solid black !important;" >Location</th> 
                <td style="border: 1px solid black !important;" ></td>                              
              </tr>
              <tr>                
                <th style="border: 1px solid black !important;" >Salary Summary From</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("M-Y",strtotime($SAL_SUM_REP_FROM_DATE)); ?></td>

                <th style="border: 1px solid black !important;" >To Month</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("M-Y",strtotime($SAL_SUM_REP_TO_DATE)); ?></td>                              
              </tr>
              
            </table>
            <br>
            <br>
            <h4>This is salary slip only. This should not be treated as salary certificate</h4>
            <table class="table table-bordered table-striped table-responsive"> 
              <thead>
                <tr>
                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Heading</th>
                  <?php 
                  $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                  while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                  {
                  ?>
                    <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo date('M-Y',strtotime($mon_iterator)); ?></th>
                  <?php
                  $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));
                  }
                  ?>
                  
                </tr>
              </thead> 
              <tbody>
                
              </tbody>
              
            </table>
          <?php 
          } 
          ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

