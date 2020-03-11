<?php
  if(isset($_GET['DGE_ID']) && $_GET['DGE_ID']!='')
  {
    extract($_GET);
    $get_expense = $db->get_row("SELECT * FROM dw_general_expenses WHERE DGE_ID='$DGE_ID'");

  }
?>

<script type="text/javascript">
  var rowCount = 0;
</script>
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
          <h3>Add General Expense</h3>
          <div class="box-tools">
            <a href="?folder=general_expense&file=general_expense_list" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
            <!-- /.box-header -->
        <div class="box-body">         
           
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12 col-xs-12"> 
              
              <div class="form-group col-md-6">
                <label for="DEM_EMP_ID">Select Employee<span style="color: #e22b0e;">*</span></label> 
                <select class="form-control select2" name="DEM_ID" readonly>
                  <option>Select / Search Employee</option>
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

              <!-- <div class="form-group col-md-3">
                <label for="DTE_VOUCHER_REF">Voucher Ref. <span style="color: #e22b0e;">*</span></label>  
                <input type="text" class="form-control DTE_VOUCHER_REF" id='DTE_VOUCHER_REF'  name='DTE_VOUCHER_REF' placeholder="Enter Voucher Ref." value="<?php if(isset($gettravel)){ echo $gettravel->DTE_VOUCHER_REF; } ?>" required autocomplete="off" disabled >                  
              </div>  -->  

              <div class="form-group col-md-3">
                <label for="DGE_VOUCHER_DATE">Voucher Date <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DGE_VOUCHER_DATE'  name='DGE_VOUCHER_DATE' placeholder="Enter Voucher Date" value="<?php if(isset($get_expense)){ echo $get_expense->DGE_VOUCHER_DATE; }else{ echo date('Y-m-d'); } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="DGE_INVOICE_NO">Invoice No. <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DGE_INVOICE_NO'  name='DGE_INVOICE_NO' placeholder="Enter Invoice No." value="<?php if(isset($get_expense)){ echo $get_expense->DGE_INVOICE_NO; } ?>" required autocomplete="off" >  
              </div>

              <div class="form-group col-md-3">
                <label for="DGE_INVOICE_DATE">Invoice Date <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DGE_INVOICE_DATE'  name='DGE_INVOICE_DATE' placeholder="Enter Invoice Date" value="<?php if(isset($get_expense)){ echo $get_expense->DGE_INVOICE_DATE; } ?>" required autocomplete="off">  
              </div>

              <div class="form-group col-md-3">
                <label for="DGE_LOCATION">Location <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DGE_LOCATION'  name='DGE_LOCATION' placeholder="Enter Location" value="<?php if($get_expense->DGE_LOCATION!=''){ echo $get_expense->DGE_LOCATION; } ?>" required onkeyup="$(this).val($(this).val().toUpperCase());" >  
              </div>

              

              <div class="form-group col-md-12">
                <table class="table table-bordered" id="item_table">
                  <thead>
                    <tr>
                      <th class="text-center" style="font-size: 13px;">Sr No. <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Item <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Amount <span style="color: red;font-size: 15px;">*</span></th>

                    <!--   <th class="text-center" style="font-size: 13px;">Conveyance <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">L/B <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Extra <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Total <span style="color: red;font-size: 15px;">*</span></th> -->

                      <th class="text-center" style="font-size: 13px;">Remarks </th>

                      <th class="text-center" style="width:4%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button><br>
                      <span style="font-size: 10px; color: red;">Click..</span></th>
                    </tr>
                  </thead>
                  <tbody id="item_table">
                  <?php 
                  $json = json_decode($get_expense->DGE_EXPENSE_SUMMARY);
                  if($json){
                    
                    $rowCount=0;
                    for ($i=0; $i < count($json->DGE_ITEM); $i++){
                      $rowCount++; 
                      ?>                         
                      <tr>
                        <th style="font-size: 13px;">
                          <?php echo $rowCount; ?>
                        </th>  

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control DGE_ITEM" id='DGE_ITEM<?php echo $rowCount; ?>'  name='DGE_EXPENSE_SUMMARY[DGE_ITEM][]' placeholder="Enter Item Name" value="<?php if($json->DGE_ITEM[$i]!=''){ echo $json->DGE_ITEM[$i]; } ?>" required  onkeyup="$(this).val($(this).val().toUpperCase());"  >
                        </th>  

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control DGE_AMOUNT" id='DGE_AMOUNT<?php echo $rowCount; ?>'  name='DGE_EXPENSE_SUMMARY[DGE_AMOUNT][]' placeholder="Enter Amount" value="<?php if($json->DGE_AMOUNT[$i]!=''){ echo $json->DGE_AMOUNT[$i]; }else{ echo "0"; } ?>" required  oninput="cal_payment();" onkeypress="return isNumberKey(event)">
                        </th> 
                         

                        <th style="font-size: 13px;">
                          <textarea class="form-control DGE_REMARKS" id='DGE_REMARKS<?php echo $rowCount; ?>'  name='DGE_EXPENSE_SUMMARY[DGE_REMARKS][]' placeholder="Enter DGE_Remarks"  onkeyup="$(this).val($(this).val().toUpperCase());" ><?php if($json->DGE_REMARKS[$i]!=''){ echo $json->DGE_REMARKS[$i]; } ?></textarea>
                        </th>                            

                                                        
                        <th style="width:4%;">
                          <button type="button" name="remove" class="btn btn-danger btn-sm remove" onclick="setValue()"><span class="glyphicon glyphicon-minus"></span></button><br><span style="font-size: 10px; color: red;">Click Here..</span>
                        </th>
                      </tr>
                      <script>
                        rowCount++;
                        // $(document).ready(function(){
                        //   $("#JOURNEY_DATE<?php echo $rowCount; ?>").datepicker({
                        //       dateFormat: 'yy-mm-dd',
                        //       changeMonth: true,
                        //       changeYear: true,
                        //       yearRange: "1970:2050"
                        //     }); 
                        // });                       
                      </script>
                    <?php 
                    }  
                  } ?>
                  </tbody>
                </table>                
              </div>

              <div class="form-group col-md-3">
                <label for="DGE_TOTAL">Total Expense <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DGE_TOTAL'  name='DGE_TOTAL' placeholder="Enter Total Expense" value="<?php if($get_expense->DGE_TOTAL!=''){ echo $get_expense->DGE_TOTAL; }else{ echo "0"; } ?>" required  readonly>  
              </div>
              

              <div class="form-group col-md-12">   
                <center>  
                  <!-- <input type="hidden" name="DEM_EMP_ID"  id="DEM_EMP_ID" value="<?php echo $_GET['DEM_EMP_ID']; ?>">            -->
                  <input type="submit" class="btn btn-warning btn-round" id='SAVE_GENERAL_EXP'  name='SAVE_GENERAL_EXP' value="Save General Expense" >  
                  <input type="submit" class="btn btn-primary btn-round" id='SAVE_LOCK_GENERAL_EXP'  name='SAVE_LOCK_GENERAL_EXP' value="<?php if($_SESSION['user_type']==1){ echo "Approve"; } if($_SESSION['user_type']==2){ echo "Submit"; } ?> General Expense" >  
                </center>
              </div>

              <div class="form-group col-md-12">   
                <div class="msg"></div>
              </div> 

            </div>
          </form>
          
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

  <script>
  $(function() {
    // $("#DTE_RETURNED_DATE").change(function () {
    //     var DTE_DEPARTED_DATE = document.getElementById("DTE_DEPARTED_DATE").value;
    //     var DTE_RETURNED_DATE = document.getElementById("DTE_RETURNED_DATE").value;

    //     if ((Date.parse(DTE_DEPARTED_DATE) >= Date.parse(DTE_RETURNED_DATE))) {
    //         alert("Returned Date should be greater than Departed date");
    //         document.getElementById("DTE_RETURNED_DATE").value = "";
    //     }
    // });

    $( "#DGE_INVOICE_DATE" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "1950:2050"
    });
  });


