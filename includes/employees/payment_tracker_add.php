<?php

?>
<!-- Main content -->
<section class="content">
  <div class="row">        
    <div class="col-md-12 col-lg-12">          
      <div class="box">
        <div class="box-header">
          <?php  
            if(isset($msg))
            {
              echo"<div style='font-size:18px; color:red; margin-left:15px; font-weight:700;'>".$msg."</div>";
            }
            if(isset($succ))
            {
              echo"<div style='font-size:18px; color:green; margin-left:15px; font-weight:700;'>".$succ."</div>";
            }
            // prnt($payroll_details);
          ?>
          <h3>Payroll Tracker</h3>
          <div class="box-tools">
            <a href="?folder=employees&file=payment_tracker_view&DEM_EMP_ID=<?php echo $_GET['DEM_EMP_ID']; ?>" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
            
          </div>
        </div>
            <!-- /.box-header -->
        <div class="box-body">
          <?php 
          if($_GET['DEM_EMP_ID']){
            if($_GET['DPT_ID']!=''){
              extract($_GET);
              $user_edit = $db->get_row("SELECT * FROM dw_payment_tracker WHERE DPT_ID='$DPT_ID'");
              $attd_date_array = explode("-",$paymonth);
              $getempattd= $db->get_var("SELECT COUNT(*) FROM dw_emp_attendance WHERE  DEM_EMPLOYEE_ID = '$DEM_EMP_ID' AND DEA_ATTD_YEAR='$attd_date_array[0]' AND DEA_ATTD_MONTH='$attd_date_array[1]'");
            }
            
  
  

            $payroll_details = $db->get_row("SELECT * FROM dw_payroll_master WHERE DEM_EMP_ID='".$_GET['DEM_EMP_ID']."'");

            $totaldeduction= $payroll_details->DPM_PROFESSIONAL_TAX + $payroll_details->DPM_PF_EMPLOYEE  + $payroll_details->DPM_ESIC_EMPLOYEE; 
            // $db->debug();
            $getuserdetails = $db->get_row("SELECT * FROM dw_employee_master WHERE  DEM_EMP_ID='".$_GET['DEM_EMP_ID']."' ");   
           ?>
           <h4 style="color: green;font-size: 18px;"><?php echo strtoupper($getuserdetails->DEM_EMP_FIRST_NAME." ".$getuserdetails->DEM_EMP_MIDDLE_NAME." ".$getuserdetails->DEM_EMP_LAST_NAME); ?> ( <?php echo $getuserdetails->DEM_EMP_ID; ?> )</h4>
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12 col-xs-12">   
                          

              <div class="form-group col-md-3">
                <label for="DPT_TOTAL_DAYS_WORKED">Total Days Worked <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DPT_TOTAL_DAYS_WORKED'  name='DPT_TOTAL_DAYS_WORKED' placeholder="Enter Total Days Worked" value="<?php if(isset($getempattd)){ echo $getempattd; } ?>" required readonly>  
              </div>

              <!-- <div class="form-group col-md-3">
                <label for="DPT_TOTAL_GW_HRS">Total GW Hours </label>
                <input type="text" class="form-control" id='DPT_TOTAL_GW_HRS'  name='DPT_TOTAL_GW_HRS' placeholder="Enter Total Gross Work Hours" value="<?php if(isset($user_edit)){ echo $user_edit->DPT_TOTAL_GW_HRS; } ?>"  >  
              </div> -->

              <div class="form-group col-md-3">
                <label for="TOTAL_DEDUCTION">Total Deduction <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='TOTAL_DEDUCTION'  name='TOTAL_DEDUCTION' placeholder="Enter Total Deduction" value="<?php if($totaldeduction!=''){ echo $totaldeduction; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="DPT_NET_WAGES_PAID">Net Wages Paid<span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DPT_NET_WAGES_PAID'  name='DPT_NET_WAGES_PAID' placeholder="Enter Net Wages" value="<?php if($payroll_details->DPM_CALCULATED_AMOUNT!=''){ echo $payroll_details->DPM_CALCULATED_AMOUNT; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="EPS">EPS<span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='EPS'  name='EPS' placeholder="Enter EPS" value="<?php if($payroll_details->DPM_ESIC_EMPLOYER!=''){ $EPS = round((8.33 *  $payroll_details->DPM_ESIC_EMPLOYER ) / 100); echo $EPS; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="CASH_REIMBURSEMENT_MOBILE">Cash Reimb. Mobile <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='CASH_REIMBURSEMENT_MOBILE'  name='CASH_REIMBURSEMENT_MOBILE' placeholder="Enter Cash Reimbursement Mobile" value="<?php if($user_edit->CASH_REIMBURSEMENT_MOBILE!=''){ echo $user_edit->CASH_REIMBURSEMENT_MOBILE; } ?>" oninput="calculateCashReimbursement();" onkeypress="return isNumberKey(event)" required>  
              </div>

              <div class="form-group col-md-3">
                <label for="CASH_REIMBURSEMENT_PETROL">Cash Reimb. Petrol <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='CASH_REIMBURSEMENT_PETROL'  name='CASH_REIMBURSEMENT_PETROL' placeholder="Enter Cash Reimbursement Petrol" value="<?php if($user_edit->CASH_REIMBURSEMENT_PETROL!=''){ echo $user_edit->CASH_REIMBURSEMENT_PETROL; } ?>" oninput="calculateCashReimbursement();" onkeypress="return isNumberKey(event)" required>  
              </div>

              <div class="form-group col-md-3">
                <label for="TOTAL_CASH_REIMBURSEMENT">Total Cash Reimbursement <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='TOTAL_CASH_REIMBURSEMENT'  name='TOTAL_CASH_REIMBURSEMENT' placeholder="Enter Total Cash Reimbursement" value="<?php if($user_edit->TOTAL_CASH_REIMBURSEMENT!=''){ echo $user_edit->TOTAL_CASH_REIMBURSEMENT; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="DPT_PAYMENT_DATE">Payment Date <span style="color: #e22b0e;">*</span></label>
                <input type="hidden" class="pay_month_year" id='pay_month_year'  name='pay_month_year' value="<?php if(isset($_GET['paymonth'])){ echo $_GET['paymonth']; } ?>" required >  
                <input type="text" class="form-control DPT_PAYMENT_DATE" id='datepicker1'  name='DPT_PAYMENT_DATE' placeholder="Enter Payment Date" value="<?php if(isset($user_edit)){ echo $user_edit->DPT_PAYMENT_DATE; } ?>" required autocomplete="off" >  
                <input type="hidden" name="DEM_EMP_ID"  id="DEM_EMP_ID" value="<?php echo $_GET['DEM_EMP_ID']; ?>">
              </div>
              

              <div class="form-group col-md-3">
                <label for="DPT_INVOICE_NO">Payment Reference<span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DPT_INVOICE_NO'  name='DPT_INVOICE_NO' placeholder="Enter Payment Reference" value="<?php if(isset($user_edit)){ echo $user_edit->DPT_INVOICE_NO; } ?>" required >  
              </div>

              <div class="form-group col-md-12">   
                <center>             
                  <input type="submit" class="btn btn-primary btn-round" id='PAYMENT_SUBMIT'  name='PAYMENT_SUBMIT' value="Save Payment" > 
                  <input type="submit" name="PAYMENT_SUBMIT_LOCK" id="PAYMENT_SUBMIT_LOCK" class="btn btn-warning btn-round" value="Save & Lock Payment" > 
                </center>
              </div>

              <div class="form-group col-md-12">   
                <div class="msg"></div>
              </div> 

            </div>
          </form>
          <?php 
          }
          else
          {
            echo "<h4 style='color:red;'>Unable to get Employee details..! </h4>";
          }
           ?>
        </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
  <!-- /.content -->


  
<script type="text/javascript">
  function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode != 46 && charCode > 31
      && (charCode < 48 || charCode > 57))
          return false;

      return true;
  }
