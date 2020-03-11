

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
              <font color="#3C8DBC" size="4px;">  <b>Employee Attendance & Payroll Details</b></font>
              <span style="color: red; font-size: 18px; font-weight: 700;"></span>
            </div>  
          </div>  
        </div>

        <div class="box-body">
          <form method="POST" enctype="multipart/form-data">            
            <div class="form-group col-md-12" >
              <label >Search User For Attendance or Payroll Details </label>
              <input type="text" name="searchemp_for_attd" id="searchemp_for_attd" class="form-control" placeholder="Enter Employee ID, Employee Name or Employee Mobile number to Search...!" oninput="search_emp_for_attd();" >              
            </div>

            <div class="form-group col-md-12 getdate_container table-responsive" style="margin-top:15px;">

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
  function search_emp_for_attd()
  {    
         
    var searchemp_for_attd = $('#searchemp_for_attd').val();

    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {searchemp_for_attd:searchemp_for_attd},
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

</script>
