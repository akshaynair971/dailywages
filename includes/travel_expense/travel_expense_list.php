<?php  
  if($_POST['rep_texp_sin_mon'])
  {
    extract($_POST);
    // prnt($_POST);
     
    $filter='';

    if(empty($_POST['texp_single_month']) && empty($_POST['texp_start_date']) && empty($_POST['texp_end_date']) && empty($_POST['DEM_EMP_ID']) && $_POST['expense_for']=="all")
    {
      $filter .= "";
    }
    else
    {
      $filter .= " WHERE";
    }
    if($_POST['texp_single_month'])
    {
      $datearray = explode("-",$texp_single_month);
      $filter .= " YEAR(a.DTE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DTE_VOUCHER_DATE)=$datearray[1] AND";
    }
    if($_POST['texp_start_date'] && $_POST['texp_end_date'])
    {
      $filter .= " DATE(a.DTE_VOUCHER_DATE)>='$texp_start_date' AND DATE(a.DTE_VOUCHER_DATE)<='$texp_end_date' AND";
    }
    if($_POST['DEM_EMP_ID'])
    {
      $filter .= " a.DEM_EMP_ID = '".$DEM_EMP_ID."' AND";
    }
    $filter = rtrim($filter," AND");
      // prnt($filter);
    
    $filter .= " ORDER BY a.DTE_ID DESC";

    $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID $filter");
    // $db->debug();
    

  }else
  {

    if($_SESSION['user_type']=='2')
    {
      $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE a.DEM_EMP_ID = '".$_SESSION['DEM_EMP_ID']."' ORDER BY a.DTE_ID DESC");
      
    }else
    {
      $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID ORDER BY a.DTE_ID DESC");
      
    }
  }