function cal_payment() {

  var DGE_TOTAL=0;
  $('.DGE_AMOUNT').each(function(){
    var DGE_AMOUNT= parseFloat($(this).val()) || 0; 
    // alert(DGE_AMOUNT);
    DGE_TOTAL +=DGE_AMOUNT;
  });
  
  $('#DGE_TOTAL').val(DGE_TOTAL);

}


  </script>
  
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
    $(document).ready(function(){
      
     $(document).on('click','.add', function(){
      rowCount++;
       // alert(rowCount);
      var html = '';
      html += '<tr>';

      html += '<td>'+rowCount+'</td>';

      html += '<td><input type="text" class="form-control DGE_ITEM" id="DGE_ITEM'+rowCount+'" placeholder="Enter Item Detail" name="DGE_EXPENSE_SUMMARY[DGE_ITEM][]" required onkeyup="$(this).val($(this).val().toUpperCase());" ></td>';

      html += '<td><input type="text" class="form-control DGE_AMOUNT" id="DGE_AMOUNT'+rowCount+'" placeholder="Enter Item Charges" name="DGE_EXPENSE_SUMMARY[DGE_AMOUNT][]" required oninput="cal_payment();" onkeypress="return isNumberKey(event)" value="0"></td>';
      

      html += '<td><textarea class="form-control DGE_REMARKS" id="REMARKS'+rowCount+'" placeholder="Enter Remarks" name="DGE_EXPENSE_SUMMARY[REMARKS][]"  onkeyup="$(this).val($(this).val().toUpperCase());"  ></textarea></td>';

      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button><br><span style="font-size: 10px; color: red;">Click..</span></td></tr>';

      $('#item_table').append(html);
     //  $( "#JOURNEY_DATE"+rowCount).datepicker({
     //    dateFormat: 'yy-mm-dd',
     //    changeMonth: true,
     //    changeYear: true,
     //    yearRange: "1970:2050"
     //  }); 
     });
    <?php 
    if(!isset($_GET['DGE_ID']))
    { 
      ?>
    $('.add').trigger('click');
    <?php 
    } 
      ?> 
     $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
        
     });
     
    });
    </script>
<!-- 
    <script type="text/javascript">
  $(function() {
    $('#DGE_LOCATION').keyup(function(){

      $(this).val($(this).val().toUpperCase());
    });
  });
</script> -->