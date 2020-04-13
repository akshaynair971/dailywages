<?php  
  if(isset($_GET['DGE_ID']))
  {
    extract($_GET);
    $r=$db->get_row("SELECT a.*,b.DEM_ID,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID WHERE a.DGE_ID='$DGE_ID' ORDER BY a.DGE_ID DESC");
    // $db->debug();
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
          <h3>General Expense Statement</h3>
          <div class="box-tools">
            <a href="?folder=general_expense&file=view_general_expense&exppdfdge_id=<?php echo $DGE_ID; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
            <a href="?folder=general_expense&file=view_general_expense&expxldge_id=<?php echo $DGE_ID; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>
            <a href="?folder=general_expense&file=general_expense_list" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <?php 
          if($r)
          { ?>
            <table  class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
              <tr>                
                <th style="border: 1px solid black !important;" >Cash Voucher Ref.</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DGE_VOUCHER_REF; ?></td>

                <th style="border: 1px solid black !important;" >Voucher Date</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DGE_VOUCHER_DATE)); ?></td>                              
              </tr>
              
              <tr>                
                <th style="border: 1px solid black !important;" >Engineer Name</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")"; ?></td>

                <th style="border: 1px solid black !important;" >Location</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DGE_LOCATION; ?></td>                              
              </tr>  

              <tr>                
                <th style="border: 1px solid black !important;" >Invoice No.</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DGE_INVOICE_NO; ?></td>

                <th style="border: 1px solid black !important;" >Invoice Date</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DGE_INVOICE_DATE)); ?></td>                              
              </tr>
            </table>
            <br>
            <br>
            <h4>Expense Details</h4>
            <table class="table table-bordered table-striped table-responsive"> 
              <thead>
                <tr>
                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Sr. No.</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Item</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Amount</th>

                  <th class="text-center" style="border: 1px solid black !important;font-size: 13px;">Remarks</th>
                </tr>
              </thead> 
              <tbody>
                <?php 
                $json = json_decode($r->DGE_EXPENSE_SUMMARY);
                if($json)
                {
                  $cnt=0;

                  $subtotal = 0;
                  for ($i=0; $i < count($json->DGE_ITEM); $i++)
                  {                    
                    $cnt++;
                  ?>
                                       
                    <tr>
                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php echo $cnt; ?>
                      </td>

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->DGE_ITEM[$i]!=''){ echo $json->DGE_ITEM[$i]; } ?>
                      </td>                      

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->DGE_AMOUNT[$i]!=''){ echo $json->DGE_AMOUNT[$i]; $subtotal +=$json->DGE_AMOUNT[$i]; }  ?>
                      </td>                        

                      <td class="text-center" style="border: 1px solid black !important;font-size: 13px;">
                        <?php if($json->REMARKS[$i]!=''){ echo $json->DGE_REMARKS[$i]; } ?>
                      </td> 
                    </tr>                   
                  <?php 
                  }  
                }?>
              </tbody>
              <tfoot>                
                <th colspan="2" class="text-center" style="border: 1px solid black !important;font-size: 13px;">Total</th>
                
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