</script>

<script>
  function get_emp_payment_details()
  {
    var DPT_PAYMENT_DATE = $('.pay_month_year').val();  
    var DEM_EMP_ID = $('#DEM_EMP_ID').val();  

    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {DPT_PAYMENT_DATE:DPT_PAYMENT_DATE,DEM_EMP_ID:DEM_EMP_ID,get_emp_payment_details:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
      if(data){
        var ob = JSON.parse(data);
        if(ob.status=="success"){
          $('.msg').css('color','green').html(ob.message); // load response 
          $('#DPT_TOTAL_DAYS_WORKED').val(ob.total_attendance); 
          // $('#PAYMENT_SUBMIT').show(); 
        }else{
          // $('.msg').css('color','red').html(ob.message);
          $('#DPT_TOTAL_DAYS_WORKED').val(ob.total_attendance);           
          // $('#PAYMENT_SUBMIT').hide(); 

        }
        
      }      
      
    })
    .fail(function(){
      $('.msg').css('color','red').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      
    });
  } 

  function calculateCashReimbursement()
  {
    var CASH_REIMBURSEMENT_MOBILE = parseFloat($('#CASH_REIMBURSEMENT_MOBILE').val()) || 0;
    var CASH_REIMBURSEMENT_PETROL = parseFloat($('#CASH_REIMBURSEMENT_PETROL').val()) || 0;

    $('#TOTAL_CASH_REIMBURSEMENT').val(CASH_REIMBURSEMENT_MOBILE + CASH_REIMBURSEMENT_PETROL);
  }

</script>


<?php 
// if($_GET['paymonth']!=''){
  // echo "<script>get_emp_payment_details();</script>";
// }

 ?>
