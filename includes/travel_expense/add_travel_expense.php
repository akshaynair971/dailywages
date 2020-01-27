<?php
  if(isset($_GET['DTE_ID']) && $_GET['DTE_ID']!='')
  {
    extract($_GET);
    $gettravel = $db->get_row("SELECT * FROM dw_travel_expense WHERE DTE_ID='$DTE_ID'");

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
          <h3>Add Travel & Expense</h3>
          <div class="box-tools">
            <a href="?folder=travel_expense&file=travel_expense_list" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
            <!-- /.box-header -->
        <div class="box-body">         
           
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12 col-xs-12"> 
              
              <div class="form-group col-md-6">
                <label for="DEM_EMP_ID">Select Employee<span style="color: #e22b0e;">*</span></label> .
                <?php  
                if($_SESSION['DEM_EMP_ID']!='')
                {
                  $get_emps = $db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");  
                }else{
                  $get_emps = $db->get_results("SELECT * FROM dw_employee_master");  
                }
                                  
                  ?>
                <select class="form-control DEM_EMP_ID select2" id='DEM_EMP_ID'  name='DEM_EMP_ID' required>
                  <option value="">Select Employee</option>
                  <?php 
                  foreach($get_emps as $get_emp){ ?>
                    <option value="<?php echo $get_emp->DEM_EMP_ID; ?>" <?php if($get_emp->DEM_EMP_ID== $gettravel->DEM_EMP_ID) { echo "selected"; }elseif($_SESSION['DEM_EMP_ID']){ echo "selected"; } ?>><?php echo strtoupper($get_emp->DEM_EMP_NAME_PREFIX." ".$get_emp->DEM_EMP_FIRST_NAME." ".$get_emp->DEM_EMP_MIDDLE_NAME." ".$get_emp->DEM_EMP_LAST_NAME." (".$get_emp->DEM_EMP_ID.")");    ?>  </option>
                  <?php 
                  } ?>
                  
                </select>                                  
              </div> 

              <!-- <div class="form-group col-md-3">
                <label for="DTE_VOUCHER_REF">Voucher Ref. <span style="color: #e22b0e;">*</span></label>  
                <input type="text" class="form-control DTE_VOUCHER_REF" id='DTE_VOUCHER_REF'  name='DTE_VOUCHER_REF' placeholder="Enter Voucher Ref." value="<?php if(isset($gettravel)){ echo $gettravel->DTE_VOUCHER_REF; } ?>" required autocomplete="off" disabled >                  
              </div>  -->  

              <div class="form-group col-md-3">
                <label for="DTE_VOUCHER_DATE">Voucher Date <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DTE_VOUCHER_DATE1'  name='DTE_VOUCHER_DATE' placeholder="Enter Voucher Date" value="<?php if(isset($gettravel)){ echo $gettravel->DTE_VOUCHER_DATE; }else{ echo date('Y-m-d'); } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="DTE_DEPARTED_DATE">Departed Date <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DTE_DEPARTED_DATE'  name='DTE_DEPARTED_DATE' placeholder="Enter Departed Date" value="<?php if(isset($gettravel)){ echo $gettravel->DTE_DEPARTED_DATE; } ?>" required autocomplete="off" >  
              </div>

              <div class="form-group col-md-3">
                <label for="DTE_RETURNED_DATE">Returned Date <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DTE_RETURNED_DATE'  name='DTE_RETURNED_DATE' placeholder="Enter Returned Date" value="<?php if(isset($gettravel)){ echo $gettravel->DTE_RETURNED_DATE; } ?>" required autocomplete="off">  
              </div>

              <div class="form-group col-md-3">
                <label for="DTE_LOCATION">Location <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DTE_LOCATION'  name='DTE_LOCATION' placeholder="Enter Total Deduction" value="<?php if($gettravel->DTE_LOCATION!=''){ echo $gettravel->DTE_LOCATION; }elseif($totaldeduction!=''){ echo $totaldeduction; } ?>" required >  
              </div>

              <div class="form-group col-md-12">
                <table class="table table-bordered" id="item_table">
                  <thead>
                    <tr>
                      <th class="text-center" style="font-size: 13px;">Date <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Place <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Travel <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Conveyance <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">L/B <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Extra <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Total <span style="color: red;font-size: 15px;">*</span></th>

                      <th class="text-center" style="font-size: 13px;">Remarks </th>

                      <th class="text-center" style="width:4%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button><br>
                      <span style="font-size: 10px; color: red;">Click..</span></th>
                    </tr>
                  </thead>
                  <tbody id="item_table">
                  <?php 
                  $json = json_decode($gettravel->DTE_TRAVEL_SUMMARY);
                  if($json){
                    
                    $rowCount=0;
                    for ($i=0; $i < count($json->JOURNEY_DATE); $i++){
                      $rowCount++; 
                      ?>                         
                      <tr>
                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='JOURNEY_DATE<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[JOURNEY_DATE][]' placeholder="Enter Date" value="<?php if($json->JOURNEY_DATE[$i]!=''){ echo $json->JOURNEY_DATE[$i]; } ?>" required autocomplete="off" >
                        </th>  

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='JOURNEY_PLACE<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[JOURNEY_PLACE][]' placeholder="Enter Date" value="<?php if($json->JOURNEY_PLACE[$i]!=''){ echo $json->JOURNEY_PLACE[$i]; } ?>" required >
                        </th>  

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='TRAVEL_CHRG<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[TRAVEL_CHRG][]' placeholder="Enter Date" value="<?php if($json->TRAVEL_CHRG[$i]!=''){ echo $json->TRAVEL_CHRG[$i]; }else{ echo "0"; } ?>" required  oninput="cal_payment(<?php echo $rowCount; ?>);" onkeypress="return isNumberKey(event)">
                        </th> 

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='CONVEY_CHRG<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[CONVEY_CHRG][]' placeholder="Enter Date" value="<?php if($json->CONVEY_CHRG[$i]!=''){ echo $json->CONVEY_CHRG[$i]; }else{ echo "0"; } ?>" required oninput="cal_payment(<?php echo $rowCount; ?>);" onkeypress="return isNumberKey(event)">
                        </th> 

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='L_B_CHRG<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[L_B_CHRG][]' placeholder="Enter Date" value="<?php if($json->L_B_CHRG[$i]!=''){ echo $json->L_B_CHRG[$i]; }else{ echo "0"; } ?>" required oninput="cal_payment(<?php echo $rowCount; ?>);" onkeypress="return isNumberKey(event)">
                        </th> 

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='EXTRA_CHRG<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[EXTRA_CHRG][]' placeholder="Enter Date" value="<?php if($json->EXTRA_CHRG[$i]!=''){ echo $json->EXTRA_CHRG[$i]; }else{ echo "0"; } ?>" required oninput="cal_payment(<?php echo $rowCount; ?>);" onkeypress="return isNumberKey(event)">
                        </th>    

                        <th style="font-size: 13px;">
                          <input type="text" class="form-control" id='TOTAL_CHRG<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[TOTAL_CHRG][]' placeholder="Enter Date" value="<?php if($json->TOTAL_CHRG[$i]!=''){ echo $json->TOTAL_CHRG[$i]; } ?>" required readonly>
                        </th>      

                        <th style="font-size: 13px;">
                          <textarea class="form-control" id='REMARKS<?php echo $rowCount; ?>'  name='DTE_TRAVEL_SUMMARY[REMARKS][]' placeholder="Enter Remarks"><?php if($json->REMARKS[$i]!=''){ echo $json->REMARKS[$i]; } ?></textarea>
                        </th>                            

                                                        
                        <th style="width:4%;">
                          <button type="button" name="remove" class="btn btn-danger btn-sm remove" onclick="setValue()"><span class="glyphicon glyphicon-minus"></span></button><br><span style="font-size: 10px; color: red;">Click Here..</span>
                        </th>
                      </tr>
                      <script>
                        rowCount++;
                        $(document).ready(function(){
                          $("#JOURNEY_DATE<?php echo $rowCount; ?>").datepicker({
                              dateFormat: 'yy-mm-dd',
                              changeMonth: true,
                              changeYear: true,
                              yearRange: "1970:2050"
                            }); 
                        });                       
                      </script>
                    <?php 
                    }  
                  } ?>
                  </tbody>
                </table>                
              </div>
              

              <div class="form-group col-md-12">   
                <center>  
                  <!-- <input type="hidden" name="DEM_EMP_ID"  id="DEM_EMP_ID" value="<?php echo $_GET['DEM_EMP_ID']; ?>">            -->
                  <input type="submit" class="btn btn-warning btn-round" id='SAVE_TRAVEL_EXP'  name='SAVE_TRAVEL_EXP' value="Save Travel Expense" >  
                  <input type="submit" class="btn btn-primary btn-round" id='SAVE_LOCK_TRAVEL_EXP'  name='SAVE_LOCK_TRAVEL_EXP' value="Save & Lock Travel Expense" >  
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
    $( "#DTE_VOUCHER_DATE,#DTE_DEPARTED_DATE,#DTE_RETURNED_DATE" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "1970:2050"
    });
  });


