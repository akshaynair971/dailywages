<?php  
  if($_POST['rep_gexp_sin_mon'] )
  {
    extract($_POST);
    // prnt($_POST);
    // prnt($_SESSION);
    // die();
    $filter='';

    if(empty($_POST['gexp_single_month']) && empty($_POST['gexp_start_date']) && empty($_POST['gexp_end_date']) && empty($_POST['DEM_ID']) && $_POST['expense_for']=="all")
    {
      $filter .= "";
    }
    else
    {
      $filter .= " WHERE";
    }
    if($_POST['gexp_single_month'])
    {
      $datearray = explode("-",$gexp_single_month);
      $filter .= " YEAR(a.DGE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DGE_VOUCHER_DATE)=$datearray[1] AND";
    }
    if($_POST['gexp_start_date'] && $_POST['gexp_end_date'])
    {
      $filter .= " DATE(a.DGE_VOUCHER_DATE)>='$gexp_start_date' AND DATE(a.DGE_VOUCHER_DATE)<='$gexp_end_date' AND";
    }
    if($_POST['DEM_ID'])
    {
      $filter .= " a.DEM_ID = '".$DEM_ID."' AND";
    }
    $filter = rtrim($filter," AND");
      // prnt($filter);
    
    $filter .= " ORDER BY a.DGE_ID DESC";
    
    // prnt($filter);
    
    
    $r=$db->get_results("SELECT a.*,b.DEM_ID,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID $filter");
    

  }else
  {

    if($_SESSION['user_type']=='2')
    {
      $r=$db->get_results("SELECT a.*,b.DEM_ID,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID WHERE a.DEM_ID = '".$_SESSION['ad_id']."' ORDER BY a.DGE_ID DESC");
      
    }else
    {
      $r=$db->get_results("SELECT a.*,b.DEM_ID,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID ORDER BY a.DGE_ID DESC");
      
    }
  }
  
  // $db->debug();
?>
<style type="text/css">
  .gexp_single_month_div, .gexp_start_date_div, .gexp_end_date_div
  {
    display: none;
  }
