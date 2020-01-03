
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
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
          ?>
          <div class="row">
            <div colspan="{$colSpan}" align="center" id="date_heading" >
              <font color="#3C8DBC" size="4px;">	<b>Payroll Details </b></font>
              <span style="color: red; font-size: 18px; font-weight: 700;"></span>
              <br>
              <span class="msg"></span>
            </div>
          </div>
          <div class="box-tools">
            <?php 
            if($_SESSION['user_type']=="1"){ ?>
            <a href="?folder=employees&file=admin_employee_attendance_view" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          <?php 
          } ?>
            
            <?php 
              if($_GET['DEM_EMP_ID']){
            ?>
            <input type="button" name="save_lock_attd" id="save_lock_attd" class="btn btn-primary" value="Save & Lock Payment Details" onclick="save_lock_payd();">
            <?php 
            } ?>
          </div>  	
        </div>

        <div class="box-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group col-md-12" >
              
              <h4 style="color: green;font-size: 18px;">Months of Year <?php echo date("Y"); ?></h4>
              <input type="hidden" name="DEM_EMP_ID"  id="DEM_EMP_ID" value="<?php echo $_SESSION['DEM_EMP_ID']; ?>">
            </div>            
            <div class="form-group col-md-12 table-responsive">
              <?php 
              if($_GET['DEM_EMP_ID']){

                $getuserdetails = $db->get_row("SELECT * FROM dw_employee_master WHERE  DEM_EMP_ID='".$_GET['DEM_EMP_ID']."' ");   

               ?>
               <h4 style="color: green;font-size: 18px;">Payroll Track of <?php echo strtoupper($getuserdetails->DEM_EMP_FIRST_NAME." ".$getuserdetails->DEM_EMP_MIDDLE_NAME." ".$getuserdetails->DEM_EMP_LAST_NAME); ?> ( <?php echo $getuserdetails->DEM_EMP_ID; ?> )</h4>
             
              <table class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
                <thead>
                  <tr>
                    <th style="border: 1px solid black !important;">MONTH & YEAR</th>
                    <th style="border: 1px solid black !important;">Pay Status</th>
                    <th style="border: 1px solid black !important;">Payment Date</th>
                    <th style="border: 1px solid black !important;">Total Days Worked</th>
                    <th style="border: 1px solid black !important;">Total GW Hours</th>
                    <th style="border: 1px solid black !important;">Total Deduction</th>
                    <th style="border: 1px solid black !important;">Net Wages Paid</th>
                    <th style="border: 1px solid black !important;">Payment Refereance</th>
                    <th style="border: 1px solid black !important;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $dyear = date("Y");
                  for($cnt=1;$cnt<=12; $cnt++){
                    $dyearmon = date('Y-m',strtotime($dyear."-".$cnt));
                      
                      $getpaydet = $db->get_row("SELECT * FROM dw_payment_tracker WHERE DPT_PAYMENT_YEAR='$dyear' AND DPT_PAYMENT_MONTH='$cnt' AND DEM_EMP_ID='$getuserdetails->DEM_EMP_ID'");
                    
                    

                  ?>
                    <tr>
                      <td style="border: 1px solid black !important;"><?php echo date('F - Y',strtotime($dyearmon)); ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet){ echo "PAID"; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet->DPT_PAYMENT_DATE){ echo $getpaydet->DPT_PAYMENT_DATE; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet->DPT_TOTAL_DAYS_WORKED){ echo $getpaydet->DPT_TOTAL_DAYS_WORKED; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet->DPT_TOTAL_GW_HRS){ echo $getpaydet->DPT_TOTAL_GW_HRS; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet->TOTAL_DEDUCTION){ echo $getpaydet->TOTAL_DEDUCTION; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet->DPT_NET_WAGES_PAID){ echo $getpaydet->DPT_NET_WAGES_PAID; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;"><?php if($getpaydet->DPT_INVOICE_NO){ echo $getpaydet->DPT_INVOICE_NO; }else{ echo "--"; } ?></td>
                      <td style="border: 1px solid black !important;">
                        <?php if($getpaydet->DPT_STATUS!='0' || $_SESSION['user_type']=="1"){
                          ?>
                          <a class="btn btn-primary" href="?folder=employees&file=payment_tracker_add&DEM_EMP_ID=<?php echo $getuserdetails->DEM_EMP_ID; ?>&paymonth=<?php echo $dyearmon; ?><?php if($getpaydet){ ?>&DPT_ID=<?php echo $getpaydet->DPT_ID; } ?>">ADD / UPDATE</a>
                          <?php 
                          }
                           ?>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
              <?php 
              }else{
                echo "<h4 style='color:red;'>Unable to get Employee details..! </h4>";
              } ?>
            </div>
            
          </form><br>
        </div>
      </div>
<!-- /.box-body -->
    </div>
<!-- /.box -->
  </div>
<!-- /.col -->

</section>


<script>
  function save_lock_payd()
  {        
    
    var DEM_EMP_ID = $('#DEM_EMP_ID').val();  

    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {DEM_EMP_ID:DEM_EMP_ID,save_lock_payd:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
      if(data){
        var ob = JSON.parse(data);
        if(ob.status=="success"){
          $('.msg').css('color','green').html(ob.message); // load response 

        }else{
          $('.msg').css('color','red').html(ob.message);
        }
        setTimeout(function(){// wait for 5 secs(2)
             location.reload(); // then reload the page.(3)
          }, 1000);
        
      } 
    })
    .fail(function(){
      $('.msg').css('color','red').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...!');
      
    });
  }
    
</script>