function cal_payment(ident) {
   
  var TRAVEL_CHRG= parseFloat($('#TRAVEL_CHRG'+ident).val()) || 0; 
  var CONVEY_CHRG= parseFloat($('#CONVEY_CHRG'+ident).val()) || 0;
  var L_B_CHRG= parseFloat($('#L_B_CHRG'+ident).val()) || 0;
  var EXTRA_CHRG= parseFloat($('#EXTRA_CHRG'+ident).val()) || 0;
  
  var TOTAL_CHRG=  TRAVEL_CHRG+CONVEY_CHRG+L_B_CHRG+EXTRA_CHRG;
  $('#TOTAL_CHRG'+ident).val(TOTAL_CHRG);

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

      html += '<td><input type="text" class="form-control" id="JOURNEY_DATE'+rowCount+'" placeholder="Enter Journey Date" name="DTE_TRAVEL_SUMMARY[JOURNEY_DATE][]" autocomplete="off" ></td>';

      html += '<td><input type="text" class="form-control" id="JOURNEY_PLACE'+rowCount+'" placeholder="Enter Journey Place " name="DTE_TRAVEL_SUMMARY[JOURNEY_PLACE][]" required ></td>';

      html += '<td><input type="text" class="form-control" id="TRAVEL_CHRG'+rowCount+'" placeholder="Enter Travel Charges" name="DTE_TRAVEL_SUMMARY[TRAVEL_CHRG][]" required oninput="cal_payment('+rowCount+');" onkeypress="return isNumberKey(event)" value="0"></td>';

      html += '<td><input type="text" class="form-control" id="CONVEY_CHRG'+rowCount+'" placeholder="Enter Conveyance Charges" name="DTE_TRAVEL_SUMMARY[CONVEY_CHRG][]" required oninput="cal_payment('+rowCount+');" onkeypress="return isNumberKey(event)" value="0"></td>';

      html += '<td><input type="text" class="form-control" id="L_B_CHRG'+rowCount+'" placeholder="Enter L/B" name="DTE_TRAVEL_SUMMARY[L_B_CHRG][]" required oninput="cal_payment('+rowCount+');" onkeypress="return isNumberKey(event)" value="0"></td>';

      html += '<td><input type="text" class="form-control" id="EXTRA_CHRG'+rowCount+'" placeholder="Enter Extra Charges" name="DTE_TRAVEL_SUMMARY[EXTRA_CHRG][]" required oninput="cal_payment('+rowCount+');" onkeypress="return isNumberKey(event)" value="0"></td>';

      html += '<td><input type="text" class="form-control" id="TOTAL_CHRG'+rowCount+'" placeholder="Enter Total Charges" name="DTE_TRAVEL_SUMMARY[TOTAL_CHRG][]" required readonly ></td>';

      html += '<td><textarea class="form-control" id="REMARKS'+rowCount+'" placeholder="Enter Remarks" name="DTE_TRAVEL_SUMMARY[REMARKS][]" ></textarea></td>';

      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button><br><span style="font-size: 10px; color: red;">Click..</span></td></tr>';

      $('#item_table').append(html);
      $( "#JOURNEY_DATE"+rowCount).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: "1970:2050"
      }); 
     });
 
     
     $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
        
     });
     
    });
    </script>