</style>
<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><label><i class="fa fa-book"></i> Select Month to Generate General Expense Report </label></h3>
          <div class="box-tools">
            <!-- <form method="POST" >
              <input type="hidden" name="curr_month_gexp_date" value="<?php echo date('Y-m'); ?>">
              <input type="submit" name="rep_texp_sin_cur_mon" value="Current Month (<?php echo date('F Y'); ?>)" class="btn btn-success btn-round">
            </form> -->            
          </div>
        </div>
        <div class="box-body">
          <form method="POST"><br>
            <div class="row">
              <div class="form-group col-md-4">
                <label style="">Select Employee <span style="color: red;"><?php if($_SESSION['user_type']==2){ echo "*";} ?></span></label>
                <select class="form-control select2" name="DEM_ID" <?php if($_SESSION['user_type']==2){ echo "required";} ?> >
                  <option value="">Select / Search Employee</option>
                  <?php 
                  if($_SESSION['user_type']=='2')
                  {
                    $empcond =  "WHERE DEM_ID=".$_SESSION['ad_id']." ORDER BY DEM_EMP_ID ASC";
                  }
                  else
                  {
                    $empcond =  "ORDER BY DEM_EMP_ID ASC";                    
                  }
                  $get_emp = $db->get_results("SELECT DEM_ID,DEM_EMP_ID,DEM_EMP_NAME_PREFIX,DEM_EMP_FIRST_NAME,DEM_EMP_MIDDLE_NAME,DEM_EMP_LAST_NAME FROM dw_employee_master $empcond");
                  if($get_emp)
                  {
                    foreach ($get_emp as $get_empkey) {               
                    ?>
                    <option value="<?php echo $get_empkey->DEM_ID; ?>" <?php if($_SESSION['user_type']=="2" && $get_empkey->DEM_ID == $_SESSION['ad_id']){ echo "selected";} ?>>(<?php echo $get_empkey->DEM_EMP_ID; ?>) <?php echo strtoupper($get_empkey->DEM_EMP_NAME_PREFIX." ".$get_empkey->DEM_EMP_FIRST_NAME." ".$get_empkey->DEM_EMP_MIDDLE_NAME." ".$get_empkey->DEM_EMP_LAST_NAME); ?> </option>
                    <?php 
                    }
                  } ?>
                </select>
              </div>

              <div class="form-group col-md-4"> 
                <label>Expense For <span style="color: red;">*</span></label>
                <select class="form-control" name="expense_for" id="expense_for" required>
                  <option value="">Select Expense For</option>
                  <option value="all">ALL</option>
                  <option value="single_month">SINGLE MONTH</option>
                  <option value="multiple_date">MULTIPLE DATE</option>
                </select>
              </div>

              <div class="form-group col-md-4 month_only gexp_single_month_div"> 
                <label>Select Month <span style="color: red;">*</span></label>
                <input type="text" name="gexp_single_month" id="gexp_single_month" class="form-control" placeholder="Select Month " autocomplete="off">
              </div>

              <div class="form-group col-md-4 gexp_start_date_div"> 
                <label>Select Date From <span style="color: red;">*</span></label>
                <input type="text" name="gexp_start_date" id="gexp_start_date" class="form-control" placeholder="Select Date From " autocomplete="off">
              </div>

              <div class="form-group col-md-4 gexp_end_date_div"> 
                <label>Select Date To <span style="color: red;">*</span></label>
                <input type="text" name="gexp_end_date" id="gexp_end_date" class="form-control" placeholder="Select Date To" autocomplete="off" >
              </div>

              <div class="col-md-4">
                
                <input type="submit" name="rep_gexp_sin_mon" value="Get Expense Report" class="btn btn-primary btn-round" style="margin-top: 25px !important;">
                <a href="?folder=general_expense&file=general_expense_list" class="btn btn-default btn-round" style="margin-top: 25px !important;">Reset </a>
                
              </div>
            </div>
          </form>
        </div>   
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
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
          <?php
          $explink = "";
          if($r)
          {

            if($_POST['DEM_ID'])
            {
              $explink .= "&DEM_ID=".$DEM_ID;
            }
            if($_POST['expense_for']=="all")
            {
              $explink .= "&expense_for=all";
            }
            if($_POST['gexp_single_month'])
            {
              $explink .= "&gexp_single_month=".$gexp_single_month;
            }
            if($_POST['gexp_start_date'] && $_POST['gexp_end_date'])
            {
              $explink .= "&gexp_start_date=".$gexp_start_date."&gexp_end_date=".$gexp_end_date;
            }
          
          ?>
          <a href="?folder=general_expense&file=general_expense_list&overall_gen_exp_xl=1<?php echo $explink; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>

          <a href="?folder=general_expense&file=general_expense_list&overall_gen_exp_pdf=1<?php echo $explink; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
          
          <?php            
          }
          ?>
            
          <a href='index.php?folder=general_expense&file=add_general_expense' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New Expense</b></a>
            

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
            <thead>
              <tr>
                <th class="text-center" style="border: 1px solid black !important;" >SR.NO</th>
                <th class="text-center" style="border: 1px solid black !important;" >EMP. CODE</th>
                <th class="text-center" style="border: 1px solid black !important;" >ENGINEER NAME</th>                
                <th class="text-center" style="border: 1px solid black !important;" >VOUCHER REF.</th> 
                <th class="text-center" style="border: 1px solid black !important;" >VOUCHER DATE</th>
                <th class="text-center" style="border: 1px solid black !important;" >INVOICE NO.</th>
                <th class="text-center" style="border: 1px solid black !important;" >INVOICE DATE</th>
                <th class="text-center" style="border: 1px solid black !important;" >LOCATION</th> 
                <!-- <th class="text-center" style="border: 1px solid black !important;" >Travel</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Conveyance</th> 
                <th class="text-center" style="border: 1px solid black !important;" >L/B</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Extra</th>  -->
                <th class="text-center" style="border: 1px solid black !important;" >TOTAL</th> 
                <!-- <th class="text-center" style="border: 1px solid black !important;" >Status</th> -->
                <!-- <th class="text-center" style="border: 1px solid black !important;" >Paid Date</th> -->
                <!-- <th class="text-center" style="border: 1px solid black !important;" >Login Detail</th> -->
                <th class="text-center" style="width:15% !important;border: 1px solid black !important;">ACTION</th>
              </tr>
            </thead> 
            <tbody>
            <?php  
            if(isset($r)){
            $emp = 0;
            $grand_travel_total = $grand_conveyance_total = $grand_lb_total = $grand_extra_total = $grand_subtotal = 0;
            foreach ($r as $row){
            $emp++;        
            $json = json_decode($row->DGE_EXPENSE_SUMMARY);
            if($json)
            {    
              $travel_total = $conveyance_total = $lb_total = $extra_total = $subtotal = 0;
              
              // for ($i=0; $i < count($json->JOURNEY_DATE); $i++)
              // {
              //   $main_total = 0;  
              //   $travel_total += $json->TRAVEL_CHRG[$i];
              //   $conveyance_total += $json->CONVEY_CHRG[$i];
              //   $lb_total += $json->L_B_CHRG[$i];
              //   $extra_total += $json->EXTRA_CHRG[$i];  
              //   $subtotal += $json->TOTAL_CHRG[$i]; 
              // }
            }                
            ?>
              <tr style="<?php if($row->DTE_STATUS=="0"){ echo 'background-color: #122630; color: white;'; } ?>">
                
                <td class="text-center" style="border: 1px solid black !important;"><?php echo $emp; ?></td>                
                
                
                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DEM_EMP_ID; ?></td>

                <td class="text-center" style="border: 1px solid black !important;">
                  <?php echo $row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME; ?>                      
                </td>

                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DGE_VOUCHER_REF; ?></td>

                <td class="text-center" style="border: 1px solid black !important;"><?php echo date("d-M-Y",strtotime($row->DGE_VOUCHER_DATE)); ?></td>

                <td class="text-center" style="border: 1px solid black !important;">
                  <?php echo $row->DGE_INVOICE_NO; ?>               
                </td>  

                <td class="text-center" style="border: 1px solid black !important;"><?php echo date("d-M-Y",strtotime($row->DGE_INVOICE_DATE)); ?></td> 

                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DGE_LOCATION; ?></td>

                
                <td class="text-center" style="border: 1px solid black !important; "><?php echo $row->DGE_TOTAL; ?></td> 
                <?php 
                $GRAND_DGE_TOTAL += $row->DGE_TOTAL;
               
                ?>

                <!-- <td class="text-center" style="border: 1px solid black !important;"><?php if($row->DTE_PAYMENT_STATUS==1){ echo "PAID"; }else{ echo "UNPAID"; } ?></td>  -->

                <!-- <td class="text-center" style="border: 1px solid black !important;"><?php if($row->DTE_PAID_DATE!=0){ echo date("d-M-Y",strtotime($row->DTE_PAID_DATE)); } ?></td>  -->
                
                <td class="text-center" style="border: 1px solid black !important;"  align="center">

                  <a title="View Expense Details" href="?folder=general_expense&file=view_general_expense&DGE_ID=<?php echo $row->DGE_ID; ?>" class="btn btn-primary" style="margin: 2px;"><i class="fa fa-eye"></i> </a>

                  <?php 
                  if($row->DGE_STATUS==1 || $_SESSION['user_type']==1)
                  {
                   ?>
                  <a title="Edit General Expense" href="?folder=general_expense&file=add_general_expense&DGE_ID=<?php echo $row->DGE_ID; ?>" class="btn btn-primary" style="margin: 2px;"><i class="fa fa-pencil"></i> </a>
                  <?php 
                  } ?>
                  <?php 
                  if($_SESSION['user_type']==1)
                  {
                    
                    ?>
                    <!-- <button title="Add Payment Status"  data-target="#view-modal"  data-toggle="modal"  id="getUserdemo" data-id="<?php echo $row->DTE_ID; ?>" class="btn btn-info getUserdemo"><i class="fa fa-plus-square"></i> </button> -->
                    <?php
                   
                   ?>
                  <a onclick="return confirm('Are you Sure ?');" title="Delete General Expense" href="?folder=general_expense&file=general_expense_list&DEL_DGE_ID=<?php echo $row->DGE_ID; ?>" class="btn btn-danger" style="margin: 2px;"><i class="fa fa-trash"></i> </a>
                  <?php 
                  } ?>
                 
                </td>
              </tr>
            <?php } 
            }
            else { ?>
              <tr>                      
                <td style="border: 1px solid black !important;text-align: center;" colspan='10' class="pull-center" >
                  <b>No Record Available</b>
                </td>
              </tr>
            <?php }  ?> 
            </tbody>
            <tfoot>
              <tr>
                <td class="text-right" colspan="8" style=" border: 1px solid black !important;"><b>Total</b></td>
                
                <td class="text-center" style=" border: 1px solid black !important;"><b><?php echo $GRAND_DGE_TOTAL; ?></b></td>
                
                <td class="text-center" style=" border: 1px solid black !important;"></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
    </div>
      <!-- /.box -->
  </div>