?>
<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><label><i class="fa fa-book"></i> Select Month to Generate Travel Expense Report </label></h3>
          <div class="box-tools">
            <!-- <form method="POST" >
              <input type="hidden" name="curr_month_texp_date" value="<?php echo date('Y-m'); ?>">
              <input type="submit" name="rep_texp_sin_cur_mon" value="Current Month (<?php echo date('F Y'); ?>)" class="btn btn-success btn-round">
            </form> -->
            
          </div>
        </div>
        <div class="box-body">
          <form method="POST"><br>
            <div class="row">
              <div class="form-group col-md-4">
                <label style="">Select Employee <span style="color: red;"><?php if($_SESSION['user_type']==2){ echo "*";} ?></span></label>
                <select class="form-control select2" name="DEM_EMP_ID" <?php if($_SESSION['user_type']==2){ echo "required";} ?> >
                  <option value="">Select / Search Employee</option>
                  <?php 
                  if($_SESSION['user_type']=='2')
                  {
                    $empcond =  "WHERE DEM_EMP_ID=".$_SESSION['DEM_EMP_ID']." ORDER BY DEM_EMP_ID ASC";
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
                    <option value="<?php echo $get_empkey->DEM_EMP_ID; ?>" <?php if($_SESSION['user_type']=="2" && $get_empkey->DEM_EMP_ID == $_SESSION['DEM_EMP_ID']){ echo "selected";} ?>>(<?php echo $get_empkey->DEM_EMP_ID; ?>) <?php echo strtoupper($get_empkey->DEM_EMP_NAME_PREFIX." ".$get_empkey->DEM_EMP_FIRST_NAME." ".$get_empkey->DEM_EMP_MIDDLE_NAME." ".$get_empkey->DEM_EMP_LAST_NAME); ?> </option>
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

              <div class="form-group col-md-4 month_only texp_single_month_div"> 
                <label>Select Month <span style="color: red;">*</span></label>
                <input type="text" name="texp_single_month" id="texp_single_month" class="form-control" placeholder="Select Month " autocomplete="off">
              </div>

              <div class="form-group col-md-4 texp_start_date_div"> 
                <label>Select Date From <span style="color: red;">*</span></label>
                <input type="text" name="texp_start_date" id="texp_start_date" class="form-control" placeholder="Select Date From " autocomplete="off">
              </div>

              <div class="form-group col-md-4 texp_end_date_div"> 
                <label>Select Date To <span style="color: red;">*</span></label>
                <input type="text" name="texp_end_date" id="texp_end_date" class="form-control" placeholder="Select Date To" autocomplete="off" >
              </div>

              <div class="col-md-4">
                
                <input type="submit" name="rep_texp_sin_mon" value="Get Expense Report" class="btn btn-primary btn-round" style="margin-top: 25px !important;">
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

            if($_POST['DEM_EMP_ID'])
            {
              $explink .= "&DEM_EMP_ID=".$DEM_EMP_ID;
            }
            if($_POST['expense_for']=="all")
            {
              $explink .= "&expense_for=all";
            }
            if($_POST['texp_single_month'])
            {
              $explink .= "&texp_single_month=".$texp_single_month;
            }
            if($_POST['texp_start_date'] && $_POST['texp_end_date'])
            {
              $explink .= "&texp_start_date=".$texp_start_date."&texp_end_date=".$texp_end_date;
            }
          
          ?>
          
          <a href="?folder=travel_expense&file=travel_expense_list&overall_trexp_xl=1<?php echo $explink; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>

          <a href="?folder=travel_expense&file=travel_expense_list&overall_trexp_pdf=1<?php echo $explink; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
          
          <?php            
          }
          ?>
            
          <a href='index.php?folder=travel_expense&file=add_travel_expense' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New Expense</b></a>
            

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
            <thead>
              <tr>
                <th class="text-center" style="border: 1px solid black !important;" >Sr.No</th>
                <th class="text-center" style="border: 1px solid black !important;" >Voucher Ref.</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Voucher Date</th>
                <th class="text-center" style="border: 1px solid black !important;" >Emp. Code</th>
                <th class="text-center" style="border: 1px solid black !important;" >Engineer Name</th>
                <th class="text-center" style="border: 1px solid black !important;" >Departed Date</th>
                <th class="text-center" style="border: 1px solid black !important;" >Returned Date</th>
                <th class="text-center" style="border: 1px solid black !important;" >Location</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Travel</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Conveyance</th> 
                <th class="text-center" style="border: 1px solid black !important;" >L/B</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Extra</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Total</th> 
                <th class="text-center" style="border: 1px solid black !important;" >Status</th>
                <th class="text-center" style="border: 1px solid black !important;" >Paid Date</th>
                <!-- <th class="text-center" style="border: 1px solid black !important;" >Login Detail</th> -->
                <th class="text-center" style="width:15% !important;border: 1px solid black !important;">Action</th>
              </tr>
            </thead> 
            <tbody>
            <?php  
            if(isset($r)){
            $emp = 0;
            $grand_travel_total = $grand_conveyance_total = $grand_lb_total = $grand_extra_total = $grand_subtotal = 0;
            foreach ($r as $row){
            $emp++;        
            $json = json_decode($row->DTE_TRAVEL_SUMMARY);
            if($json)
            {    
              $travel_total = $conveyance_total = $lb_total = $extra_total = $subtotal = 0;
              
              for ($i=0; $i < count($json->JOURNEY_DATE); $i++)
              {
                $main_total = 0;  
                $travel_total += $json->TRAVEL_CHRG[$i];
                $conveyance_total += $json->CONVEY_CHRG[$i];
                $lb_total += $json->L_B_CHRG[$i];
                $extra_total += $json->EXTRA_CHRG[$i];  
                $subtotal += $json->TOTAL_CHRG[$i]; 
              }
            }                
            ?>
              <tr style="<?php if($row->DTE_STATUS=="0"){ echo 'background-color: #122630; color: white;'; } ?>">
                
                <td class="text-center" style="border: 1px solid black !important;"><?php echo $emp; ?></td>                
                
                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DTE_VOUCHER_REF; ?></td>

                <td class="text-center" style="border: 1px solid black !important;"><?php echo date("d-M-Y",strtotime($row->DTE_VOUCHER_DATE)); ?></td>

                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DEM_EMP_ID; ?></td>

                <td class="text-center" style="border: 1px solid black !important;">
                  <?php echo $row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME; ?>                      
                </td>

                <td class="text-center" style="border: 1px solid black !important;">
                  <?php echo date("d-M-Y",strtotime($row->DTE_DEPARTED_DATE)); ?>               
                </td>  

                <td class="text-center" style="border: 1px solid black !important;"><?php echo date("d-M-Y",strtotime($row->DTE_RETURNED_DATE)); ?></td> 

                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DTE_LOCATION; ?></td> 
                <td class="text-center" style="border: 1px solid black !important; "><?php echo $travel_total; ?></td> 
                <td class="text-center" style="border: 1px solid black !important; "><?php echo $conveyance_total; ?></td> 
                <td class="text-center" style="border: 1px solid black !important; "><?php echo $lb_total; ?></td> 
                <td class="text-center" style="border: 1px solid black !important; "><?php echo $extra_total; ?></td> 
                <td class="text-center" style="border: 1px solid black !important; "><?php echo $subtotal; ?></td> 
                <?php 
                $grand_travel_total += $travel_total;
                $grand_conveyance_total += $conveyance_total;
                $grand_lb_total += $lb_total;
                $grand_extra_total += $extra_total;
                $grand_subtotal += $subtotal;
                ?>

                <td class="text-center" style="border: 1px solid black !important;"><?php if($row->DTE_PAYMENT_STATUS==1){ echo "PAID"; }else{ echo "UNPAID"; } ?></td> 

                <td class="text-center" style="border: 1px solid black !important;"><?php if($row->DTE_PAID_DATE!=0){ echo date("d-M-Y",strtotime($row->DTE_PAID_DATE)); } ?></td> 
                
                <td class="text-center" style="border: 1px solid black !important;"  align="center">

                  <a title="View Details" href="?folder=travel_expense&file=view_travel_expense&DTE_ID=<?php echo $row->DTE_ID; ?>" class="btn btn-primary" style="margin: 2px;"><i class="fa fa-eye"></i> </a>

                  <?php 
                  if($row->DTE_STATUS==1 || $_SESSION['user_type']==1)
                  {
                   ?>
                  <a title="Edit Travel & Expense" href="?folder=travel_expense&file=add_travel_expense&DTE_ID=<?php echo $row->DTE_ID; ?>" class="btn btn-primary" style="margin: 2px;"><i class="fa fa-pencil"></i> </a>
                  <?php 
                  } ?>
                  <?php 
                  if($_SESSION['user_type']==1)
                  {
                    
                    ?>
                    <button title="Add Payment Status"  data-target="#view-modal"  data-toggle="modal"  id="getUserdemo" data-id="<?php echo $row->DTE_ID; ?>" class="btn btn-info getUserdemo"><i class="fa fa-plus-square"></i> </button>
                    <?php
                   
                   ?>
                  <a onclick="return confirm('Are you Sure ?');" title="Delete Travel & Expense" href="?folder=travel_expense&file=travel_expense_list&del_DTE_ID=<?php echo $row->DTE_ID; ?>" class="btn btn-danger" style="margin: 2px;"><i class="fa fa-trash"></i> </a>
                  <?php 
                  } ?>
                 
                </td>
              </tr>
            <?php } 
            }
            else { ?>
              <tr>                      
                <td style="border: 1px solid black !important;text-align: center;" colspan='16' class="pull-center" >
                  <b>No Record Available</b>
                </td>
              </tr>
            <?php }  ?> 
            </tbody>
            <tfoot>
              <tr>
                <td colspan="8" style=" border: 1px solid black !important;"><b>Total</b></td>
                <td class="text-center" style=" border: 1px solid black !important;"><b><?php echo $grand_travel_total; ?></b></td>
                <td class="text-center" style=" border: 1px solid black !important;"><b><?php echo $grand_conveyance_total; ?></b></td>
                <td class="text-center" style=" border: 1px solid black !important;"><b><?php echo $grand_lb_total; ?></b></td>
                <td class="text-center" style=" border: 1px solid black !important;"><b><?php echo $grand_extra_total; ?></b></td>
                <td class="text-center" style=" border: 1px solid black !important;"><b><?php echo $grand_subtotal; ?></b></td>
                <td class="text-center" style=" border: 1px solid black !important;"><b></b></td>
                <td class="text-center" style=" border: 1px solid black !important;"></td>
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

