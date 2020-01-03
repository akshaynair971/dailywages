

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


<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title"><label><i class="fa fa-book"></i> Select Month to Generate Attendance Report </label></h3>
      <div class="box-tools">
        <br><br>
        <form method="POST" action="?folder=reports&file=emp_report_single_month">
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
            <input type="hidden" name="att_type" value="single">
            <input type="submit" name="rep_attd_sub_sin_mon" value="Get Attendance Report" class="btn btn-primary btn-round">
            
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
    $( "#start_date" ).datepicker({      
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



