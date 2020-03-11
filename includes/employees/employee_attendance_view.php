<?php
  
    $getuserdetails = $db->get_row("SELECT * FROM dw_employee_master WHERE  DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."' ");   
    // $db->debug();
?>

<!-- Main content -->
<form method="POST" enctype="multipart/form-data">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <?php  
          // prnt($_SESSION);
          $_SESSION['test']="rr";
          $toast_handler = $_SESSION['toast_handler']; 
          // prnt($_SESSION['toast_handler']);
  
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
              <font color="#3C8DBC" size="4px;">	<b>Employee Attendance </b></font>
              <span style="color: red; font-size: 18px; font-weight: 700;"></span>
              <br>
              <span class="msg"></span>
            </div>
          </div>
          <div class="box-tools">
            <input type="submit" name="save_attd" id="save_attd" class="btn btn-warning" value="Save Attendance">
            <input type="submit" name="save_lock_attd" id="save_lock_attd" class="btn btn-primary" value="Submit Attendance" onclick="save_lock_attd();">
          </div>  	
        </div>

        <div class="box-body">
          
            <div class="form-group col-md-12" >
              <?php if($getuserdetails){ ?>
              <h4 style="color: green;font-size: 18px;">Attendance of <?php echo $getuserdetails->DEM_EMP_FIRST_NAME." ".$getuserdetails->DEM_EMP_MIDDLE_NAME." ".$getuserdetails->DEM_EMP_LAST_NAME; ?> ( <?php echo $getuserdetails->DEM_EMP_ID; ?> )</h4>
              <?php } ?>
            </div>
            
            <div class="form-group col-md-3">
              <label style=" margin-left: 10px;">Select Year : <span style="color: red;">*</span></label>
              <select class="form-control" name="attd_year" id="attd_year" onchange="get_weeks_in_year();">
                <option value="">Select Year</option>
                <?php for($mc=1950;$mc<=2050;$mc++){ 

                ?>
                <option value="<?php echo $mc; ?>" <?php if(date('Y')==$mc){ echo "selected"; }  ?>><?php echo $mc; ?></option>
                <?php 
                if((date('Y')+1)==$mc){ break;  }
                } ?>
              </select>
              <input type="hidden" name="DEM_EMP_ID"  id="DEM_EMP_ID" value="<?php echo $_SESSION['DEM_EMP_ID']; ?>">

            </div>

            <div class="form-group col-md-3" >
              <label style="margin-left: 10px;">Select Week : <span style="color: red;">*</span></label>
              <select class="form-control" name="attd_month" id="attd_month" onchange="get_dates_attendance();">
                <option value="">Select Year First</option>                
                
              </select>
            </div>

            
            <div class="form-group col-md-12 getdate_container" style="margin-top:15px;">

            </div>

          <br>
        </div>
      </div>
<!-- /.box-body -->
    </div>
<!-- /.box -->
  </div>
<!-- /.col -->

</section>
</form>

<!-- Modal code for Employee Attendance-->
<div class="row">
  <div id="attd-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog"> 
      <div class="modal-content">            
        <div class="modal-header"> 
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button> 
          <h4 class="modal-title">
            Take Employee Attendance
          </h4> 
        </div> 
        <div class="modal-body">                  
          <div id="modal-loader" style="display: none; text-align: center;">
            <img src="ajax-loader.gif"  style="width: 150px;">
          </div>                         
          <div id="dynamic-content"></div>     
        </div> 
        <div class="modal-footer"> 
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
        </div>                   
      </div> 
    </div>
  </div><!-- /.modal -->   
</div>
  
<!-- End  Modal code for Employee Attendance -->


<script>
  function get_dates_attendance()
  {    
         
    var attd_year = $('#attd_year').val();   
    var attd_month = $('#attd_month').val();
    var DEM_EMP_ID = $('#DEM_EMP_ID').val(); 
    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {attd_year:attd_year,attd_month:attd_month,DEM_EMP_ID:DEM_EMP_ID,get_dates_attendance:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
          
      $('.getdate_container').html(data); // load response 
      
    })
    .fail(function(){
      $('.getdate_container').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      
    });
    
  }
  function get_weeks_in_year()
  {    
         
    var attd_year = $('#attd_year').val(); 
    $.ajax({
      url: 'get_weeks_in_year.php',
      type: 'POST',
      data: {attd_year:attd_year,get_weeks_in_year:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
          
      $('#attd_month').html(data); // load response 
      
    });
    
  }  
  function get_weeks_in_year1()
  {    
         
    var attd_year = $('#attd_year').val(); 
    $.ajax({
      url: 'get_weeks_in_year.php',
      type: 'POST',
      data: {attd_year:attd_year,get_weeks_in_year:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
          
      $('#attd_month').html(data); // load response 
      get_dates_attendance();
      
    });
    
  }
  $(document).ready(function(){
      get_weeks_in_year1();
      
  });

</script>

<script>
  function take_attendance()
  {  
    // alert($('#attd_date').val());
    if($('#attd_date').val()==''){
      $('.msg').css('color','red').html('Enter Attendance Date..!');
    }else if($('#DEA_IN_TIME').val()==''){
      $('.msg').css('color','red').html('Enter In Time..!');
    }else if($('#DEA_OUT_TIME').val()==''){
      $('.msg').css('color','red').html('Enter Out Time..!');
    }else if($('#DEA_CURRENT_LOCATION').val()==''){
      $('.msg').css('color','red').html('Select Location..!');
    }else if($('#DEM_EMP_ID').val()==''){
      $('.msg').css('color','red').html('No Employee ID Found..!');
    }else{ 
      $('#emp_attend_submit').attr('disabled',true);     
      var attd_date = $('#attd_date').val();   
      var DEA_IN_TIME = $('#DEA_IN_TIME').val();   
      var DEA_OUT_TIME = $('#DEA_OUT_TIME').val();   
      var DEA_CURRENT_LOCATION = $('#DEA_CURRENT_LOCATION').val();   
      var DEA_REMARK = $('#DEA_REMARK').val();  
      var DEA_SIGN = $('#DEA_SIGN').val();  
      var DEM_EMP_ID = $('#DEM_EMP_ID').val();  
      var DEA_ID = $('#DEA_ID').val();  

      
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {attd_date:attd_date,DEA_IN_TIME:DEA_IN_TIME,DEA_OUT_TIME:DEA_OUT_TIME,DEA_CURRENT_LOCATION:DEA_CURRENT_LOCATION,DEA_REMARK:DEA_REMARK,DEA_SIGN:DEA_SIGN,DEM_EMP_ID:DEM_EMP_ID,DEA_ID:DEA_ID,take_attendance:1},
        dataType: 'html'
      })
      .done(function(data){
        // console.log(data);  
        if(data){
            // $('.msg').css('color','green').html(data); // load response 
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
        $('.msg').css('color','red').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
        
      });
    }
    
  }


</script>

<script>
  function save_lock_attd()
  {        
    
    var DEM_EMP_ID = $('#DEM_EMP_ID').val();  

    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {DEM_EMP_ID:DEM_EMP_ID,save_lock_attd:1},
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
        
      } 
    })
    .fail(function(){
      $('.msg').css('color','red').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...!');
      
    });
  }
    
</script>


<script>
$(document).ready(function(){  
  $(document).on('click', '#trig-attd-model', function(e){    
    e.preventDefault();     
    var attd_date = $(this).data('id');   // it will get id of clicked row
    var DEM_EMP_ID = $('#DEM_EMP_ID').val();   // it will get id of clicked row
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {attd_date:attd_date,DEM_EMP_ID:DEM_EMP_ID,get_attd:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...!');
      $('#modal-loader').hide();
    });    
  });
}); 
</script>