<!-- Modal code for Employee Details-->
<div class="row">
  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm"> 
      <div class="modal-content">            
        <div class="modal-header"> 
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button> 
          <h4 class="modal-title">
            Add Payment Status
          </h4> 
        </div> 
        <div class="modal-body">                  
          <div id="modal-loader" style="display: none; text-align: center;">
            <img src="ajax-loader.gif" style="width: 23%;position: absolute;top: 28%;right: 41%;z-index: 1999;">
          </div>                         
          <div id="dynamic-content">
            <form method="POST">
              <div class="row">             
                <input type="hidden" name="DTE_ID" id="DTE_ID" value="">

                <div class="form-group col-md-12">
                  <label>Paid Status</label>
                  <select  class="form-control" name="DTE_PAYMENT_STATUS" id="DTE_PAYMENT_STATUS">
                    <option value="">Select Status</option>
                    <option value="1">PAID</option>
                    <option value="0">UNPAID</option>
                  </select>
                </div>

                <div class="form-group col-md-12">
                  <label>Paid Date</label>
                  <input type="text" class="form-control" name="DTE_PAID_DATE" id="DTE_PAID_DATE" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                  <label>Remark/Payment Reference </label>
                  <textarea class="form-control" name="DTE_PAYMENT_REFERENCE" id="DTE_PAYMENT_REFERENCE" ></textarea>
                </div>

                <div class="col-md-12">
                  <input type="submit" name="DTE_SUBMIT_PAYMENT_STATUS" id="DTE_SUBMIT_PAYMENT_STATUS" class="btn btn-primary" value="SUBMIT">
                </div>
              </div>
            </form>
          </div>     
        </div> 
        <div class="modal-footer"> 
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
        </div>                   
      </div> 
    </div>
  </div><!-- /.modal -->   
