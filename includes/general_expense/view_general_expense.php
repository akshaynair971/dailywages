<?php  
  if(isset($_GET['DTE_ID']))
  {
    extract($_GET);
    $r=$db->get_row("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE a.DTE_ID='$DTE_ID' ORDER BY a.DTE_ID DESC");
    
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
          <h3>Travelling Expense Statement</h3>
          <div class="box-tools">
            <a href="?folder=travel_expense&file=view_travel_expense&exppdfdte_id=<?php echo $DTE_ID; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
            <a href="?folder=travel_expense&file=view_travel_expense&expxldte_id=<?php echo $DTE_ID; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>
            <a href="?folder=travel_expense&file=travel_expense_list" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <?php 
          if($r)
          { ?>
            <table  class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
              <tr>                
                <th style="border: 1px solid black !important;" >Voucher Ref.</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DTE_VOUCHER_REF; ?></td>

                <th style="border: 1px solid black !important;" >Voucher Date</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DTE_VOUCHER_DATE)); ?></td>                              
              </tr>
              <tr>                
                <th style="border: 1px solid black !important;" >Departed Date</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DTE_DEPARTED_DATE)); ?></td>

                <th style="border: 1px solid black !important;" >Returned Date</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DTE_RETURNED_DATE)); ?></td>                              
              </tr>
              <tr>                
                <th style="border: 1px solid black !important;" >Engineer Name</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")"; ?></td>

                <th style="border: 1px solid black !important;" >Location</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DTE_LOCATION; ?></td>                              
              </tr>  
            </table>
            <br>
            <br>
            <h4>Travelling Details</h4>
            <table class="table table-bordered table-striped table-responsive"> 
              <thead>
                <tr>
                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Sr. No.</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Date</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Place</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Travel</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Conveyance</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">L/B</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Extra</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Total</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Remarks</th>
                </tr>
              </thead> 
              <tbody>
                <?php 
                $json = json_decode($r->DTE_TRAVEL_SUMMARY);
                if($json)
                {
                  $cnt=0;
                  $travel_total = $conveyance_total = $lb_total = $extra_total = $subtotal = 0;
                  for ($i=0; $i < count($json->JOURNEY_DATE); $i++)
                  {
                    $main_total = 0;
                    $cnt++;
                  ?>
                                       
                    <tr>
                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php echo $cnt; ?>
                      </td>

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->JOURNEY_DATE[$i]!=''){ echo date("d-M-Y",strtotime($json->JOURNEY_DATE[$i])); } ?>
                      </td>                      

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->JOURNEY_PLACE[$i]!=''){ echo $json->JOURNEY_PLACE[$i]; } ?>
                      </td>  

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->TRAVEL_CHRG[$i]!=''){ echo $json->TRAVEL_CHRG[$i]; $travel_total += $json->TRAVEL_CHRG[$i];  } ?>
                      </td> 

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->CONVEY_CHRG[$i]!=''){ echo $json->CONVEY_CHRG[$i]; $conveyance_total += $json->CONVEY_CHRG[$i]; } ?>
                      </td> 

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->L_B_CHRG[$i]!=''){ echo $json->L_B_CHRG[$i]; $lb_total += $json->L_B_CHRG[$i]; } ?>
                      </td> 

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->EXTRA_CHRG[$i]!=''){ echo $json->EXTRA_CHRG[$i]; $extra_total += $json->EXTRA_CHRG[$i]; } ?>
                      </td>    

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->TOTAL_CHRG[$i]!=''){ echo $json->TOTAL_CHRG[$i]; $subtotal += $json->TOTAL_CHRG[$i]; } ?>
                      </td>      

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->REMARKS[$i]!=''){ echo $json->REMARKS[$i]; } ?>
                      </td> 
                    </tr>                   
                  <?php 
                  }  
                }?>
              </tbody>
              <tfoot>                
                <th colspan="3" class="text-center" style="border: 1px solid black !important;font-size: 13px;">Total</th>
                <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo $travel_total; ?></th>
                <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo $conveyance_total; ?></th>
                <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo $lb_total; ?></th>
                <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo $extra_total; ?></th>
                <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo $subtotal; ?></th>
                <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"></th>

              </tfoot>
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

