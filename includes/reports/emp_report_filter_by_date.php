

<style type="text/css">
.btn-primary
{
  margin-top: 10px;
}
.table-border{
  background-color: #337ab7;
}
.ui-datepicker-calendar {
  display: none;
}
</style>
<br>
<?php 
if($_SESSION['user_type']==1)
{
 ?>

<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><label><i class="fa fa-book"></i> Select Month to Generate Payment Report </label></h3>
      <div class="box-tools">
        <br><br>
        <form method="POST" action="?folder=reports&file=emp_report_single_month">
          <input type="hidden" name="curr_month_date" value="<?php echo date('Y-m'); ?>">
          <input type="submit" name="report_sub_sin_cur_mon" value="Current Month (<?php echo date('F Y'); ?>)" class="btn btn-success btn-round">
        </form>
        
      </div>
    </div>
    <div class="box-body">
      <form method="POST" action="?folder=reports&file=emp_report_single_month"><br>
        <div class="row">
          <div class="form-group col-md-12"> 
         	  <label>Select Date</label>
           	<input type="text" name="select_pay_month" id="select_pay_month" class="form-control" placeholder="Select Month" autocomplete="off" required>
          </div>

          <div class="col-md-12">
            <input type="submit" name="report_sub_sin_mon" value="Get Report" class="btn btn-primary btn-round">
            
          </div>
        </div>
      </form>
    </div>   
  </div>
</div>
<?php 
} ?>

<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><label><i class="fa fa-book"></i> Select Month to Generate Attendance Report </label></h3>
      <div class="box-tools">
        <br><br>
        <form method="POST" >
          <input type="hidden" name="curr_month_attd_date" value="<?php echo date('Y-m'); ?>">
          <input type="submit" name="rep_attd_sub_sin_cur_mon" value="Current Month (<?php echo date('F Y'); ?>)" class="btn btn-success btn-round">
        </form>
        
      </div>
    </div>
    <div class="box-body">
      <form method="POST"><br>
        <div class="row">
          <div class="form-group col-md-12"> 
            <label>Select Date</label>
            <input type="text" name="select_attd_month" id="select_attd_month" class="form-control" placeholder="Select Month" autocomplete="off" required>
          </div>

          <div class="col-md-12">
            
            <input type="submit" name="rep_attd_sub_sin_mon" value="Get Attendance Report" class="btn btn-primary btn-round">
            
          </div>
        </div>
      </form>
    </div>   
  </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><label><i class="fa fa-book"></i> Select Week to Generate Attendance Report </label></h3>
      <div class="box-tools">
        <!-- <br><br>
        <form method="POST" action="?folder=reports&file=emp_report_single_month">
          <input type="hidden" name="curr_month_attd_date" value="<?php echo date('Y-m'); ?>">
          <input type="submit" name="rep_attd_sub_sin_cur_mon" value="Current Month (<?php echo date('F Y'); ?>)" class="btn btn-success btn-round">
        </form> -->
        
      </div>
    </div>
    <div class="box-body">
      <form method="POST"><br>
        <div class="row">
          <div class="form-group col-md-6">
              <label style=" margin-left: 10px;">Select Year : <span style="color: red;">*</span></label>
              <select class="form-control" name="weekly_attd_year" id="weekly_attd_year" onchange="get_weeks_in_year();">
                <option value="">Select Year</option>
                <?php for($mc=1950;$mc<=2050;$mc++){ 

                ?>
                <option value="<?php echo $mc; ?>" <?php if(date('Y')==$mc){ echo "selected"; }  ?>><?php echo $mc; ?></option>
                <?php 
                if((date('Y'))==$mc){ break;  }
                } ?>
              </select> 
            </div>

            <div class="form-group col-md-6" >
              <label style="margin-left: 10px;">Select Week : <span style="color: red;">*</span></label>
              <select class="form-control" name="weekly_attd_week" id="weekly_attd_week" onchange="get_dates_attendance();">
                <option value="">Select Year First</option>                
                
              </select>
            </div>

          <div class="col-md-12">
            <input type="hidden" name="att_type" value="single">
            <input type="submit" name="get_weekly_attd_report" value="Get Weekly Attendance Report" class="btn btn-primary btn-round">
            
          </div>
        </div>
      </form>
    </div>   
  </div>
</div>

<!-- Generate Salary Slip Overview -->

<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><label><i class="fa fa-book"></i> Salary Summary Report </label></h3>
      <div class="box-tools">
        <!-- <br><br>
        <form method="POST" action="?folder=reports&file=emp_report_single_month">
          <input type="hidden" name="curr_month_attd_date" value="<?php echo date('Y-m'); ?>">
          <input type="submit" name="rep_attd_sub_sin_cur_mon" value="Current Month (<?php echo date('F Y'); ?>)" class="btn btn-success btn-round">
        </form> -->
        
      </div>
    </div>
    <div class="box-body">
      <form method="POST"><br>
        <div class="row">
          <div class="form-group col-md-12">
            <label style=" margin-left: 10px;">Select Employee <span style="color: red;">*</span></label>
            <select class="form-control select2" name="DEM_EMP_ID">
              <option>Select / Search Employee</option>
              <?php 
              $get_emp = $db->get_results("SELECT DEM_EMP_ID,DEM_EMP_NAME_PREFIX,DEM_EMP_FIRST_NAME,DEM_EMP_MIDDLE_NAME,DEM_EMP_LAST_NAME FROM dw_employee_master ORDER BY DEM_EMP_ID ASC");
              if($get_emp)
              {
                foreach ($get_emp as $get_empkey) {               
                ?>
                <option value="<?php echo $get_empkey->DEM_EMP_ID; ?>">(<?php echo $get_empkey->DEM_EMP_ID; ?>) <?php echo strtoupper($get_empkey->DEM_EMP_NAME_PREFIX." ".$get_empkey->DEM_EMP_FIRST_NAME." ".$get_empkey->DEM_EMP_MIDDLE_NAME." ".$get_empkey->DEM_EMP_LAST_NAME); ?> </option>
                <?php 
                }
              } ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label style=" margin-left: 10px;">From Month : <span style="color: red;">*</span></label>
            <input type="text" name="SAL_SUM_REP_FROM_DATE" id="SAL_SUM_REP_FROM_DATE" class="form-control" placeholder="Select From Month" autocomplete="off" required>
          </div>

          <div class="form-group col-md-6" >
            <label style="margin-left: 10px;">To Month : <span style="color: red;">*</span></label>
            <input type="text" name="SAL_SUM_REP_TO_DATE" id="SAL_SUM_REP_TO_DATE" class="form-control" placeholder="Select To Month" autocomplete="off" required>
          </div>

          <div class="col-md-12">            
            <input type="submit" name="get_salary_summary_report" value="Get Salary Summary Report" class="btn btn-primary btn-round">
            
          </div>
        </div>
      </form>
    </div>   
  </div>