</div>
  
<!-- End  Modal code for Employee Details -->

<script>
  $(document).ready(function() {
    $('#texp_single_month').datepicker( {
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
  $( "#texp_start_date,#texp_end_date" ).datepicker({
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

      $('.texp_single_month_div,.texp_start_date_div,.texp_end_date_div').hide();
      $('#texp_single_month,#texp_start_date,#texp_end_date').removeAttr('required');

    }
    if(expense_for=='single_month')
    {
      // alert(expense_for);
      $('.texp_single_month_div').show();
      $('.texp_start_date_div,.texp_end_date_div').hide();
      $('#texp_single_month').attr('required','required');
      $('#texp_start_date,#texp_end_date').removeAttr('required');

    }
    if(expense_for=='multiple_date')
    {
      $('.texp_single_month_div').hide();      
      $('.texp_start_date_div,.texp_end_date_div').show();
      $('#texp_single_month').removeAttr('required');
      $('#texp_start_date,#texp_end_date').attr('required','required');
    }
  });
  
</script>



<script>
$(document).ready(function(){
  
  $(document).on('click', '#getUserdemo', function(e){    
    e.preventDefault();     
    var DTE_ID = $(this).data('id');   // it will get id of clicked row
    $('#DTE_ID').val(DTE_ID);
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {DTE_ID:DTE_ID,get_travelexp_payment_status:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
      $('#modal-loader').hide(); 
      if(data)
      {
        var ob = JSON.parse(data);
         
        if(ob.status==="success")
        {

          $('#DTE_PAYMENT_STATUS').val(ob.DTE_PAYMENT_STATUS);
          $('#DTE_PAID_DATE').val(ob.DTE_PAID_DATE);
          $('#DTE_PAYMENT_REFERENCE').val(ob.DTE_PAYMENT_REFERENCE);
          $('#DTE_SUBMIT_PAYMENT_STATUS').show();
          $('#PAYMENT_MSG').html('');

        }
        else
        {
          $('#PAYMENT_MSG').css('color','red').html('Something Went Wrong...!');
          // $('#DTE_SUBMIT_PAYMENT_STATUS').hide();
        }  

      }          
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });
}); 
</script>

   