</section>
<!-- /.content -->

<script>
  $(document).ready(function() {
    $('#gexp_single_month').datepicker( {
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'yy-mm',
      yearRange: "1950:2050",
      beforeShow: function(input, inst) {
        $(inst.dpDiv).addClass('calendar-off');     
      },
      onClose: function(dateText, inst) { 
        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, month, 1));
      }
  });
  $( "#gexp_start_date,#gexp_end_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd',
      yearRange: "1950:2050",
      beforeShow: function(input, inst) {
        $(inst.dpDiv).removeClass('calendar-off');     
      }
    });
  });
</script>

<script>
  $('#expense_for').on('change',function(){
    var expense_for = $(this).val();
    // alert(expense_for);
    if(expense_for=='all' || expense_for=='')
    {

      $('.gexp_single_month_div,.gexp_start_date_div,.gexp_end_date_div').hide();
      $('#gexp_single_month,#gexp_start_date,#gexp_end_date').removeAttr('required');

    }
    if(expense_for=='single_month')
    {
      // alert(expense_for);
      $('.gexp_single_month_div').show();
      $('.gexp_start_date_div,.gexp_end_date_div').hide();
      $('#gexp_single_month').attr('required','required');
      $('#gexp_start_date,#gexp_end_date').removeAttr('required');

    }
    if(expense_for=='multiple_date')
    {
      $('.gexp_single_month_div').hide();      
      $('.gexp_start_date_div,.gexp_end_date_div').show();
      $('#gexp_single_month').removeAttr('required');
      $('#gexp_start_date,#gexp_end_date').attr('required','required');
    }
  });
  
</script>