
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
              <font color="#3C8DBC" size="4px;">	<b>Payment Tracker </b></font>
              <span style="color: red; font-size: 18px; font-weight: 700;"></span>
              <br>
              <span class="msg"></span>
            </div>
          </div>
          <div class="box-tools">
            <input type="button" name="save_lock_attd" id="save_lock_attd" class="btn btn-primary" value="Save & Lock Payment Details" onclick="save_lock_payd();">
          </div>  	
        </div>

        <div class="box-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group col-md-12" >
              
              <h4 style="color: green;font-size: 18px;">Months of Year <?php echo date("Y"); ?></h4>
              <input type="hidden" name="DEM_EMP_ID"  id="DEM_EMP_ID" value="<?php echo $_SESSION['DEM_EMP_ID']; ?>">
            </div>            
            <div class="form-group col-md-12 table-responsive">
              <table class="table table-bordered table-responsive">
                <thead>
                  <tr>
                    <th>MONTH & YEAR</th>
                    <th>Pay Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $dyear = date("Y");
                  for($cnt=1;$cnt<=12; $cnt++){
                    $dyearmon = date('Y-m',strtotime($dyear."-".$cnt));
                    $getpaydet = $db->get_row("SELECT * FROM dw_payment_tracker WHERE DPT_PAYMENT_YEAR='$dyear' AND DPT_PAYMENT_MONTH='$cnt'");

                  ?>
                    <tr>
                      <td><?php echo date('F - Y',strtotime($dyearmon)); ?></td>
                      <td><?php if($getpaydet){ echo "PAID"; }else{ echo "--"; } ?></td>
                      <td>
                        <?php if($getpaydet->DPT_STATUS!='0'){
                          ?>
                          <a class="btn btn-primary" href="?folder=employees&file=payment_tracker_add&paymonth=<?php echo $dyearmon; ?><?php if($getpaydet){ ?>&DPT_ID=<?php echo $getpaydet->DPT_ID; } ?>">ADD / UPDATE PAYMENT</a>
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