</div>


<!-- <div class="col-lg-6 col-md-6 col-sm-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><label><i class="fa fa-book"></i> Select Start Month and End Month to Generate Payment Report </label></h3>
      <form method="POST"><br>
        <div class="row">
          <div class="form-group col-md-12"> 
            <label>Select Start Month</label>
            <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Select Start Month" autocomplete="off">
          </div>

          <div class="form-group col-md-12"> 
            <label>Select End Month</label>
            <input type="text" name="end_date" id="end_date" class="form-control" placeholder="Select End Month" autocomplete="off">
          </div>
          <div class="col-md-4">
            <input type="submit" name="report_sub_mul_mon" value="Get Report" class="btn btn-primary btn-round">
          </div>
        </div>
      </form>
    </div>   
  </div>
</div> -->



<script>
  $(function() {
    $( "#start_date,#SAL_SUM_REP_FROM_DATE,#SAL_SUM_REP_TO_DATE" ).datepicker({      
      dateFormat: "yy-mm",
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      yearRange: "1950:2050",
      onClose: function(dateText, inst) {
        function isDonePressed(){
          return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
        }

        if (isDonePressed()){
          var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
            
          $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
        }
      },
      beforeShow : function(input, inst) {

        inst.dpDiv.addClass('month_year_datepicker')

        if ((datestr = $(this).val()).length > 0) {
            year = datestr.substring(datestr.length-4, datestr.length);
            month = datestr.substring(0, 2);
            $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
            $(this).datepicker('setDate', new Date(year, month-1, 1));
            $(".ui-datepicker-calendar").hide();
        }
      } 
    });
  });
</script>

<script>
  $(function() {
    $( "#end_date" ).datepicker({      
      dateFormat: "mm/yy",
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      yearRange: "1950:2050",
      onClose: function(dateText, inst) {
        function isDonePressed(){
          return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
        }

        if (isDonePressed()){
          var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
            
          $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
        }
      },
      beforeShow : function(input, inst) {

        inst.dpDiv.addClass('month_year_datepicker')

        if ((datestr = $(this).val()).length > 0) {
            year = datestr.substring(datestr.length-4, datestr.length);
            month = datestr.substring(0, 2);
            $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
            $(this).datepicker('setDate', new Date(year, month-1, 1));
            $(".ui-datepicker-calendar").hide();
        }
      } 
    });
  });
</script>

<script>
  $(function() {
    $( "#select_pay_month" ).datepicker({      
      dateFormat: "yy-mm",
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      yearRange: "1950:2050",
      onClose: function(dateText, inst) {
        function isDonePressed(){
          return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
        }

        if (isDonePressed()){
          var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
            
          $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
        }
      },
      beforeShow : function(input, inst) {

        inst.dpDiv.addClass('month_year_datepicker')

        if ((datestr = $(this).val()).length > 0) {
            year = datestr.substring(datestr.length-4, datestr.length);
            month = datestr.substring(0, 2);
            $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
            $(this).datepicker('setDate', new Date(year, month-1, 1));
            $(".ui-datepicker-calendar").hide();
        }
      } 
    });
  });
</script>


<script>
  $(function() {
    $( "#select_attd_month" ).datepicker({      
      dateFormat: "yy-mm",
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      yearRange: "1950:2050",
      onClose: function(dateText, inst) {
        function isDonePressed(){
          return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
        }

        if (isDonePressed()){
          var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
            
          $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
        }
      },
      beforeShow : function(input, inst) {

        inst.dpDiv.addClass('month_year_datepicker')

        if ((datestr = $(this).val()).length > 0) {
            year = datestr.substring(datestr.length-4, datestr.length);
            month = datestr.substring(0, 2);
            $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
            $(this).datepicker('setDate', new Date(year, month-1, 1));
            $(".ui-datepicker-calendar").hide();
        }
      } 
    });
  });
</script>

<script>
  function get_weeks_in_year()
  {    
         
    var attd_year = $('#weekly_attd_year').val(); 
    $.ajax({
      url: 'get_weeks_in_year.php',
      type: 'POST',
      data: {attd_year:attd_year,get_weeks_in_yearfor_report:1},
      dataType: 'html'
    })
    .done(function(data){
      // console.log(data);  
          
      $('#weekly_attd_week').html(data); // load response 
      
    });
    
  } 

  $(document).ready(function(){
    get_weeks_in_year();
    
  }); 
</script>





